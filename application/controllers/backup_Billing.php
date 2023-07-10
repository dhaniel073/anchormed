<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

define ('MODULE_NO', 8);
define ('CREATE_BILL', 10);
define ('POST_BILL', 11);
define ('DELETE_BILL_ITEM', 12);
define ('VIEW_BILLS', 13);
define ('TITLE', 'Bill Management');

class Billing extends CI_Controller
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
        $this->load->model('bills_model');
        $this->load->model('state_model');
        $this->load->model('country_model');
        $this->load->helper('date');
        $this->load->model('bill_master_model');
        $this->load->model('drug_price_master_model');
        $this->load->model('pharmacy_stock_model');
        $this->load->model('general_update_model');
        $this->load->model('drug_stock_rules_model');
        $this->load->model("laboratory_price_model");
        $this->load->model("lab_orders_model");
        $this->load->model("partial_payments_model");
        $this->load->model("non_customer_order_model");
        $this->load->model("drug_bill_form_model");
        $this->load->model("patient_deposit_model");
        $this->load->model("bill_refunds_model");
		$this->load->model("Payment_mode_model");
		$this->load->model("patient_hmo_bill_offset_model");
        $this->load->library("services/bill_service");


        $this->utilities->loadUserLang();


    }

    private function confirmUrl()
    {
        if ($this->session->userdata('base_url') != base_url()) {
            redirect("/logout");
        }

    }

    public function patientbill($patient_number)
    {
        if ($this->session->userdata('logged_in')) {
            $this->moduleAccessCheck(CREATE_BILL);

            //check if patient is valid

            if (!isset($patient_number)) {
                $array = array('notice' => "Invalid function call");
                $this->session->set_userdata($array);
                redirect('/home');
            }


            $patient_data = $this->patient_model->getPatient(trim($patient_number));
            if (isset($patient_data) && sizeof($patient_data) > 1) {

                $array = array('patient_name' => $patient_data['first_name'] . " " . $patient_data['last_name'],
                    'patient_number' => $patient_data['patient_number']);

                $this->session->set_userdata($array);



                log_message('debug', $array["patient_name"]);

                //prepare bill form
                redirect('/billing');

            } else if ($patient_number == NON_CUSTOMER_ID) {

                $patient_name = "WALK IN CUSTOMER";

                if ($this->session->userdata("walk_in_patient_name")) {
                    $patient_name = $this->session->userdata("walk_in_patient_name");
                }


                $array = array('patient_name' => $patient_name,
                    'patient_number' => NON_CUSTOMER_ID);
                $this->session->set_userdata($array);
                //prepare bill form
                redirect('/billing');
            } else {
                $array = array('notice' => "Invalid function call");
                $this->session->set_userdata($array);
                redirect('/home');
            }


        } else {
            redirect('/login');

        }
    }

    private function chceckPostAccess()
    {
        $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), POST_BILL);
        if (!isset($moduleAccess) || $moduleAccess['access'] != "W") {
            return false;
        } else return true;
    }

    private function moduleAccessCheck($accessLevel)
    {
        $this->confirmUrl();
        $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), $accessLevel);

        if (!isset($moduleAccess) || $moduleAccess['access'] != "W") {
            $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
            $this->session->set_userdata($array);
            redirect('/home');
        }
    }

    public function searchBillByReference()
    {

        if (!$this->input->post("ref")) {
            redirect('/home');
        }


        $reference = $this->input->post("ref");

        //echo $reference;

        //return false;

        if ($this->session->userdata('logged_in')) {

            $this->moduleAccessCheck(VIEW_BILLS);

            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
            $data['hmos'] = $this->hmo_model->getHmo();

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;


            $data['bills'] = $this->bills_model->getPostedBillsByReference(urldecode($reference));


            $counter = 0;

            foreach ($data['bills'] as $bill) {

                //check if bill is for walk in patient
                if ($bill["patient_number"] == NON_CUSTOMER_ID) {
                    $data['bills'][$counter]["patient"]["patient_number"] = $bill["patient_number"];
                    $walkInBill = $this->non_customer_order_model->getNonCustomerOrderByReference($bill['reference_id']);

                    $data['bills'][$counter]["patient"]["first_name"] = $walkInBill['name'];
                    $data['bills'][$counter]["patient"]["middle_name"] = "";
                    $data['bills'][$counter]["patient"]["last_name"] = "";

                    $this->patient_model->getPatient($bill["patient_number"]);

                } //registered customer find the bill reference
                else {

                    $data['bills'][$counter]["patient"] =
                        $this->patient_model->getPatient($bill["patient_number"]);
                }

                $counter++;
            }


            $data['title'] = "Medstation | Billing";
            $data['content-description'] = "Bill Management";


            //$data['title']=$this->passwordhash->HashPassword("password");

            $this->load->view('templates/header', $data);
            $this->load->view('templates/mainheader', $data);
            $this->load->view('billing/paidbills');
            $this->load->view('templates/footer');

        } else {

            redirect("/login");
        }
    }

    public function processedBills($patient_number)
    {


        if (!isset($patient_number) || $patient_number == "") {
            redirect('/home');
        }

        if ($this->session->userdata('logged_in')) {
            $this->moduleAccessCheck(VIEW_BILLS);

            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
            $data['hmos'] = $this->hmo_model->getHmo();

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;

            $data['departments'] = $this->department_model->getDepartments();

            $data['patient'] = $this->patient_model->getPatient($patient_number);
            $data['state'] = $this->state_model->getState($data['patient']['address_state_code']);
            $data['country'] = $this->country_model->getCountries($data['patient']['address_country_code']);

            $data['bills'] = $this->bills_model->getPostedBillsByPatient($patient_number);


            $data['title'] = "Medstation | Billing";
            $data['content-description'] = "Bill Management";


            //$data['title']=$this->passwordhash->HashPassword("password");

            $this->load->view('templates/header', $data);
            $this->load->view('templates/mainheader', $data);
            $this->load->view('billing/paidbills');
            $this->load->view('templates/footer');
        } else {

            redirect('/login');
        }
    }

    public function refundBill(){

        $this->utilities->aunthenticateAccess(REFUND_BILL_AMOUNT, "billing");

        //get the bill and make the correct refunds

        $storedBills = $this->bills_model->getBillByReference($this->input->post("refund_bill_reference"));

        if(sizeof($storedBills) < 1){
            $this->utilities->redirectWithNotice("home", INVALID_FUNCTION_CALL);
        }


        $patientNumber = $storedBills[0]['patient_number'];


        $redirectPage = "/billing/viewBill/".urlencode($this->input->post("refund_bill_reference"));

        if($patientNumber == NON_CUSTOMER_ID){

            $redirectPage = "/billing/nonCustomerBill/".urlencode($this->input->post("refund_bill_reference"));
        }

        $refunds = $this->bill_refunds_model->getRefundsByReference($this->input->post("refund_bill_reference"));


        if(isset($refunds)){

            if(sizeof($refunds) > 0){

                $this->utilities->redirectWithNotice($redirectPage, "Refund already performed");
                return;
            }
        }


        $this->bill_refunds_model->createRefund($this->input->post("refund_bill_reference"),
            $this->input->post("refund_amount"), $this->session->userdata('staff_no'));




        $this->utilities->redirectWithNotice($redirectPage, "Bill Updated");

    }

    public function viewBill($reference)
    {
        if ($this->session->userdata('logged_in')) {
            $this->moduleAccessCheck(VIEW_BILLS);

            if ($this->input->get("print_mode") == "true") {

                $array = array('print_mode' => $this->input->get("print_mode"));
                $this->session->set_userdata($array);
            }

            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
            $data['hmos'] = $this->hmo_model->getHmo();

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;

            $data['departments'] = $this->department_model->getDepartments();

            $data['refunds'] = $this->bill_refunds_model->getRefundsByReference($reference);


            $data['can_perform_refund'] = $this->utilities->userHasAccess(REFUND_BILL_AMOUNT);


            $data['current_bill'] = $this->bills_model->getBillByReference($reference);

            if (!isset($data['current_bill']) || sizeof($data['current_bill']) < 1 || $data['current_bill'] == "") {
                $array = array('notice' => "Bill with reference : " . $reference . " not found");
                $this->session->set_userdata($array);
                redirect('/billing');

            }

            $patient_number = $data['current_bill'][0]['patient_number'];
            $data['reference'] = $reference;
            $data['patient'] = $this->patient_model->getPatient($patient_number);
            $data['state'] = $this->state_model->getState($data['patient']['address_state_code']);
            $data['country'] = $this->country_model->getCountries($data['patient']['address_country_code']);

            $data['title'] = "Medstation | Billing";
            $data['content-description'] = "Bill Management";
            $data['post_access'] = $this->chceckPostAccess();
            $data['enableBack'] = true;
            $array = array('mode' => "print");
            $this->session->set_userdata($array);

            //$data['title']=$this->passwordhash->HashPassword("password");
            $this->load->view('templates/header', $data);
            $this->load->view('billing/view');
            $this->load->view('templates/footer', $data);

        } else {

            redirect('/login');
        }
    }
	
	
	
	public function thermalviewBill($reference)
    {
        if ($this->session->userdata('logged_in')) {
            $this->moduleAccessCheck(VIEW_BILLS);

            if ($this->input->get("print_mode") == "true") {

                $array = array('print_mode' => $this->input->get("print_mode"));
                $this->session->set_userdata($array);
            }

            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
            $data['hmos'] = $this->hmo_model->getHmo();

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;

            $data['departments'] = $this->department_model->getDepartments();

            $data['refunds'] = $this->bill_refunds_model->getRefundsByReference($reference);


            $data['can_perform_refund'] = $this->utilities->userHasAccess(REFUND_BILL_AMOUNT);
			$data['payment_mode_list'] = $this->Payment_mode_model->getPostedPaymentModeByReference($reference);
			$data['payment_hmo_bill'] = $this->patient_hmo_bill_offset_model->findPatientOffsetByReference($reference);

           

            $data['current_bill'] = $this->bills_model->getBillByReference($reference);

            if (!isset($data['current_bill']) || sizeof($data['current_bill']) < 1 || $data['current_bill'] == "") {
                $array = array('notice' => "Bill with reference : " . $reference . " not found");
                $this->session->set_userdata($array);
                redirect('/billing');

            }

            $patient_number = $data['current_bill'][0]['patient_number'];
            $data['reference'] = $reference;
            $data['patient'] = $this->patient_model->getPatient($patient_number);
            $data['state'] = $this->state_model->getState($data['patient']['address_state_code']);
            $data['country'] = $this->country_model->getCountries($data['patient']['address_country_code']);

            $data['title'] = "Medstation | Billing";
            $data['content-description'] = "Bill Management";
            $data['post_access'] = $this->chceckPostAccess();
            $data['enableBack'] = true;
            $array = array('mode' => "print");
            $this->session->set_userdata($array);

            //$data['title']=$this->passwordhash->HashPassword("password");
            $this->load->view('templates/header', $data);
            $this->load->view('billing/thermalview');


        } else {

            redirect('/login');
        }
    }

    public function partialPaymentUpdate($reference_id)
    {
        $this->utilities->aunthenticateAccess(CREATE_BILL, "home");

        $partial_payment_bill = $this->partial_payments_model->getPartialPaymentByReference($reference_id);

        $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
        //get the role title
        $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
        $data['hmos'] = $this->hmo_model->getHmo();

        $data['currentmodule']['number'] = MODULE_NO;
        $data['currentmodule']['title'] = TITLE;
        $data['departments'] = $this->department_model->getDepartments();

        $data['current_bill'] = $this->bills_model->getBillByReference($reference_id);
        $data['reference'] = $reference_id;
        $data['patient'] = $this->patient_model->getPatient($partial_payment_bill[0]["patient_number"]);
        $data['state'] = $this->state_model->getState($data['patient']['address_state_code']);
        $data['country'] = $this->country_model->getCountries($data['patient']['address_country_code']);

        $data['title'] = "Medstation | Billing";
        $data['content-description'] = "Bill Management";
        $data['post_access'] = $this->chceckPostAccess();

        $data["partial_payment_data"] = $partial_payment_bill;
        $data['can_edit_bill_item'] = $this->utilities->userHasAccess(UPDATE_BILL_ITEM_PRICE);

        $data['enableBack'] = true;
        //calculate amount to be paid
        //print_r($partial_payment_bill);
        //echo $reference_id;
        $this->load->view('templates/header', $data);
        $this->load->view('billing/view');
        $this->load->view('templates/footer', $data);

        //$pages[0] = "billing/view";
        //$this->page->loadPage($pages,$data,TRUE);
    }

    /**
     * updates the custom item price for hospitals that want to edit the price instead of using the normal price configured
     * in the system
     */
    public function updateCustomItemPrice(){

        $this->utilities->aunthenticateAccess(UPDATE_BILL_ITEM_PRICE, "home");

        $billItem = $this->bills_model->getBill($this->input->post("bill_item_id"));

        if(!isset($billItem)){

            $this->utilities->redirectWithNotice("home",INVALID_FUNCTION_CALL);
        }

        $updatedTotal = null;

        if($this->input->post("custom_amount") > 0 ){

            $updatedTotal = $this->input->post("custom_amount");

        }

        $data['selling_price'] = $updatedTotal;
        $this->general_update_model->update("bills",
            "id",
            $this->input->post("bill_item_id") ,
            $data);


        $redirectPage="";

        if($billItem["patient_number"] == NON_CUSTOMER_ID){

            $redirectPage = "/billing/nonCustomerBill/".urlencode($billItem["reference_id"]);

        }else{

            $redirectPage = "/billing/currentBill/".$billItem["patient_number"] ;


        }

        redirect($redirectPage);

    }

    public function nonCustomerBill($reference)
    {
        $this->utilities->aunthenticateAccess(CREATE_BILL, "home");

        if (!$reference) {
            redirect("/home");
        }

        if ($this->input->get("print_mode") == "true") {

            $array = array('print_mode' => $this->input->get("print_mode"));
            $this->session->set_userdata($array);
        }


        $reference_id = urldecode($reference);

        $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

        //get the role title
        $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
        $data['hmos'] = $this->hmo_model->getHmo();

        $data['currentmodule']['number'] = MODULE_NO;
        $data['currentmodule']['title'] = TITLE;

        $data['departments'] = $this->department_model->getDepartments();


        $data['current_bill'] = $this->bills_model->getBillByReference($reference_id);

        if (!$data['current_bill']) {
            redirect("/home");
        }

        $printMode = true;

        foreach ($data['current_bill'] as $bill) {

            if ($bill["status"] != "P") {
                $printMode = false;

            }
        }

        if ($printMode) {
            $sessionData["mode"] = "print";
            $this->session->set_userdata($sessionData);
        }


        $data['reference'] = $reference_id;

        $data['non_customer_order'] = $this->non_customer_order_model->getNonCustomerOrderByReference($reference_id);

        $data['patient']['first_name'] = $data['non_customer_order']['name'];
        $data['patient']['patient_number'] = NON_CUSTOMER_ID;
        $data['patient']['patient_type_code'] = 'N';

        $data['title'] = "Medstation | Billing";
        $data['content-description'] = "Bill Management";
        $data['post_access'] = $this->chceckPostAccess();

        $data['can_edit_bill_item'] = $this->utilities->userHasAccess(UPDATE_BILL_ITEM_PRICE);

        $data['can_perform_refund'] = $this->utilities->userHasAccess(REFUND_BILL_AMOUNT);

        $data['refunds'] = $this->bill_refunds_model->getRefundsByReference($reference_id);



        $data['enableBack'] = true;
        //$data['title']=$this->passwordhash->HashPassword("password");
        $this->load->view('templates/header', $data);
        $this->load->view('billing/view');
        $this->load->view('templates/footer', $data );


    }
	
	
	
	public function thermalnonCustomerBill($reference)
    {
        $this->utilities->aunthenticateAccess(CREATE_BILL, "home");
		$data['payment_mode_list'] = $this->Payment_mode_model->getPostedPaymentModeByReference($reference);

		//echo $data['payment_mode_list'];

        if (!$reference) {
            redirect("/home");
        }

        if ($this->input->get("print_mode") == "true") {

            $array = array('print_mode' => $this->input->get("print_mode"));
            $this->session->set_userdata($array);
        }


        $reference_id = urldecode($reference);

        $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

        //get the role title
        $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
        $data['hmos'] = $this->hmo_model->getHmo();

        $data['currentmodule']['number'] = MODULE_NO;
        $data['currentmodule']['title'] = TITLE;

        $data['departments'] = $this->department_model->getDepartments();


        $data['current_bill'] = $this->bills_model->getBillByReference($reference_id);

        if (!$data['current_bill']) {
            redirect("/home");
        }

        $printMode = true;

        foreach ($data['current_bill'] as $bill) {

            if ($bill["status"] != "P") {
                $printMode = false;

            }
        }

        if ($printMode) {
            $sessionData["mode"] = "print";
            $this->session->set_userdata($sessionData);
        }


        $data['reference'] = $reference_id;

        $data['non_customer_order'] = $this->non_customer_order_model->getNonCustomerOrderByReference($reference_id);

        $data['patient']['first_name'] = $data['non_customer_order']['name'];
        $data['patient']['patient_number'] = NON_CUSTOMER_ID;
        $data['patient']['patient_type_code'] = 'N';

        $data['title'] = "Medstation | Billing";
        $data['content-description'] = "Bill Management";
        $data['post_access'] = $this->chceckPostAccess();

        $data['can_edit_bill_item'] = $this->utilities->userHasAccess(UPDATE_BILL_ITEM_PRICE);

        $data['can_perform_refund'] = $this->utilities->userHasAccess(REFUND_BILL_AMOUNT);

        $data['refunds'] = $this->bill_refunds_model->getRefundsByReference($reference_id);



        $data['enableBack'] = true;
        //$data['title']=$this->passwordhash->HashPassword("password");
        $this->load->view('templates/header', $data);
        $this->load->view('billing/thermalview');
        $this->load->view('templates/footer', $data );


    }

    public function currentBill($patient_number)
    {

        if ($this->session->userdata('logged_in')) {

            $this->moduleAccessCheck(CREATE_BILL);


            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
            $data['hmos'] = $this->hmo_model->getHmo();

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;

            $data['departments'] = $this->department_model->getDepartments();
            $data['can_edit_bill_item'] = $this->utilities->userHasAccess(UPDATE_BILL_ITEM_PRICE);



            $currentBillRef = $this->bills_model->get_current_bill($patient_number);


            if (sizeof($currentBillRef) == 1) {
                $reference = $currentBillRef['reference_id'];
                $data['status'] = "N";
            } else {
                $array = array('notice' => "No Current Bill For Patient");
                $this->session->set_userdata($array);
                redirect("/billing");
            }

            $data['patient_deposit'] = $this->patient_deposit_model->getLatestDepositByPatientNumber($patient_number);


            $data['current_bill'] = $this->bills_model->getBillByReference($reference);
            $data['reference'] = $reference;
            $data['patient'] = $this->patient_model->getPatient($patient_number);
            $data['state'] = $this->state_model->getState($data['patient']['address_state_code']);
            $data['country'] = $this->country_model->getCountries($data['patient']['address_country_code']);

            $data['title'] = "Medstation | Billing";
            $data['content-description'] = "Bill Management";
            $data['post_access'] = $this->chceckPostAccess();

            //$data['title']=$this->passwordhash->HashPassword("password");
            $this->load->view('templates/header', $data);
            $this->load->view('billing/view');
            $this->load->view('templates/footer');
        } else {
            redirect('/login');
        }

    }

    public function removeBillItems()
    {

        $this->utilities->aunthenticateAccess(DELETE_BILL_ITEM, "billing");


        $patient_number = $this->input->post('patient_number');


        //get bill definition
        if (null == $this->input->post('bill')) {


            $this->utilities->redirectWithNotice('/billing/currentBill/' . $patient_number,
                $this->lang->line(NO_BILL_ITEM_SELECTED));
        } else {

            //validate bills to be removed
            $bills = $this->input->post('bill');
            foreach ($bills as $bill) {
                $bill_details = $this->bills_model->getBill($bill);


                $pending_lab_order =
                    $this->lab_orders_model->
                    getOrderByReferenceIdAndPatientId($bill_details["reference_id"], $bill_details["patient_number"]);



                //check if a test sample has already been taken for the lab orders
                if(isset($pending_lab_order)){
                    //test already performed
                    if($pending_lab_order["status"] == "P"){

                        $this->utilities->redirectWithNotice('/billing/currentBill/' . $patient_number,
                            $this->lang->line(NO_MODIFY_TEST_PERFORMED));
                    }
                    //sample has already been taken
                    else if($pending_lab_order["status"] == "R"){

                        $this->utilities->redirectWithNotice('/billing/currentBill/' . $patient_number,
                            $this->lang->line(NO_MODIFY_SAMPLE_COLLECTED));
                    }
                }


                //check if has already been dispensed
                if (isset($bill_details["dispense_needed"]) && $bill_details["dispense_needed"] == "D") {
                    $this->utilities->redirectWithNotice('/billing/currentBill/' . $patient_number,
                        $this->lang->line(NO_MODIFY_DRUG_DISPENSED));
                }

            }

            $reference = "";

            foreach ($bills as $bill) {
                $bill_item = $this->bills_model->getBill($bill);
                if ($bill_item) {
                    //echo $bill_item["reference_id"];
                    $reference = $bill_item["reference_id"];
                    $this->lab_orders_model->removeOrder($bill_item["reference_id"]);
                }

            }

            $this->bills_model->removeBillItems($this->input->post('bill'));

            //if it is a non customer
            if($patient_number == NON_CUSTOMER_ID){

                $foundNonCustomerBills =  $this->bills_model->getBillByReference($reference);

                //delete the non - customer order if there is no more of that reference left
               if(sizeof($foundNonCustomerBills) < 1){

                    $this->non_customer_order_model->removeOrderByRefrence($reference);

               }
            }




            $array = array('notice' => "Items Removed");
            $this->session->set_userdata($array);

            if($patient_number == NON_CUSTOMER_ID){

                redirect('/billing/nonCustomerBill/'. urlencode($reference));

            }else{
                $patient_number = $this->input->post('patient_number');
                redirect('/billing/currentBill/' . $patient_number);
            }



        }


    }

    public function bill($bill)
    {
        if ($this->session->userdata('logged_in')) {
            $this->moduleAccessCheck(VIEW_BILLS);

            if (!isset($bill) || $bill == "") {
                $array = array('submit' => false, 'data' => "", notice => "Invalid Request , bill");
                $this->session->set_userdata($array);
                redirect("/home");
            }

            if ($this->session->userdata('submit')) {

                $data = $this->session->userdata('data');


                $data['bill'] = $this->bill_master_model->getBill($bill);

                $array = array('submit' => true, 'data' => $data);

                $this->session->set_userdata($array);
                //print_r($data);

                if (isset($data['forward_url']) && $data['forward_url'] != "") {

                    redirect($data['forward_url']);
                }
                
                redirect("/billing");


            } else {
                $array = array('submit' => false, 'data' => "", notice => "Invalid Request");
                $this->session->set_userdata($array);

                redirect("/home");
            }


        } else {
            redirect('/login');
        }
    }

    public function search()
    {
        if ($this->session->userdata('logged_in')) {
            $this->moduleAccessCheck(VIEW_BILLS);

            $return_url = $this->input->post('return_url');

            if ($this->input->post('patient_number')) {
                $array = array('submit' => true, 'data' => $_POST);
                $this->session->set_userdata($array);
            }



            if ($this->input->post('patient_number') == NON_CUSTOMER_ID) {

                if (null == $this->input->post('name')) {
                    $data['bill_defs'] = $this->bill_master_model->getBillsForWalkInPatient();
                } else {
                    $data['bill_defs'] = $this->bill_master_model->searchBill($this->input->post('name'), true);
                }
            } else {
                if (null == $this->input->post('name')) {
                    $data['bill_defs'] = $this->bill_master_model->getBill();
                } else {
                    $data['bill_defs'] = $this->bill_master_model->searchBill($this->input->post('name'));
                }
            }


            if ($return_url == "" || !isset($return_url)) {
                //<?=base_url()index.php/billing/patientbill/<?php echo $patient['patient_number']
                $return_url = "index.php/billing/patientbill/";
            }

          //  $data['patient_name'] = $this->input->post('patient_name');

            //get all user module mappings by role
            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
            $data['search_url'] = "index.php/billing/search";
            $data['return_url'] = $return_url;
            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
            $data['hmos'] = $this->hmo_model->getHmo();

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;

            $data['departments'] = $this->department_model->getDepartments();

            $data['title'] = "Medstation | Billing";
            $data['content-description'] = "Bill Management";


            $this->load->view('templates/header', $data);
            $this->load->view('templates/mainheader', $data);
            $this->load->view('billing/search');
            $this->load->view('templates/footer');

        } else {
            redirect('/login');
        }
    }


    private function postBillBck(){


        //if partial payment and a walk in customer, not supported
        if($this->input->post('patient_number') == NON_CUSTOMER_ID && $this->input->post('partial_payment_flag') == 'Y'){

            //echo "Partial Payment not supported for walk in customer";
            $array = array('notice' => "Partial Payment not supported for walk in customer");
            $this->session->set_userdata($array);
            redirect('/billing/nonCustomerBill/' . $this->input->post("reference_id"));
        }

        //get all the selected bills ids
        $selectedBills = $this->input->post('bill');


        $isSecurityDeposit = false;

        //check to make sure it is not a security bill
        if(sizeof($selectedBills) == 1){

            $master = $this->bills_model->getBill($selectedBills[0]);
            if(strtolower($master["service_name"]) == "deposit"){

                $isSecurityDeposit = true;
            }
        }


        //check to make sure partial bill and security deposit are not selected at the same time
        if($this->input->post('partial_payment_flag') == 'Y' && $isSecurityDeposit){

            $array = array('notice' => "Partial deposit not allowed for a security deposit");
            $this->session->set_userdata($array);
            $patient_number = $this->input->post('patient_number');
            redirect('/billing/currentBill/' . $patient_number);
        }

        if (null == $this->input->post('bill')) {
            $array = array('notice' => "No Bill Item was selected");
            $this->session->set_userdata($array);
            $patient_number = $this->input->post('patient_number');
            redirect('/billing/currentBill/' . $patient_number);

            //finishing leg for parial payments previously received
        } else if ($this->input->post('partial_previously_recieved') == 'Y') {
            $bills = $this->input->post('bill');

            $original_bill_amount = 0;
            foreach ($bills as $bill) {
                $bill_item = $this->bills_model->getBill($bill);
                $original_bill_amount = $original_bill_amount + ($bill_item['unit_price'] * $bill_item['qty']);
            }

            //if it is yet another partial payment
            if ($this->input->post('partial_payment_flag') == "Y") {
                $this->partial_payments_model->set_partial_payment($this->input->post('patient_number'),
                    $this->input->post('partial_payment_ref'),
                    $this->input->post("partial_amount"),
                    $original_bill_amount);
                $this->utilities->redirectWithNotice("home", $this->lang->line(PARTIAL_PAYMENT_POSTED));
            }
            //if it is finally a full payment, close partial payments
            else {
                $this->bills_model->postPartialPaymentCompletely($bills,
                    $this->input->post('partial_payment_ref'),
                    $this->input->post('patient_number'),
                    $original_bill_amount,
                    $this->input->post("partial_amount"));

                $this->utilities->redirectWithNotice("home", $this->lang->line(PARTIAL_PAYMENT_COMPLETED));
            }

        } else {

            if ($this->input->post('patient_number') != NON_CUSTOMER_ID) {

                //why am i doing this
                $reference = $this->input->post('patient_number') . now();
            }

            $formalReference = "";

            $patient_type_code = $this->input->post('patient_type_code');
            $patient_number = $this->input->post('patient_number');
            $bills = $this->input->post('bill');
            $amount = 0;
            $StockUpdateArray = null;
            $stockArrayCounter = 0;

            $isInStock = true;
            $dispenseData = null;
            $last_drug_id = "";
            $currentStock = 0;


            foreach ($bills as $bill) {

                //get the generated bill from the bills table, will hold specific information like qty and selling_price
                $bill_item = $this->bills_model->getBill($bill);
                $formalReference = $bill_item["reference_id"];

                //TODO:: I am not sure why i set a new reference
                $reference = $formalReference;

                if ($this->input->post('patient_number') == NON_CUSTOMER_ID) {
                    $reference = $formalReference;
                }


                //find the bill original master item that has the bill definitions
                $bill_master = $this->bill_master_model->getBill($bill_item['bill_id']);


                $dispenseData[$bill]['dispense_needed'] = null;


                //if it is a drug and has not yet been dispensed
                if ($bill_master['drug_price_id'] && $bill_master['drug_price_id'] != "" && (!isset($bill_item["dispense_needed"]) || $bill_item["dispense_needed"] != "D")) {
                    $dispenseData[$bill]['dispense_needed'] = "Y";


                    $drug_price_master = $this->drug_price_master_model->getDrugPriceMaster($bill_master['drug_price_id']);

                    //get the current number in stock
                    $pharmacy_stock = $this->pharmacy_stock_model->getOneStockBatch($drug_price_master['drug_id']);

                    $pharmacy_all_active_batches = $this->pharmacy_stock_model->getActiveStock($drug_price_master['drug_id']);

                    $total_number_in_stock = 0;

                    foreach ($pharmacy_all_active_batches as $batch) {

                        $total_number_in_stock = $total_number_in_stock + $batch['qty_in_stock'];
                    }

                    //if a valid stock was not found
                    if (!$pharmacy_stock || sizeof($pharmacy_stock) < 2 || $total_number_in_stock < 1) {

                        $isInStock = false;
                        $array = array('notice' => $bill_master['service_name'] . " is not in stock. ");
                        $this->session->set_userdata($array);
                        break;
                    }


                    //validate stock
                    $package_id_to_dispense = $drug_price_master['drug_bill_package_id'];
                    $default_package_id = $pharmacy_stock['drug_bill_package_id'];

                    //get package information
                    $dispensePackageInfo = $this->drug_bill_form_model->getDrugBillForms($package_id_to_dispense);

                    if ($default_package_id == $package_id_to_dispense) {
                        if ($last_drug_id == $drug_price_master['drug_id']) {
                            $pharmacy_stock['qty_in_stock'] = $currentStock;
                        }

                        $last_drug_id == $drug_price_master['drug_id'];


                        //since its in the same package confirm stock before bill posting

                        if ($bill_item['qty'] > $total_number_in_stock) {
                            $isInStock = false;
                            $array = array('notice' => $bill_master['service_name'] . " is not in stock. ");
                            $this->session->set_userdata($array);
                            break;
                        } else {
                            //if the random batch selected can handle it dispense from if
                            if ($bill_item['qty'] <= $pharmacy_stock['qty_in_stock']) {

                                //populate stock array update
                                $StockUpdateArray[$stockArrayCounter]['bill_id'] = $bill_item['id'];
                                $StockUpdateArray[$stockArrayCounter]['dispense_info'] = "Dispense from batch " . $pharmacy_stock['batch_no'];
                                $StockUpdateArray[$stockArrayCounter]['stock_id'] = $pharmacy_stock['stock_id'];
                                $currentStock = $pharmacy_stock['qty_in_stock'] - $bill_item['qty'];
                                $StockUpdateArray[$stockArrayCounter]['qty_to_reduce'] = $bill_item['qty'];
                                $StockUpdateArray[$stockArrayCounter]['drug_id'] = $drug_price_master['drug_id'];
                                $StockUpdateArray[$stockArrayCounter]['batch_no'] = $pharmacy_stock['batch_no'];
                                $stockArrayCounter++;

                            } else {
                                $leftToDispense = $bill_item['qty'];

                                foreach ($pharmacy_all_active_batches as $batch) {

                                    if ($leftToDispense < 1) {
                                        break;
                                    }
                                    $currentDispenseQty = 0;

                                    if ($leftToDispense > $batch['qty_in_stock']) {

                                        $currentDispenseQty = $batch['qty_in_stock'];
                                        $leftToDispense = $leftToDispense - $batch['qty_in_stock'];

                                    } else {

                                        $currentDispenseQty = $leftToDispense;
                                        $leftToDispense = 0;

                                    }

                                    //populate stock array update
                                    $StockUpdateArray[$stockArrayCounter]['bill_id'] = $bill_item['id'];
                                    $StockUpdateArray[$stockArrayCounter]['dispense_info'] = "Dispense " . $currentDispenseQty . " " . $dispensePackageInfo['name'] . "(s) from batch " . $batch['batch_no'];

                                    $StockUpdateArray[$stockArrayCounter]['stock_id'] = $pharmacy_stock['stock_id'];
                                    $currentStock = $batch['qty_in_stock'] - $currentDispenseQty;
                                    $StockUpdateArray[$stockArrayCounter]['qty_to_reduce'] = $currentDispenseQty;
                                    $StockUpdateArray[$stockArrayCounter]['drug_id'] = $drug_price_master['drug_id'];
                                    $StockUpdateArray[$stockArrayCounter]['batch_no'] = $batch['batch_no'];
                                    $stockArrayCounter++;

                                }
                            }

                        }

                    } else {
                        //this fix may not work i think this happens when panadol is twice in a list will have to stop that from happening
                        if ($last_drug_id == $drug_price_master['drug_id']) {
                            $pharmacy_stock['qty_in_stock'] = $currentStock;
                        }

                        $last_drug_id == $drug_price_master['drug_id'];


                        //not in the same package get stock rules and calculate
                        $rules = $this->drug_stock_rules_model->getDrugStockRule($drug_price_master['drug_id']);

                        foreach ($rules as $rule) {
                            if ($rule['multiplied_package_id'] == $package_id_to_dispense) {
                                $calculatedNumberInStock = $rule['multiplier'] * $total_number_in_stock;


                                if ($bill_item['qty'] > $calculatedNumberInStock) {
                                    $isInStock = false;
                                    $array = array('notice' => $bill_master['service_name'] . " is not in stock. ");
                                    $this->session->set_userdata($array);
                                    break;
                                } else {
                                    //if the random selected can take it
                                    if (($bill_item['qty'] / $rule['multiplier']) <= $pharmacy_stock['qty_in_stock']) {
                                        $StockUpdateArray[$stockArrayCounter]['bill_id'] = $bill_item['id'];
                                        $StockUpdateArray[$stockArrayCounter]['dispense_info'] = "Dispense " . $bill_item['qty'] . " " . $dispensePackageInfo['name'] . "(s) from batch " . $pharmacy_stock['batch_no'];
                                        $StockUpdateArray[$stockArrayCounter]['stock_id'] = $pharmacy_stock['stock_id'];
                                        $currentStock = $pharmacy_stock['qty_in_stock'] - ($bill_item['qty'] / $rule['multiplier']);
                                        $StockUpdateArray[$stockArrayCounter]['qty_to_reduce'] = $bill_item['qty'] / $rule['multiplier'];
                                        $StockUpdateArray[$stockArrayCounter]['drug_id'] = $drug_price_master['drug_id'];
                                        $StockUpdateArray[$stockArrayCounter]['batch_no'] = $pharmacy_stock['batch_no'];
                                        $stockArrayCounter++;
                                    } //if it can not take it
                                    else {


                                        $leftToDispense = $bill_item['qty'] / $rule['multiplier'];

                                        foreach ($pharmacy_all_active_batches as $batch) {

                                            if ($leftToDispense < 1) {
                                                break;
                                            }
                                            $currentDispenseQty = 0;

                                            if ($leftToDispense > $batch['qty_in_stock']) {

                                                $currentDispenseQty = $batch['qty_in_stock'];
                                                $leftToDispense = $leftToDispense - $batch['qty_in_stock'];

                                            } else {

                                                $currentDispenseQty = $leftToDispense;
                                                $leftToDispense = 0;

                                            }

                                            $StockUpdateArray[$stockArrayCounter]['bill_id'] = $bill_item['id'];
                                            $StockUpdateArray[$stockArrayCounter]['dispense_info'] = "Dispense " . $bill_item['qty'] . " " . $dispensePackageInfo['name'] . "(s) from batch " . $batch['batch_no'];

                                            //populate stock array update
                                            $StockUpdateArray[$stockArrayCounter]['stock_id'] = $pharmacy_stock['stock_id'];
                                            $currentStock = $batch['qty_in_stock'] - $currentDispenseQty;
                                            $StockUpdateArray[$stockArrayCounter]['qty_to_reduce'] = $currentDispenseQty;
                                            $StockUpdateArray[$stockArrayCounter]['drug_id'] = $drug_price_master['drug_id'];
                                            $StockUpdateArray[$stockArrayCounter]['batch_no'] = $batch['batch_no'];
                                            $stockArrayCounter++;

                                        }

                                        //end of cannot take it


                                    }
                                }

                                break;
                            }
                        }

                    }
                }

                //if there is a custom price use it
                if(isset($bill_item['selling_price']) && $bill_item['selling_price'] != ""){

                    $amount = $amount + $bill_item['selling_price'];

                }else{

                    //use the normal price as required
                    $amount = $amount + ($bill_item['unit_price'] * $bill_item['qty']);

                }

            }


            //check if the drug is not in stock then send the corresponding error
            if (!$isInStock) {

                if ($this->input->post('patient_number') == NON_CUSTOMER_ID) {
                    // $reference = $formalReference;
                    redirect("/billing/nonCustomerBill/" . $formalReference);
                } else {
                    $patient_number = $this->input->post('patient_number');
                    redirect('/billing/currentBill/' . $patient_number);
                }

            }

            if ($patient_type_code != "H") {

                if ($this->input->post("partial_payment_flag") == "Y") {
                    //partial payment logic here

                    $this->bills_model->createPartialPayment($bills, $reference, $patient_number, $amount, $dispenseData, $this->input->post("partial_amount"));
                } else {
                    $this->bills_model->postBills($bills, $reference, $patient_number, $amount, $dispenseData);
                    $array = array('notice' => "Bill Sucessfully posted");
                }


            } else {
                $this->bills_model->addBillToHmo($bills, $reference, $patient_number, $amount, $dispenseData);
                $array = array('notice' => "Sucessfully Added To Provider Bill");

            }


            //update stock info after the payment, as a manadatory stock order has been given
            if ($StockUpdateArray) {
                foreach ($StockUpdateArray as $update) {
                    $pharmacy_stock = $this->pharmacy_stock_model->getStockByBatchNumber($update['drug_id'], $update['batch_no']);
                    $data['qty_in_stock'] = $pharmacy_stock['qty_in_stock'] - $update['qty_to_reduce'];

                    if ($data['qty_in_stock'] < 1) {
                        $data['status'] = "I";
                    }
                    $this->general_update_model->update("pharmacy_stock", "stock_id", $update['stock_id'], $data);

                    //update the dispense info to guide in dispensing
                    $bill_item = $this->bills_model->getBill($update['bill_id']);
                    $bill_data["additional_info"] = $bill_item['additional_info'] . " " . $update["dispense_info"];
                    $this->general_update_model->update("bills", "id", $update['bill_id'], $bill_data);

                }
            }

            //clear the data array to prepare for new posting
            $data = array();


            //fix: using old reference for order
            $data["reference_id"] = $reference;


            $this->general_update_model->update("laboratory_test_orders", "reference_id", $formalReference, $data);

            //if it is a non customer update the status to paid
            if ($this->input->post("patient_number") == NON_CUSTOMER_ID) {

                $updateData['status'] = "P";


                $this->general_update_model->update("non_customer_orders",
                    "reference_id",
                    $formalReference,
                    $updateData);

            }


            $this->session->set_userdata($array);


            //if amount was offset from the current deposit
            if($this->input->post("offset_from_deposit_flag") == 'Y' ){

                $deposit = $this->patient_deposit_model->getLatestDepositByPatientNumber($this->input->post("patient_number"));

                $this->patient_deposit_model->updatePatientDepositRecord($deposit["patient_deposit_id"],
                    "D",$this->input->post("partial_amount"),
                    $reference);
            }

            //if it is a security deposit // do the last leg update the security deposit of the patient
            if($isSecurityDeposit){

                $deposit = $this->patient_deposit_model->getLatestDepositByPatientNumber($this->input->post("patient_number"));


                if(isset($deposit) && sizeof($deposit) > 1){

                    //deposit exists update
                    $this->patient_deposit_model->updatePatientDepositRecord($deposit["patient_deposit_id"],
                        "C",$this->input->post("partial_amount"),
                        $reference);
                }else{

                    //doesn't exist create new deposit
                    $this->patient_deposit_model->createPatientDepositRecord($patient_number,
                        $this->input->post("partial_amount")
                        , $reference);

                }
            }


            $array = array('notice' => "Bill successfully posted");
            $this->session->set_userdata($array);


            //update, redirect to the printing page instead of searching for bill again

            if($this->input->post("patient_number") == NON_CUSTOMER_ID){

                redirect("/billing/nonCustomerBill/$reference");

            }else{

                redirect("/billing/viewBill/$reference");
            }

            // redirect('/billing');

        }
    }

    public function postBill()
    {

        if ($this->session->userdata('logged_in')) {

            $this->moduleAccessCheck(POST_BILL);

            $patientNumber = $this->input->post('patient_number');
            $postedBills = $this->input->post('bill');
            $partialPaymentFlag = $this->input->post('partial_payment_flag');
            $partialPreviouslyRecieved = $this->input->post('partial_previously_recieved');
            $partialPaymentRef = $this->input->post('partial_payment_ref');
            $partialAmount = $this->input->post('partial_amount');
			$paymentTypeMode = $this->input->post('payment_mode_type');
            $patientTypeCode = $this->input->post('patient_type_code');
            $offsetFromDepositFlag = $this->input->post('offset_from_deposit_flag');
            $hmoSplitFlag = $this->input->post('hmo_split_flag');
            $hmo_patient_split_amount = $this->input->post('hmo_patient_split_amount');
            $paymentMode = "web";
            $paymentReference = "N/A";




            $response = 
                $this->bill_service->postBill($patientNumber, $postedBills, $partialPaymentFlag, $partialPreviouslyRecieved,
                     $partialPaymentRef, $partialAmount, $patientTypeCode, $offsetFromDepositFlag, $hmoSplitFlag,
                $hmo_patient_split_amount,$paymentMode, $paymentReference,$paymentTypeMode);

            $array = array('notice' => $response["description"]);
            $this->session->set_userdata($array);

            if($response["status"] == true){

                if($patientNumber == NON_CUSTOMER_ID){

                    //redirect("/billing/nonCustomerBill/".$response["reference"]);
					redirect("/billing/nonCustomerBill/".$this->input->post("reference_id"));

                }else{


                    redirect("/billing/viewBill/".$this->input->post("reference_id"));
                }

            }else{

                if($patientNumber == NON_CUSTOMER_ID){

                    redirect('/billing/nonCustomerBill/' . $this->input->post("reference_id"));

                }else
                        redirect('/billing/currentBill/' . $patientNumber);
            }


        } else {
            redirect('/login');
        }
    }

    
    public function updateBill()
    {
        if ($this->session->userdata('logged_in')) {

            //check for module access
            $this->moduleAccessCheck(CREATE_BILL);

            if (null == $this->input->post('patient_number')
                || null == $this->input->post('qty')
                || null == $this->input->post('bill_id')
                || null == $this->input->post('staff_no')
            ) {
                $array = array('notice' => "invalid request");
                $this->session->set_userdata($array);
                redirect('/home');
            }
            //get the bill def from database
            $bill = $this->bill_master_model->getBill($this->input->post('bill_id'));

            $reference = $this->input->post('reference');


            if (!isset($bill) || $bill == "") {
                $array = array('notice' => "Invalid Request");
                $this->session->set_userdata($array);
                redirect("/home");
            }

            //get other store bills in the system with the same reference
            $existingBills = $this->bills_model->getBillByReference($reference);


            foreach($existingBills as $item){

                if(strtolower($item["service_name"]) == "deposit"){

                    $array = array('notice' => "Please post the security deposit first before proceeding");

                    $this->session->set_userdata($array);

                    if($this->input->post('patient_number') == NON_CUSTOMER_ID){

                        redirect('/billing/nonCustomerBill/' . $reference);

                    }else{

                        redirect('/billing/currentBill/' . $this->input->post('patient_number'));

                    }

                    break;
                }
            }

            //check if the bill reference is the a deposit bill, throw error only deposit bill allowed in a bill
            if(strtolower($bill["service_name"]) == "deposit"){

                $array = array('notice' => "Can not add a deposit bill to an existing bill, please post current bill first");

                $this->session->set_userdata($array);

                if($this->input->post('patient_number') == NON_CUSTOMER_ID){

                    redirect('/billing/nonCustomerBill/' . $reference);

                }else{

                    redirect('/billing/currentBill/' . $this->input->post('patient_number'));

                }

            }



            //check if dispense is needed

            $dispenseNeeded = NULL;
            $labTestNeeded = NULL;

            if ($bill["drug_price_id"]) {
                $dispenseNeeded = 'Y';
            }


            $this->bills_model->set_bill($reference, $bill, $dispenseNeeded);


            //set lab order if is a lab bill
            if ($bill["lab_price_id"]) {

                $labTestNeeded = 'Y';
                $lab_price = $this->laboratory_price_model->getLabTestPrice($bill["lab_price_id"]);

                $this->lab_orders_model->set_Order($this->input->post('patient_number'),
                    NULL,
                    $lab_price['lab_id'],
                    $reference,
                    $this->session->userdata("staff_no"));
            }


            $array = array('last_bill_reference' => $reference);
            $this->session->set_userdata($array);


            $patient_number = $this->input->post('patient_number');

            if ($patient_number == NON_CUSTOMER_ID) {
                if ($dispenseNeeded) {
                    $data['dispense_needed'] = $dispenseNeeded;
                    $this->general_update_model->update("non_customer_orders", "reference_id", $reference, $data);
                } else if ($labTestNeeded) {
                    $data['lab_operation_needed'] = $labTestNeeded;
                    $this->general_update_model->update("non_customer_orders", "reference_id", $reference, $data);
                }

                redirect('/billing/nonCustomerBill/' . $reference);
            } else

                redirect('/billing/currentBill/' . $patient_number);
        } else {
            redirect('/login');

        }
    }

    public function create()
    {
        $isHospitalCustomer = true;

        if ($this->session->userdata('logged_in')) {

            //check for module access
            $this->moduleAccessCheck(CREATE_BILL);

            if (null == $this->input->post('patient_number')
                || null == $this->input->post('qty')
                || null == $this->input->post('bill_id')
                || null == $this->input->post('staff_no')
            ) {
                $array = array('notice' => "invalid request");
                $this->session->set_userdata($array);
                redirect('/home');
            }


            $reference = $this->input->post('patient_number').now();


            if ($this->input->post('patient_number') != NON_CUSTOMER_ID) {
                $currentBillRef = $this->bills_model->get_current_bill($this->input->post('patient_number'));

                if (sizeof($currentBillRef) == 1) {
                    $reference = $currentBillRef['reference_id'];
                }

            } else {
                $reference = "WALKIN|BILL|" . now();
                $isHospitalCustomer = false;

            }

            //get the bill def from database
            $bill = $this->bill_master_model->getBill($this->input->post('bill_id'));

            if (!isset($bill) || $bill == "") {
                $array = array('notice' => "Invalid Request");
                $this->session->set_userdata($array);
                redirect("/home");
            }

            if (!$isHospitalCustomer && !$bill["drug_price_id"] && !$bill["lab_price_id"]) {


                $array = array('notice' => "Only Drugs & Laboratory Tests are supported for non customers, register patient ");
                $this->session->set_userdata($array);
                redirect("/billing");
            }


            $dispenseNeeded = NULL;

            if ($bill["drug_price_id"]) {
                $dispenseNeeded = 'Y';
                //check if it is a non customer
                if ($isHospitalCustomer == false) {

                    $this->non_customer_order_model->createNonCustomerOrder($this->input->post("patient_name"), "D",
                        $reference,
                        'Y', NULL);
                }

            }


            $this->bills_model->set_bill($reference, $bill, $dispenseNeeded);

            //set lab order if is a lab bill
            if ($bill["lab_price_id"]) {


                if ($isHospitalCustomer == false) {
                    $this->non_customer_order_model->createNonCustomerOrder($this->input->post("patient_name"), "L",
                        $reference, NULL, 'Y');
                }

                    $lab_price = $this->laboratory_price_model->getLabTestPrice($bill["lab_price_id"]);

                    $this->lab_orders_model->set_Order($this->input->post('patient_number'),
                        NULL,
                        $lab_price['lab_id'],
                        $reference,
                        $this->session->userdata("staff_no"));



            }

            $array = array('last_bill_reference' => $reference);
            $this->session->set_userdata($array);

            if ($this->input->post('patient_number') == NON_CUSTOMER_ID) {
             //
             //   $this->utilities->redirectWithNotice("home", "Bill Created");
                redirect('billing/nonCustomerBill/'.$reference);
            }

            $patient_number = $this->input->post('patient_number');
            redirect('/billing/currentBill/' . $patient_number);
        } else {
            redirect('/login');

        }
    }


    /**
     * move to service layer later
     * @param $patient_number
     * @param $qty
     * @param $bill_id
     * @param $patient_name
     * @param $staff_no
     * @param $dept_id
     * @param $current_reference : current reference this is used in the case of a walkin patient who has had a previous bill added
     * @return bool
     */
    private function createBill($patient_number, $qty, $bill_id, $patient_name, $staff_no , $dept_id, $current_reference){

        $response = array('status'=>FALSE, 'description'=> "");


        $isHospitalCustomer = true;

        $newNonCustomerBill = true;

        $reference = $patient_number.now();

        //get the bill def from database
        $bill = $this->bill_master_model->getBill($bill_id);

        if ($this->input->post('patient_number') != NON_CUSTOMER_ID) {
            $currentBillRef = $this->bills_model->get_current_bill($patient_number);

            if (sizeof($currentBillRef) == 1) {
                $reference = $currentBillRef['reference_id'];


                //check to be sure tha the current bill does not contain a deposit bill
                //get other store bills in the system with the same reference
                $existingBills = $this->bills_model->getBillByReference($reference);


                $depositValidation = false;

                foreach($existingBills as $item){

                    if(strtolower($item["service_name"]) == "deposit"){

                        $response['status'] = false;
                        $response['description'] = "Patient has a pending security deposit, please post the security deposit first before proceeding";
                        $depositValidation = true;

                        break;
                    }
                }

                if(!$depositValidation){

                    //check if the bill reference is the a deposit bill, throw error only deposit bill allowed in a bill
                    if(strtolower($bill["service_name"]) == "deposit"){

                        $response['status'] = false;
                        $response['description'] = "Can not add a deposit bill to an existing bill, please post current bill first";
                        $depositValidation = true;

                    }
                }


                //a deposit validation occured
                if($depositValidation){

                    return $response;
                }

            }

        } else {

            $reference = "WALKIN|BILL|" . now();
            log_message("debug" , "current reference : ".$current_reference);
            log_message("debug" , "patient name : ".$patient_name);

            $isHospitalCustomer = false;
            if(isset($current_reference) && trim($current_reference) != "" ){

                log_message("info" , "using the previous reference");
                $newNonCustomerBill = false;
                $reference = $current_reference;
            }

            log_message("info", "generated reference : ". $reference);

        }



        if(!isset($bill)){
            $response['status'] = false;
            $response['description'] = "Invalid Bill Selected";
            return $response;
        }


        if (!$isHospitalCustomer && !isset($bill["drug_price_id"]) && !isset($bill["lab_price_id"])) {

            $response['status'] = false;
            $response['description'] = "Patient needs to be registered to access that bill ";
            return $response;
        }


        $dispenseNeeded = NULL;

        if ($bill["drug_price_id"]) {
            $dispenseNeeded = 'Y';
            //check if it is a non customer
            if ($isHospitalCustomer == false) {

                if($newNonCustomerBill == true){
                    //if it is a new bill create a new non custom order
                    $this->non_customer_order_model->createNonCustomerOrder($patient_name, "D",
                        $reference,
                        'Y', NULL);
                }else{

                    $data['dispense_needed'] = $dispenseNeeded;
                    $this->general_update_model->update("non_customer_orders", "reference_id", $reference, $data);

                }

            }

        }

   //add the bill here in proper
   $this->bills_model->addBill($reference, $bill, $dispenseNeeded, $patient_number, $qty,
            $staff_no, $dept_id);

        //set lab order if is a lab bill
        if ($bill["lab_price_id"]) {

            if ($isHospitalCustomer == false) {

                if($newNonCustomerBill == true){

                    $this->non_customer_order_model->createNonCustomerOrder($patient_name, "L",
                        $reference, NULL, 'Y');

                }else{
                    //update the existing since it is an old bill
                    $data['lab_operation_needed'] = 'Y';
                    $this->general_update_model->update("non_customer_orders", "reference_id", $reference, $data);

                }

            }

            $lab_price = $this->laboratory_price_model->getLabTestPrice($bill["lab_price_id"]);

            $this->lab_orders_model->set_Order($patient_number,
                NULL,
                $lab_price['lab_id'],
                $reference,
                $this->session->userdata("staff_no"));
        }

        $response['status'] = true;
        $response['description'] = "Item added to patients bill";
        $response['reference'] = $reference;
        return $response;
    }
    

    //api post to create bill
    public function apiCreateBill(){

        if (null == $this->input->post('patient_number')
            || null == $this->input->post('qty')
            || null == $this->input->post('bill_id')
        ) {
            $array = array('STATUS' => false, 'description' => "Invalid parameters");
            echo json_encode($array);

        }else{

            //now perform checks here before creating the bill
           $response = $this->createBill($this->input->post('patient_number'),
                $this->input->post('qty'),
                $this->input->post('bill_id'),
                $this->input->post('patient_name'),
                $this->session->userdata("staff_no") ,
                1, $this->input->post('current_reference'));

            if($response["status"]){

                $array = array('STATUS' => true, 'description'=>$response["description"], 'reference' => $response['reference']);
                echo json_encode($array);

            }else{

                $array = array('STATUS' => false);
                $array["description"] = $response["description"];
                echo json_encode($array);
            }


        }


    }

    public function index()
    {

        if ($this->session->userdata('logged_in')) {

            $this->confirmUrl();


            //set the billing as the new home for all transactions
            $this->utilities->setSessionHome("/billing");

           /* echo "it got here";
            echo $this->session->userdata("patient_number");
            return false;*/

            //get all user module mappings by role
            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
            $data['hmos'] = $this->hmo_model->getHmo();

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;

            $data['departments'] = $this->department_model->getDepartments();

            $data['title'] = "Medstation | Billing";
            $data['content-description'] = "Bill Management";


            //$data['title']=$this->passwordhash->HashPassword("password");
            $this->load->view('templates/header', $data);
            $this->load->view('templates/mainheader', $data);
            $this->load->view('billing/home');
            $this->load->view('templates/footer');


        } else {


            redirect('/login');

        }
    }



}