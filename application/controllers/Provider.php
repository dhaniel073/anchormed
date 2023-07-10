<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

define('MODULE_NO', 10);
define('TITLE', 'HMO Central');
define('SUB_MODULE_NO', 3);
define('ADMIN', 3);

define('INVALID_FUNCTION_CALL', 'Action not permitted');

class Provider extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('passwordhash', array('iteration_count_log2' => 8, 'portable_hashes' => FALSE));
        $this->load->model('ult');
        $this->load->model('staff_master_model');
        $this->load->model('profile_pics_model');
        $this->load->model('module_map_model');
        $this->load->model('role_model');
        $this->load->model('hmo_model');
        $this->load->model('department_model');
        $this->load->model('appointment_model');
        $this->load->model('daily_schedule_model');
        $this->load->model('patient_model');
        $this->load->model('sub_module_map_model');
        $this->load->model('user_groups_model');
        $this->load->model('shift_model');
        $this->load->model('general_update_model');
        $this->load->model('bill_master_model');
        $this->load->model('state_model');
        $this->load->model('country_model');
        $this->load->model('general_update_model');
        $this->load->model('bills_model');
        $this->load->model('hmo_bills_model');
        $this->load->model('hmo_transactions_model');
        $this->load->library('services/bill_service');
        $this->load->helper('date');
        $this->utilities->loadUserLang();


    }

    private function confirmUrl()
    {
        if ($this->session->userdata('base_url') != base_url()) {
            redirect("/logout");
        }

    }

    public function create()
    {

        $this->utilities->aunthenticateAccess(CREATE_PROVIDER, "provider");


        if (!$this->input->post('hmo_code') || !$this->input->post('hmo_name')) {
            $array = array('notice' => INVALID_FUNCTION_CALL);
            $this->session->set_userdata($array);
            redirect("/provider");
        }

        $code = $this->hmo_model->getHmo($this->input->post('hmo_code'));
        if (sizeof($code) > 1) {
            $array = array('notice' => "Provider Code Already Exists");
            $this->session->set_userdata($array);
            redirect("/provider");

        }

        $this->hmo_model->quick_set_HMO();

        $this->utilities->redirectWithNotice("provider", $this->lang->line(CREATE_PROVIDER_SUCCESS));


    }

    public function generateBill($hmo_code)
    {
        $this->utilities->aunthenticateAccess(GENERATE_HMO_BILL, "provider");

        if (!$hmo_code) {
            $this->utilities->redirectWithNotice("provider", $this->lang->line(INVALID_FUNC_CALL));
        }


        $provider = $this->hmo_model->getHmo($hmo_code);

        if (!$provider) {
            $this->utilities->redirectWithNotice("provider", $this->lang->line(INVALID_FUNC_CALL));
        }

        $bills = $this->bills_model->getHMOBillToPostByHmo($provider["hmo_code"]);


        if (!$bills) {
            $this->utilities->redirectWithNotice("provider/view/" . $hmo_code, $this->lang->line(NO_CURRENT_BILL_FOR_HMO));
        }
        //generate ref
        $reference = $provider["hmo_code"] . now();

        $total_amount = 0;
        $data['payment_ref'] = $reference;
        $data['status'] = 'G';


        foreach ($bills as $bill) {
            $total_amount = $total_amount + $bill["total_amount"];
            $this->general_update_model->update("hmo_bills_to_post", "id", $bill['id'], $data);
        }


        $this->hmo_bills_model->setHmoBill($hmo_code, $reference, $total_amount, $this->session->userdata("staff_no"));


        $this->utilities->redirectWithNotice("provider/view/" . $hmo_code, $this->lang->line(HMO_BILL_GENERATE_SUCCESS));


    }

    public function updateGeneral()
    {

        $this->utilities->aunthenticateAccess(UPDATE_PROVIDER, "provider");


        if ($this->input->post("hmo_name")) {
            $data["hmo_name"] = $this->input->post("hmo_name");
        }


        if ($this->input->post("office_number")) {
            $data["office_number"] = $this->input->post("office_number");
        }

        if ($this->input->post("email")) {
            $data["email"] = $this->input->post("email");
        }

        if ($this->input->post("alt_email")) {
            $data["alt_email"] = $this->input->post("alt_email");
        }
        if ($this->input->post("mobile_number")) {
            $data["mobile_number"] = $this->input->post("mobile_number");
        }


        $table_name = "hmo";
        $id = "hmo_id";
        $id_value = $this->input->post("hmo_id");
        $hmo_code = $this->input->post("hmo_code");
        if (!isset($data) || $data == "" || !isset($id_value) || $id_value == "") {
            $array = array('notice' => INVALID_FUNCTION_CALL);
            $this->session->set_userdata($array);

            redirect("/provider");
        }
        $this->general_update_model->update($table_name, $id, $id_value, $data);
        $array = array('notice' => "Provider Updated Sucessfully");
        $this->session->set_userdata($array);
        redirect("/provider");


    }

    public function breakdown($payment_ref)
    {
        $this->utilities->aunthenticateAccess(VIEW_HMO_BILL, "provider");

        if (!isset($payment_ref) || !$payment_ref) {
            $this->utilities->redirectWithNotice("provider", $this->lang->line(INVALID_FUNC_CALL));
        }


        $hmo_bill = $this->hmo_bills_model->getHmoBillByRef($payment_ref);

        if (!$hmo_bill) {
            log_message("debug", "no bill found for patient");
            $this->utilities->redirectWithNotice("provider", $this->lang->line(INVALID_FUNC_CALL));
        }

        $transaction = $this->hmo_transactions_model->getHmoTransactionByRef($payment_ref);

        /*if (!$transaction) {
            $this->utilities->redirectWithNotice("provider", $this->lang->line(INVALID_FUNC_CALL));
        }*/

        $hmo = $this->hmo_model->getHmo($hmo_bill["hmo_code"]);

        $data['full_break_down'] = $this->bill_service->getHmoBillBreakDown($payment_ref);

        $data['hmo_bill'] = $hmo_bill;
        $data['transactions'] = $transaction;
        $data['provider'] = $hmo;


        $data['title'] = "Medstation | Provider";
        $data['content-description'] = "Bills Breakdown";
        //get all user module mappings by role
        $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
        $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));

        $data['currentmodule']['number'] = MODULE_NO;
        $data['currentmodule']['title'] = TITLE;

        $page[0] = "provider/breakdown";
        $this->page->loadPage($page, $data, TRUE);

    }

    public function viewPayedBills($hmo_code)
    {
        $this->utilities->aunthenticateAccess(VIEW_HMO_BILL, "provider");

        if (!isset($hmo_code) || !$hmo_code) {
            $this->utilities->redirectWithNotice("provider", $this->lang->line(INVALID_FUNC_CALL));
        }

        $provider = $this->hmo_model->getHmo($hmo_code);

        if (!$provider) {
            $this->utilities->redirectWithNotice("provider", $this->lang->line(INVALID_FUNC_CALL));
        }

        $bills = $this->hmo_bills_model->getBillsWithActivity($hmo_code);

        if (!$bills) {
            $this->utilities->redirectWithNotice("provider", $this->lang->line(NO_BILL_FOR_HMO));
        }

        $data['provider'] = $provider;
        $data['hmo_bills'] = $bills;


        $data['title'] = "Medstation | Provider";
        $data['content-description'] = "View Provider Bills";
        //get all user module mappings by role
        $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
        $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));

        $data['currentmodule']['number'] = MODULE_NO;
        $data['currentmodule']['title'] = TITLE;

        $page[0] = "provider/paidbills";
        $this->page->loadPage($page, $data, TRUE);


    }

    public function payBill()
    {


        $this->utilities->aunthenticateAccess(POST_HMO_BILL, "provider");


        if (!$this->input->post("reference_id") || !$this->input->post("amount")) {
            $this->utilities->redirectWithNotice("provider", $this->lang->line(INVALID_FUNC_CALL));
        }

        $bill = $this->hmo_bills_model->getHmoBillByRef($this->input->post("reference_id"));


        if (!$bill) {
            $this->utilities->redirectWithNotice("provider", $this->lang->line(INVALID_FUNC_CALL));
        }

        $hmoCode = $bill["hmo_code"];

        $amount = $this->input->post("amount");

        $bill_amount = $bill["total_amount"];
        $data["amount_paid"] = $amount;

        if ($bill["status"] == "R") {
            $bill_amount = $bill["total_amount"] - $bill["amount_paid"];
            $data["amount_paid"] = $amount + $bill["amount_paid"];
        }

        log_message("info", "payment amount is $amount, and payed amount is $bill_amount");

        if (!is_numeric($amount) || $amount < 1 || $amount > $bill_amount) {
            $this->utilities->redirectWithNotice("provider", $this->lang->line(INVALID_FUNC_CALL));
        }


        //check if partial payment or not
        $data["status"] = "P";


        if ($this->input->post("payment_details")) {
            $data["payment_details"] = $this->input->post("payment_details");
        }

        if ($data["amount_paid"] < $bill["total_amount"]) {
            $data["status"] = "R";
        }


        $description = "Payment for Bill Reference : " . $bill['reference_id'];

        if ($data["status"] == "P") {
            $data["date_posted"] = $this->utilities->getDate();
            $data["posted_by"] = $this->session->userdata("staff_no");

        }


        $this->general_update_model->update("hmo_bills", "reference_id", $bill['reference_id'], $data);

        //log transaction
        $this->hmo_transactions_model->setHmoTransaction($bill["hmo_code"],
            $bill['reference_id'],
            $this->input->post("amount"),
            $this->session->userdata("staff_no"),
            $description);

        //go back to the provider home

        $this->utilities->redirectWithNotice("provider/view/".$hmoCode, $this->lang->line(HMO_BILL_POSTED));

    }

    public function viewBills($hmo_code)
    {
        $this->utilities->aunthenticateAccess(VIEW_HMO_BILL, "provider");

        if (!isset($hmo_code) || !$hmo_code) {
            $this->utilities->redirectWithNotice("provider", $this->lang->line(INVALID_FUNC_CALL));
        }

        $provider = $this->hmo_model->getHmo($hmo_code);

        if (!$provider) {
            $this->utilities->redirectWithNotice("provider", $this->lang->line(INVALID_FUNC_CALL));
        }


        //get bills from hmo

        $hmo_bills = $this->hmo_bills_model->getHmoBillsUnpostedByHmo($hmo_code);

        if (!$hmo_bills) {
            $this->utilities->redirectWithNotice("provider/view/" . $hmo_code, $this->lang->line(NO_BILL_FOR_HMO));
        }

        $counter = 0;
        foreach ($hmo_bills as $bill) {
            if ($bill["status"] == "R") {
                $hmo_bills[$counter]["total_amount"] = $bill["total_amount"] - $bill["amount_paid"];
            }

            $counter++;
        }

        $data['provider'] = $provider;
        $data['hmo_bills'] = $hmo_bills;


        $data['title'] = "Medstation | Provider";
        $data['content-description'] = "View Provider Bills";
        //get all user module mappings by role
        $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
        $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));

        $data['currentmodule']['number'] = MODULE_NO;
        $data['currentmodule']['title'] = TITLE;

        $page[0] = "provider/bills";
        $this->page->loadPage($page, $data, TRUE);
    }

    public function view($id = FALSE)
    {

        $this->utilities->aunthenticateAccess(VIEW_PROVIDER, "provider");


        if ($id === FALSE) {
            if (!$this->input->post('hmo_code')) {
                $array = array('notice' => INVALID_FUNCTION_CALL);
                $this->session->set_userdata($array);
                redirect('/home');
            }

            $id = $this->input->post('hmo_code');

        }


        $data['provider'] = $this->hmo_model->getHmo($id);

        $data['bill_count'] = $this->hmo_bills_model->getHmoBillCount($id);


        if (empty($data['provider']) || !isset($data['provider']) || $data['provider'] == "") {
            $array = array('notice' => "No Such Provider");
            $this->session->set_userdata($array);
            redirect('/provider');
        }
        $data['countries'] = $this->country_model->getCountries();

        $data['state'] = $this->state_model->getState($data['provider']['state_code']);


        //get all user module mappings by role
        $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

        //get the role title
        $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));


        $data['patients'] = $this->patient_model->getPatientByHmo($id);

        $data['address_states'] = $this->state_model->getStateByCountry($data['provider']['country_code']);
        $data['currentmodule']['number'] = MODULE_NO;
        $data['currentmodule']['title'] = TITLE;
        $data['providers'] = $this->hmo_model->getHmo();

        $data['title'] = "Medstation | Provider Central";
        $data['content-description'] = "Hospital Provider/Group Manager";
        //$data['title']=$this->passwordhash->HashPassword("password");
        $this->load->view('templates/header', $data);
        $this->load->view('templates/mainheader', $data);
        $this->load->view('provider/view');
        $this->load->view('templates/footer');


    }

    public function index()
    {

        $this->utilities->aunthenticateAccess(VIEW_PROVIDER, "home");


        //get all user module mappings by role
        $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

        //get the role title
        $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));


        $data['currentmodule']['number'] = MODULE_NO;
        $data['currentmodule']['title'] = TITLE;
        $data['providers'] = $this->hmo_model->getHmo();

        $data['title'] = "Medstation | Provider Central";
        $data['content-description'] = "Hospital Provider/Group Manager";
        //$data['title']=$this->passwordhash->HashPassword("password");

        $pages[0] = "provider/home";

        $this->page->loadPage($pages, $data, TRUE);

    }
	
	
	
	 public function changeHmoToSingle()
    {
		
		$this->utilities->aunthenticateAccess(VIEW_PROVIDER, "provider");
		
		if (!$this->input->post('hmo_code')) {
                $array = array('notice' => INVALID_FUNCTION_CALL);
                $this->session->set_userdata($array);
                redirect('/home');
            }
		
            $id = $this->input->post('hmo_code');
		
		
		if (null == $this->input->post('hmopatient')) {

				$hmovalues = $this->input->post('hmopatient');
				$this->utilities->redirectWithNotice('/provider/view/'.$id, 'No Patient selected for change');
				
        }else{ 
		
		
	

					
					$hmopatient = $this->input->post('hmopatient');
					foreach ($hmopatient as $hmopatients) {
							//echo $hmopatients;
					   
						$patienDetails = $this->patient_model->getPatient($hmopatients);

						$table_name = "patient_master_table";
						$Patientid = "patient_number";
						$id_value = $hmopatients;

						$data["patient_type_code"] = 'S';
						$data["hmo_code"] = null;
						$data["hmo_enrolee_id"] = null;
						$data["primary_enrollee_id"] = null;
						$data["rel_to_primary_enrolle"] = null;
						

						$this->general_update_model->update($table_name, $Patientid, $id_value, $data);
						$array = array('notice' => "Patient File Type changed successfully");
						$this->session->set_userdata($array);
							
					}
		
				$this->utilities->redirectWithNotice('/provider/view/'.$id, 'HMO FILE CHANGED');
			}
	
    }
	
	public function changeHmoToFamily()
    {
		$this->utilities->aunthenticateAccess(VIEW_PROVIDER, "provider");
		
		if (!$this->input->post('hmo_code')) {
                $array = array('notice' => INVALID_FUNCTION_CALL);
                $this->session->set_userdata($array);
                redirect('/home');
            }
		
            $id = $this->input->post('hmo_code');
		
		
		if (null == $this->input->post('hmopatient')) {

				$hmovalues = $this->input->post('hmopatient');
				$this->utilities->redirectWithNotice('/provider/view/'.$id, 'No Patient selected for change');
				
        }else{ 

				$hmopatient = $this->input->post('hmopatient');
				foreach ($hmopatient as $hmopatients) {

					
								$patienDetails = $this->patient_model->getPatient($hmopatients);

								$table_name = "patient_master_table";
								$Patientid = "patient_number";
								$id_value = $hmopatients;

								$data["patient_type_code"] = 'F';
								$data["hmo_code"] = null;
								$data["hmo_enrolee_id"] = null;
								$data["primary_enrollee_id"] = null;
								$data["rel_to_primary_enrolle"] = null;
								

								$this->general_update_model->update($table_name, $Patientid, $id_value, $data);
								$array = array('notice' => "Patient File Type changed successfully");
								$this->session->set_userdata($array);

				}
				
				$this->utilities->redirectWithNotice('/provider/view/'.$id, 'HMO FILE CHANGED');
			}		
				
    }
	
	
	public function changeHmoToHmo()
    {
		

		$this->utilities->aunthenticateAccess(VIEW_PROVIDER, "provider");
		
		if (!$this->input->post('hmo_code')) {
                $array = array('notice' => INVALID_FUNCTION_CALL);
                $this->session->set_userdata($array);
                redirect('/home');
            }
		
            $id = $this->input->post('hmo_code');
		
		
		if (null == $this->input->post('hmopatient')) {

				$hmovalues = $this->input->post('hmopatient');
				$this->utilities->redirectWithNotice('/provider/view/'.$id, 'No Patient selected for change');
				
        }else{ 


				$hmopatient = $this->input->post('hmopatient');
				$newhmoCode = $this->input->post('new_hmo_code');
				foreach ($hmopatient as $hmopatients) {

					
								$patienDetails = $this->patient_model->getPatient($hmopatients);

								$table_name = "patient_master_table";
								$Patientid = "patient_number";
								$id_value = $hmopatients;

								$data["patient_type_code"] = 'H';
								$data["hmo_code"] = $newhmoCode;
								$data["hmo_enrolee_id"] = null;
								$data["primary_enrollee_id"] = null;
								$data["rel_to_primary_enrolle"] = null;
								

								$this->general_update_model->update($table_name, $Patientid, $id_value, $data);
								$array = array('notice' => "Patient File Type changed successfully");
								$this->session->set_userdata($array);

				}
			
				$this->utilities->redirectWithNotice('/provider/view/'.$id, 'HMO FILE CHANGED');
			}		
			
    }


}