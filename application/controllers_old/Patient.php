<?php
//patient class
define ('MODULE_NO', 3);
define ('SUB_MODULE_NO', 1);
define ('ADD_NEW_PATIENT', 6);
define ('EDIT_EXISTING_PATIENT', 7);
define ('SCHEDULE_APPOINTMENT', 8);
define ('VIEW_PATIENT', 9);
define ('TITLE', 'FrontDesk');

class Patient extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('services/patient_service');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('module_map_model');
        $this->load->model('role_model');
        $this->load->model('sub_module_map_model');
        $this->load->model('religion_model');
        $this->load->model('occupation_model');
        $this->load->model('country_model');
        $this->load->model('patient_type_model');
        $this->load->model('hmo_model');
        $this->load->model('file_counter_model');
        $this->load->model('patient_model');
        $this->load->model('state_model');
        $this->load->model('lga_model');
        $this->load->model('patient_history_model');
        $this->load->model('staff_master_model');
        $this->load->model('unit_model');
        $this->load->model('vitals_model');
        $this->load->model('daily_schedule_model');
        $this->load->model('department_model');
        $this->load->model('appointment_model');
        $this->load->model('phenotype_model');
        $this->load->model('bloodgrp_model');
        $this->load->model('general_update_model');
        $this->load->model('next_of_kin_model');
        $this->load->model('relationship_model');
        $this->load->model('bills_model');
        $this->load->model('patient_history_model');
        $this->load->model('marital_model');
        $this->load->model('patient_admission_model');
        $this->load->model('ward_model');
        $this->load->model('bed_model');
        $this->load->model('free_code_model');
        $this->load->model('free_code_2_model');
		$this->load->model('Consultation_model');
		$this->load->model('intake_type_model');
		$this->load->model('output_type_model');
		$this->load->model('delivery_type_model');
		$this->load->model('surgery_model');
		$this->load->model('omt_model');
		
		
		
		
		

    }

    private function confirmUrl()
    {
        if ($this->session->userdata('base_url') != base_url()) {
            redirect("/logout");
        }

    }

    public function uploadPatientPic()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), EDIT_EXISTING_PATIENT);

            $this->session->unset_userdata('alert');


            //needs write access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {

                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/pages');
            }


            if (!$this->input->post("patient_number")) {
                redirect('/pages');
            }


            $config['upload_path'] = 'patients/profile_pics/';
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = '2000';

            /**
             * $config['max_width']  = '400';
             * $config['max_height']  = '400';
             **/


            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());

                $this->session->set_userdata('alert', $error['error']);


                redirect('/patient/number/' . $this->input->post("patient_number"));
            } else {
                $pic = $this->upload->data();
                $new_name = $this->input->post('patient_number') . $pic['file_ext'];

                if ($this->input->post('patient_family_id')) {
                    $new_name = $this->input->post('patient_number') . "-" . $this->input->post('patient_family_id') . $pic['file_ext'];
                }

                //rename the image

                rename("patients/profile_pics/" . $pic['orig_name'], "patients/profile_pics/" . $new_name);


                //create a thumbnail image

                $config['image_library'] = 'gd2';
                $config['source_image'] = "patients/profile_pics/" . $new_name;
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = FALSE;

                $config['width'] = 200;
                $config['height'] = 200;

                $this->load->library('image_lib', $config);

                $this->image_lib->resize();

                $data['patient_pic'] = "patients/profile_pics/" . $new_name;

                $table_name = "patient_master_table";
                $id = "patient_number";
                $id_value = $this->input->post("patient_number");

                if ($this->input->post('patient_family_id')) {
                    $id = "patient_family_id";
                    $id_value = $this->input->post("patient_family_id");
                    $table_name = "patient_family_table";

                }

                $this->general_update_model->update($table_name, $id, $id_value, $data);

                if ($this->input->post('patient_family_id')) {
                    $array['family_member'] = true;
                    $array['patient_family_id'] = $this->input->post('patient_family_id');
                    $this->session->set_userdata($array);
                }


                $this->session->set_userdata('alert', "picture uploaded sucessfully");
                redirect('/patient/number/' . $this->input->post("patient_number"));

            }
        } else {
            redirect('/login');
        }

    }
	
	
	
	
	
	public function uploadPatientPicWebcam()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), EDIT_EXISTING_PATIENT);

            $this->session->unset_userdata('alert');


            //needs write access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {

                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/pages');
            }


            if (!$this->input->post("patient_number")) {
                redirect('/pages');
            }


            //$config['upload_path'] = 'patients/profile_pics/';
            //$config['allowed_types'] = 'jpg|png';
            //$config['max_size'] = '2000';


            if (!$_POST['image']) {
                $error = array('error' => 'No image scanned');

                $this->session->set_userdata('alert', $error['error']);


                redirect('/patient/number/' . $this->input->post("patient_number"));
            } else {
				
				
				$img = $_POST['image'];
				$folderPath = "patients/profile_pics/";
			  
				$image_parts = explode(";base64,", $img);
				$image_type_aux = explode("image/", $image_parts[0]);
				$image_type = $image_type_aux[1];
			  
				$image_base64 = base64_decode($image_parts[1]);
				//$fileName = uniqid() . '.png';
				
				$fileName = $this->input->post('patient_number') . '.png';

                if ($this->input->post('patient_family_id')) {
                    $fileName = $this->input->post('patient_number') . "-" . $this->input->post('patient_family_id') . '.png';
                }
			  
				$file = $folderPath . $fileName;
				file_put_contents($file, $image_base64);
				
                
                //create a thumbnail image

                
                $data['patient_pic'] = "patients/profile_pics/" . $fileName;

                $table_name = "patient_master_table";
                $id = "patient_number";
                $id_value = $this->input->post("patient_number");

                if ($this->input->post('patient_family_id')) {
                    $id = "patient_family_id";
                    $id_value = $this->input->post("patient_family_id");
                    $table_name = "patient_family_table";

                }

                $this->general_update_model->update($table_name, $id, $id_value, $data);

                if ($this->input->post('patient_family_id')) {
                    $array['family_member'] = true;
                    $array['patient_family_id'] = $this->input->post('patient_family_id');
                    $this->session->set_userdata($array);
                }


                $this->session->set_userdata('alert', "picture uploaded sucessfully from Webcam");
                redirect('/patient/number/' . $this->input->post("patient_number"));

            }
        } else {
            redirect('/login');
        }

    }
	
	

    public function updateHmo(){

        $this->utilities->aunthenticateAccess(EDIT_EXISTING_PATIENT, "home");

        $patientNumber = $this->input->post("patient_number");

        if(!isset($patientNumber)){
            $this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNCTION_CALL));
        }

        if($this->input->post("hmo_enrolee_id")){

            $data["hmo_enrolee_id"] = $this->input->post("hmo_enrolee_id");
			
        }
		
		if($this->input->post("hmo_code")){

            $data["hmo_code"] = $this->input->post("hmo_code");
			
        }
		
		if($this->input->post("pri_enrolee_id")){

            $data["primary_enrollee_id"] = $this->input->post("pri_enrolee_id");
			
        }
		
		if($this->input->post("rel_to_primary_enrollee")){

            $data["rel_to_primary_enrolle"] = $this->input->post("rel_to_primary_enrollee");
			
        }

        $table_name = "patient_master_table";
        $id = "patient_number";
        $id_value = $this->input->post("patient_number");
        $this->general_update_model->update($table_name, $id, $id_value, $data);


        $this->utilities->redirectWithNotice('/patient/number/' .$patientNumber, "Hmo data updated");
    }

    public function updateAddressData()
    {
        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), EDIT_EXISTING_PATIENT);

            //needs write access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/pages');
            }


            if ($this->input->post("address_line_1")) {
                $data["address_line_1"] = $this->input->post("address_line_1");
            }


            if ($this->input->post("address_line_2")) {
                $data["address_line_2"] = $this->input->post("address_line_2");
            }

            if ($this->input->post("address_state_code")) {
                $data["address_state_code"] = $this->input->post("address_state_code");
            }
            if ($this->input->post("address_country_code")) {
                $data["address_country_code"] = $this->input->post("address_country_code");
            }


            $table_name = "patient_master_table";
            $id = "patient_number";
            $id_value = $this->input->post("patient_number");
            $this->general_update_model->update($table_name, $id, $id_value, $data);

            //$this->number($this->input->post("patient_number"));

            redirect('/patient/number/' . $this->input->post("patient_number"));


        } else {
            redirect('/login');
        }

    }

    public function updatePhysicData()
    {
        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), EDIT_EXISTING_PATIENT);

            //needs write access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/pages');
            }


            if ($this->input->post("blood_group_id")) {
                $data["blood_group_id"] = $this->input->post("blood_group_id");
            }


            if ($this->input->post("genotype_id")) {
                $data["phenotype_id"] = $this->input->post("genotype_id");
            }

            if ($this->input->post("height")) {
                $data["height"] = $this->input->post("height");
            }

            if ($this->input->post("weight")) {
                $data["weight"] = $this->input->post("weight");
            }


            $table_name = "patient_master_table";
            $id = "patient_number";
            $id_value = $this->input->post("patient_number");

            if ($this->input->post('patient_family_id')) {
                $id = "patient_family_id";
                $id_value = $this->input->post("patient_family_id");
                $table_name = "patient_family_table";

                $array['family_member'] = true;
                $array['patient_family_id'] = $this->input->post('patient_family_id');
                $this->session->set_userdata($array);
            }

            $this->general_update_model->update($table_name, $id, $id_value, $data);


            redirect('/patient/number/' . $this->input->post("patient_number"));


        } else {
            redirect('/login');
        }
    }

    public function updateKinData()
    {
        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), EDIT_EXISTING_PATIENT);

            //needs write access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/pages');
            }


            if ($this->input->post("first_name")) {
                $data["first_name"] = $this->input->post("first_name");
            }


            if ($this->input->post("middle_name")) {
                $data["middle_name"] = $this->input->post("middle_name");
            }

            if ($this->input->post("last_name")) {
                $data["last_name"] = $this->input->post("last_name");
            }

            if ($this->input->post("address_line_1")) {
                $data["address_line_1"] = $this->input->post("address_line_1");
            }
            if ($this->input->post("address_line_2")) {
                $data["address_line_2"] = $this->input->post("address_line_2");
            }

            if ($this->input->post("relationship_id")) {
                $data["relationship_id"] = $this->input->post("relationship_id");
            }
            if ($this->input->post("mobile_number")) {
                $data["mobile_number"] = $this->input->post("mobile_number");
            }
            if ($this->input->post("cell_number")) {
                $data["cell_number"] = $this->input->post("cell_number");
            }

            if ($this->input->post("kin_state_code")) {
                $data["state_code"] = $this->input->post("kin_state_code");
            }
            if ($this->input->post("country_code")) {
                $data["country_code"] = $this->input->post("country_code");
            }


            $nextofkin = $this->next_of_kin_model->getNextOfKin($this->input->post("patient_number"));

            if (sizeof($nextofkin) < 1) {
                $data['patient_number'] = $this->input->post("patient_number");
                $this->next_of_kin_model->set_nextofkin($data);

            } else {


                $table_name = "patient_next_of_kin";
                $id = "patient_number";
                $id_value = $this->input->post("patient_number");
                $this->general_update_model->update($table_name, $id, $id_value, $data);

            }


            redirect('/patient/number/' . $this->input->post("patient_number"));


        } else {
            redirect('/login');
        }
    }

    public function updatePersonalData()
    {
        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), EDIT_EXISTING_PATIENT);

            //needs write access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/pages');
            }


            $data["first_name"] = $this->input->post("first_name");

            if ($this->input->post("first_name")) {
                $data["first_name"] = $this->input->post("first_name");
            }

            if ($this->input->post("dob")) {
                $splitdob = preg_split('[-]', $this->input->post("dob"));

                $data['dob'] = $splitdob[2] . "-" . $splitdob[0] . "-" . $splitdob[1];
            }

            if ($this->input->post("last_name")) {
                $data["last_name"] = $this->input->post("last_name");
            }

            if ($this->input->post("middle_name")) {
                $data["middle_name"] = $this->input->post("middle_name");
            }

            if ($this->input->post("marital_status")) {
                $data["marital_status"] = $this->input->post("marital_status");
            }
            if ($this->input->post("religion_id")) {
                $data["religion_id"] = $this->input->post("religion_id");
            }

            if ($this->input->post("occupation_id")) {
                $data["occupation_id"] = $this->input->post("occupation_id");
            }
            if ($this->input->post("mobile_number")) {
                $data["mobile_number"] = $this->input->post("mobile_number");
            }
            if ($this->input->post("cell_number")) {
                $data["cell_number"] = $this->input->post("cell_number");
            }
            if ($this->input->post("email")) {
                $data["email"] = $this->input->post("email");
            }
            if ($this->input->post("alt_email")) {
                $data["alt_email"] = $this->input->post("alt_email");
            }
			if ($this->input->post("free_code_1")) {
                $data["free_code_1"] = $this->input->post("free_code_1");
            }
			if ($this->input->post("free_code_2")) {
                $data["free_code_2"] = $this->input->post("free_code_2");
            }


            $table_name = "patient_master_table";
            $id = "patient_number";
            $id_value = $this->input->post("patient_number");

            if ($this->input->post('patient_family_id')) {
                $id = "patient_family_id";
                $id_value = $this->input->post("patient_family_id");
                $table_name = "patient_family_table";

                $array['family_member'] = true;
                $array['patient_family_id'] = $this->input->post('patient_family_id');
                $this->session->set_userdata($array);
            }


            $this->general_update_model->update($table_name, $id, $id_value, $data);

            //$this->number($this->input->post("patient_number"));

            redirect('/patient/number/' . $this->input->post("patient_number"));


        } else {
            redirect('/login');
        }

    }

    public function viewFamMember()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            if (!$this->input->post('patient_family_id') || !$this->input->post('patient_number')) {
                redirect("/patient/number/" . $this->input->post('patient_number'));
            }
            $array = array('family_member' => true, 'patient_family_id' => $this->input->post('patient_family_id'),'patient_family_id_new'=>$this->input->post('patient_family_id'));
            $this->session->set_userdata($array);

            redirect("/patient/number/" . $this->input->post('patient_number'));
        } else {
            redirect("/login");
        }
    }

    public function removeFromFam()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), EDIT_EXISTING_PATIENT);

            //needs write access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/home');
            }

            if (!$this->input->post('fam_patient_family_id')) {
                $array = array('notice' => "Invalid Function Call");
                $this->session->set_userdata($array);
                redirect('/home');
            }


            $table_name = "patient_family_table";
            $id = "patient_family_id";
            $id_value = $this->input->post('fam_patient_family_id');

            $data["status"] = "I";

            $this->general_update_model->update($table_name, $id, $id_value, $data);
            $array = array('notice' => "Patient Family Member sucessfully removed");
            $this->session->set_userdata($array);
            redirect('/patient/number/' . $this->input->post('patient_number'));


        } else {
            redirect('/login');
        }
    }

    public function recordVital()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), UPDATE_VITALS);

            //needs write access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/home');
            }


            $patient_number = $_POST['patient_number'];

            if (empty($patient_number)) {
                redirect('/frontdesk');
            }

            $this->vitals_model->set_vitals();

            if ($this->input->post('patient_family_id')) {
                $array['family_member'] = true;
                $array['patient_family_id'] = $this->input->post('patient_family_id');

            }


            $this->session->set_userdata($array);

            redirect('/patient/number/' . $patient_number);

        } else {
            redirect('/login');
        }

    }

    public function getQueueNumber()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), SUB_MODULE_NO);

            //read access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                return false;
            }

            return $this->daily_schedule_model->obtainQueueNumber();
        } else {
            return false;
        }

    }

    public function getHistoryDataJson()
    {

        $history = $this->patient_history_model->getHistory($this->input->post('patient_history_id'), 0);
        //$history = $this->patient_history_model->getHistory(8, 0);
        echo json_encode($history);
    }
	
	public function getDeliveryReportDataJson()
    {

        $history = $this->delivery_type_model->getDeliveryReportById($this->input->post('deliver_report_id'), 0);
        //$history = $this->patient_history_model->getHistory(8, 0);
        echo json_encode($history);
    }
	
	public function getReferralReportDataJson()
    {

        $history = $this->Consultation_model->getReferralReportById($this->input->post('referral_report_id'), 0);
        //$history = $this->patient_history_model->getHistory(8, 0);
        echo json_encode($history);
    }
	
	public function getSurgeryReportDataJson()
    {

        $history = $this->surgery_model->getSurgery($this->input->post('surgery_report_id'), 0);
        //$history = $this->patient_history_model->getHistory(8, 0);
        echo json_encode($history);
    }
	
	public function getConsultationDataJson()
    {

        $history = $this->patient_history_model->getConsultation($this->input->post('patient_history_id'), 0);
        //$history = $this->patient_history_model->getHistory(8, 0);
        echo json_encode($history);
    }
	
		
    //getPatientByFamily
    public function searchFamily()
    {
        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();

            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), VIEW_PATIENT);

            //read access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/pages');
            }

            $data['patients'] = $this->patient_model->getPatientByFamily();


            //get all user module mappings by role
            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

            $data['patient_types'] = $this->patient_type_model->getType();
            $data['title'] = "Medstation | Patient Search";
            $data['search_url'] = "index.php/patient/search";

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;
            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));

            $this->load->view('templates/header', $data);
            $this->load->view('templates/mainheader', $data);
            $this->load->view('frontdesk/patient/search', $data);
            $this->load->view('templates/footer');

        } else {
            redirect('/login');
        }

    }

    public function searchSubscribers()
    {
        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();

            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), VIEW_PATIENT);

            //read access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/pages');
            }



            if (isset($_POST['hmo_code']) && $_POST['hmo_code'] != "") {
                $data['patients'] = $this->patient_model->getPatientByHmo($_POST['hmo_code']);
            } else {
                $data['patients'] = $this->patient_model->getPatientByHmo();
            }


            //get all user module mappings by role
            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

            $data['patient_types'] = $this->patient_type_model->getType();
			$data['providers'] = $this->hmo_model->getHmo();
            $data['title'] = "Medstation | Patient Search";
            $data['search_url'] = "index.php/patient/search";

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;
            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));

            $this->load->view('templates/header', $data);
            $this->load->view('templates/mainheader', $data);
            $this->load->view('frontdesk/patient/search', $data);
            $this->load->view('templates/footer');

        } else {
            redirect('/login');
        }

    }

    public function scheduleAppointment()
    {

        if ($this->session->userdata('logged_in')) {

            $this->confirmUrl();


            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), SCHEDULE_APPOINTMENT);

            //read access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $status = array("STATUS" => "false", "ERROR" => "You do not have access to this function");
                echo json_encode($status);

            } else {
                if ($this->input->post("patient_family_id")) {
                    $alreadyScheduled = $this->appointment_model->checkifFamAlreadyHaveAppointment($this->input->post('patient_number'),
                        $this->input->post('date'),
                        $this->input->post('time'),
                        $this->input->post("patient_family_id"),
                        $this->input->post('staff_no')
                    );
                } else {
                    $alreadyScheduled = $this->appointment_model->checkifAlreadyHaveAppointment($this->input->post('patient_number'),
                        $this->input->post('date'),
                        $this->input->post('time'),
                        $this->input->post('staff_no'));
                }


                if ($alreadyScheduled) {

                    $status = array("STATUS" => "false", "ERROR" => "Appointment has already been scheduled for patient");

                    echo json_encode($status);
                } else {
                    $this->appointment_model->set_appointment();

                    $status = array("STATUS" => "true", "ERROR" => "Unknown error", "NUMBER" => "Appointment Scheduled");

                    echo json_encode($status);
                }


            }


        } else {
            $status = array("STATUS" => "false", "ERROR" => "User Not logged in");
            echo json_encode($status);
        }
    }

    //updateQueueStatus
    public function queueCheckIn()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();

            log_message("debug", "about to check user into queue");

            $queueNumber = $this->getQueueNumber();

            log_message("debug", "queue number generated is ".$queueNumber);


            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), SUB_MODULE_NO);

            //read access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $status = array("STATUS" => "false", "ERROR" => "You do not have access to this function");
                log_message("debug", "user no access to function");
                echo json_encode($status);


            } else {

                $department = $this->input->post('dept_id');
                $staff_no = $this->input->post('staff_no');
                $patient_number = $this->input->post('patient_number');

                log_message("debug","got the following parameters from the request department : $department , patient number : $patient_number, 
                  staff number : $staff_no");
                /**
                 *
                 * $patient_number  = '2014CWG1';
                 * $department = 2;
                 * $staff_no = 'DOC001';
                 **/

                if ($this->input->post("patient_family_id")) {
                    $isInQueue = $this->daily_schedule_model->checkifFamAlreadyQueued($patient_number, $department, $this->input->post("patient_family_id"), $staff_no);
                } else {
                    $isInQueue = $this->daily_schedule_model->checkifAlreadyQueued($patient_number, $department, $staff_no);
                }

                //$isInQueue = TRUE;

                if(isset($isInQueue)){
                    log_message("debug", "is in queue value is ".json_encode($isInQueue));

                }


                if (isset($isInQueue) && $isInQueue != "") {
                    if ($isInQueue['status'] == "L") {

                        $table_name = "daily_schedule";
                        $id = "schdule_id";
                        $id_value = $isInQueue['schdule_id'];


                        $data = array(
                            'queue_number' => $queueNumber,
                            'status' => 'A'
                        );


                        if ($department) {
                            $data['dept_id'] = $department;
                        }

                        if ($staff_no) {
                            $data['staff_no'] = $staff_no;
                        }

                        if ($patient_number) {
                            $data['patient_number'] = $patient_number;
                        }

                        if ($this->input->post("patient_family_id")) {
                            $data['patient_family_id'] = $this->input->post("patient_family_id");
                        }

                        log_message("debug", "finished building queue update " . json_encode($data));

                        $this->general_update_model->update($table_name, $id, $id_value, $data);

                        $status = array("STATUS" => "true", "ERROR" => "", "NUMBER" => $queueNumber);

                        echo json_encode($status);
                    } else {

                        log_message("debug", "user already in todays queue");

                        $status = array("STATUS" => "false", "ERROR" => "Already In Today's Queue");

                        echo json_encode($status);
                    }

                } else {
                    $this->daily_schedule_model->set_queue($queueNumber);
                    log_message("debug", "finished adding new queue member");

                    $status = array("STATUS" => "true", "ERROR" => "", "NUMBER" => $queueNumber);
                    echo json_encode($status);
                }


            }


        } else {
            $status = array("STATUS" => "false", "ERROR" => "User Not logged in");
            echo json_encode($status);
        }
    }

    public function addToQueue()
    {
        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), SUB_MODULE_NO);

            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $status = array("STATUS" => "false", "ERROR" => "You do not have access to this function");
                //echo json_encode ($status) ;

                $array['notice'] = "You do not have access to this function";
                $this->session->set_userdata($array);
                redirect("/frontdesk");


            } else {
                $queueNumber = $this->getQueueNumber();

                $department = null;
                $staff_no = $this->input->post('staff_no');

                $staff = $this->staff_master_model->getStaff($staff_no);
                //print_r($staff);
                $department = $staff['dept_id'];
                $patient_number = $this->input->post('patient_number');
                $appointment_id = $this->input->post('appointment_id');
                /**
                 * check if already in todays queue
                 **/

                if ($this->input->post("patient_family_id")) {
                    $isInQueue = $this->daily_schedule_model->checkifFamAlreadyQueued($patient_number, $department, $this->input->post("patient_family_id"), $staff_no);
                } else {
                    $isInQueue = $this->daily_schedule_model->checkifAlreadyQueued($patient_number, $department, $staff_no);
                }


                if ($isInQueue) {
                    if ($isInQueue['status'] == "L") {


                        $table_name = "daily_schedule";
                        $id = "schdule_id";
                        $id_value = $isInQueue['schdule_id'];


                        $data = array(
                            'queue_number' => $queueNumber,
                            'status' => 'A'
                        );


                        if ($department) {
                            $data['dept_id'] = $department;
                        }

                        if ($staff_no) {
                            $data['staff_no'] = $staff_no;
                        }

                        if ($patient_number) {
                            $data['patient_number'] = $patient_number;
                        }


                        if ($this->input->post("patient_family_id")) {
                            $data['patient_family_id'] = $this->input->post("patient_family_id");
                        }

                        $this->general_update_model->update($table_name, $id, $id_value, $data);

                    }


                } else {
                    $this->daily_schedule_model->set_queue($queueNumber, $department);
                }


                //after adding queue entry now update appointment table to E (entered queue)
                $table_name = "appointment_manager";
                $id = "appointment_id";
                $id_value = $appointment_id;


                $data = array(
                    'status' => 'E'
                );

                $this->general_update_model->update($table_name, $id, $id_value, $data);

                //alert sucess

                $status = array("STATUS" => "true", "ERROR" => "", "NUMBER" => 'updated');

                //echo json_encode ($status) ;

                $array['notice'] = "Patient added to queue with number " . $queueNumber;
                $this->session->set_userdata($array);
                redirect("/frontdesk");
            }
        } else {
            $status = array("STATUS" => "false", "ERROR" => "User Not logged in");
            //echo json_encode ($status) ;
            redirect("/login");
        }
    }

    public function takeTurn()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();


            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), SUB_MODULE_NO);

            //read access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $status = array("STATUS" => "false", "ERROR" => "You do not have access to this function");
                echo json_encode($status);

            } else {


                $this->daily_schedule_model->update_queue($this->input->post('schdule_id'));

                $status = array("STATUS" => "true", "ERROR" => "Unknown error", "NUMBER" => 'updated');

                echo json_encode($status);


            }


        } else {
            $status = array("STATUS" => "false", "ERROR" => "User Not logged in");
            echo json_encode($status);
        }
    }

    public function searchNumber()
    {
        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();

            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), VIEW_PATIENT);

            //read access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/pages');
            }


            if (isset($_POST['patient_number'])) {
                $data['patients'] = $this->patient_model->getPatientLikeNumber($_POST['patient_number']);
            } else {
                $data['patients'] = $this->patient_model->getPatient();
            }


            //get all user module mappings by role
            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

            $data['patient_types'] = $this->patient_type_model->getType();
            $data['title'] = "Medstation | Patient Search";
            $data['search_url'] = "index.php/patient/search";

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;
            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			$data['providers'] = $this->hmo_model->getHmo();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/mainheader', $data);
            $this->load->view('frontdesk/patient/search', $data);
            $this->load->view('templates/footer');

        } else {
            redirect('/login');
        }

    }

    public function search()
    {

        $this->utilities->aunthenticateAccess(VIEW_PATIENT, "home");


            if ($this->input->post("non_patient") && $this->input->post("non_patient") == "true" && isset($_POST['return_base'])) {
                if ($this->input->post("walk_in_patient_name")) {
                    $array = array('walk_in_patient_name' => $this->input->post("walk_in_patient_name"));
                }
                $this->session->set_userdata($array);
                redirect($_POST['return_base'] . "/" . NON_CUSTOMER_ID);
            }

            log_message("info", "about to find patient by name using service");

            $name = NULL;

            if(isset($_POST['name'])){
                $name = $_POST['name'];
            }

            $data['patients'] = $this->patient_service->findPatientByName($name);

            //get all user module mappings by role
            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
            if (isset($_POST['return_base'])) {
                $data['return_base'] = $_POST['return_base'];
            }
            $data['patient_types'] = $this->patient_type_model->getType();
			$data['providers'] = $this->hmo_model->getHmo();
            $data['title'] = "Medstation | Patient Search";
            $data['search_url'] = "index.php/patient/search";

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;
            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));

            $this->load->view('templates/header', $data);
            $this->load->view('templates/mainheader', $data);
            $this->load->view('frontdesk/patient/search', $data);
            $this->load->view('templates/footer');



    }

    public function addFamMember()
    {
        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), ADD_NEW_PATIENT);
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/home');
            }
            $date = new DateTime();
            date_timezone_set($date, timezone_open('Africa/Lagos'));
            $todaysDate = date_format($date, 'Y-m-d H:i:s');

            if (!$this->input->post('fam_first_name') || !$this->input->post('fam_last_name') || !$this->input->post('patient_number') || !$this->input->post('fam_relationship_id')) {
                $array = array('notice' => "Invalid Function Call");
                $this->session->set_userdata($array);
                redirect('/home');

            }
            //set_patient_fam

            $this->patient_model->set_patient_fam();

            $success = "/patient/number/" . $this->input->post('patient_number');
            $array = array('notice' => "Family Member Added");
            $this->session->set_userdata($array);
            redirect($success);
        } else {
            redirect('/login');
        }
    }
	
	
	public function lockfile($patient_number)
    {
        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');
		
		if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), VIEW_PATIENT);

			$table_name = "patient_master_table";
            $id = "patient_number";
            $id_value = $patient_number;

            $data["file_lock"] = "Y";
			$data["file_lock_date"] = $todaysDate;
			$data["file_unlock_date"] = null;

            $this->general_update_model->update($table_name, $id, $id_value, $data);
            $array = array('notice' => "Patient File Locked successfully");
            $this->session->set_userdata($array);
            redirect('/patient/number/' . $patient_number);


		}else {
            redirect('/login');
        }
		
	}
	
	public function unlockfile($patient_number)
    {
        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');
		
		if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), VIEW_PATIENT);

			$table_name = "patient_master_table";
            $id = "patient_number";
            $id_value = $patient_number;

            $data["file_lock"] = "N";
			$data["file_unlock_date"] = $todaysDate;
			$data["file_lock_date"] = null;

            $this->general_update_model->update($table_name, $id, $id_value, $data);
            $array = array('notice' => "Patient File Unlocked successfully");
            $this->session->set_userdata($array);
            redirect('/patient/number/' . $patient_number);


		}else {
            redirect('/login');
        }
		
	}

    public function number($patient_number)
    {
        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');


        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), VIEW_PATIENT);

            //read access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/home');
            }


            //main application

			$data['patient_family_id_new'] = $this->session->userdata('patient_family_id');
			$patient_family_id_new=$this->session->userdata('patient_family_id');
			$data['providers'] = $this->hmo_model->getHmo();
			
            $data['patient'] = $this->patient_model->getPatient($patient_number);

            if ($this->session->userdata('family_member')) {
                $data['family_member'] = $this->patient_model->getPatientFamMember($this->session->userdata('patient_family_id'));
				$data['patient_family_id_new'] = $this->session->userdata('patient_family_id');

                $this->session->unset_userdata('patient_family_id');
                $this->session->unset_userdata('family_member');


                $data['patient']['dob'] = $data['family_member']['dob'];
                $data['patient']['first_name'] = $data['family_member']['first_name'];
                $data['patient']['middle_name'] = $data['family_member']['middle_name'];
                $data['patient']['last_name'] = $data['family_member']['last_name'];
                $data['patient']['last_name'] = $data['family_member']['last_name'];
                $data['patient']['mobile_number'] = $data['family_member']['mobile_number'];
                $data['patient']['cell_number'] = $data['family_member']['cell_number'];
                $data['patient']['email'] = $data['family_member']['email'];
                $data['patient']['alt_email'] = $data['family_member']['alt_email'];
                $data['patient']['email'] = $data['family_member']['email'];
                $data['patient']['sex'] = $data['family_member']['sex'];
                $data['patient']['phenotype_id'] = $data['family_member']['phenotype_id'];
                $data['patient']['blood_group_id'] = $data['family_member']['blood_group_id'];
                $data['patient']['occupation_id'] = "";
                $data['patient']['weight'] = $data['family_member']['weight'];
                $data['patient']['height'] = $data['family_member']['height'];
            }


            if (empty($data['patient'])) {
                redirect('/frontdesk');
            }

            $data['title'] = "Medstation | Patient info";


            //get all user module mappings by role
            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
            $data['religion'] = $this->religion_model->getReligion($data['patient']['religion_id']);
            $data['orign_country'] = $this->country_model->getCountries($data['patient']['orign_country_code']);
            $data['address_country_code'] = $this->country_model->getCountries($data['patient']['address_country_code']);
            $data['state_of_origin'] = $this->state_model->getState($data['patient']['state_of_origin']);
            $data['address_country_code'] = $this->country_model->getCountries($data['patient']['address_country_code']);
            $data['address_state_code'] = $this->state_model->getState($data['patient']['address_state_code']);
            $data['origin_lga_id'] = $this->lga_model->getLga($data['patient']['origin_lga_id']);
            $data['occupation'] = $this->occupation_model->getOccupation($data['patient']['occupation_id']);
            $data['current_bills'] = $this->bills_model->get_number_unposted($patient_number);
			$data['freecode1'] = $this->free_code_model->getFreeCode($data['patient']['free_code_1']);
			$data['freecode2'] = $this->free_code_2_model->getFreeCode($data['patient']['free_code_2']);

            $data['partial_bills'] = $this->bills_model->get_uncompleted_partial_bills_count($patient_number);

            $data['occupations'] = $this->occupation_model->getOccupation();
            $data['religions'] = $this->religion_model->getReligion();
			$data['freecodes1'] = $this->free_code_model->getFreeCode();
			$data['freecodes2'] = $this->free_code_2_model->getFreeCode();
			

            $data['next_of_kin'] = $this->next_of_kin_model->getNextOfKin($data['patient']['patient_number']);
            $data['address_states'] = $this->state_model->getStateByCountry($data['patient']['address_country_code']);
            if (is_array($data['next_of_kin']) && sizeof($data['next_of_kin']) > 1) {

                $data['kin_states'] = $this->state_model->getStateByCountry($data['next_of_kin']['country_code']);
            }


            $data['countries'] = $this->country_model->getCountries();
            $data['relationships'] = $this->relationship_model->getRelationship();
            $data['hmo'] = $this->hmo_model->getHmo($data['patient']['hmo_code']);
			$data['curr_relationship'] = $this->relationship_model->getRelationship($data['patient']['rel_to_primary_enrolle']);
			if($data['patient']['primary_enrollee_id']){
				$data['pri_enrollee'] = $this->patient_model->getPatientByEnroleeId($data['patient']['primary_enrollee_id'],$data['patient']['hmo_code']);
			}				
			//echo $data['patient']['hmo_code'];
			
			//echo $data['patient']['primary_enrollee_id'];
			//echo $data['pri_enrollee']['patient_number'];
			//print_r($data['pri_enrollee']);
			//dd($data['pri_enrollee']);
			if($data['patient']['hmo_enrolee_id']){
				$data['pri_enrollee_dependent'] = $this->patient_model->getPatientByPriEnroleeId($data['patient']['hmo_enrolee_id'],$data['patient']['hmo_code']);
			}
			
			//print_r($data['pri_enrollee_dependent']);
			//dd();

            //$data['history'] = $this->patient_history_model->getRecentHistory($patient_number);
			$data['history'] = $this->Consultation_model->getConsultationMaster($patient_number, $patient_family_id_new);
			$data['allergy'] = $this->Consultation_model->getAllergy($patient_number, $patient_family_id_new);
			$data['examination'] = $this->Consultation_model->getExamination($patient_number, $patient_family_id_new);
			$data['diagnosis'] = $this->Consultation_model->getDiagnosis($patient_number, $patient_family_id_new);
			$data['familyhistory'] = $this->Consultation_model->getFamilyhistory($patient_number, $patient_family_id_new);
			$data['gynaecology'] = $this->Consultation_model->getGynaecology($patient_number, $patient_family_id_new);
			$data['obstetrics'] = $this->Consultation_model->getObstetrics($patient_number, $patient_family_id_new);
			$data['pastmedicalhistory'] = $this->Consultation_model->getPastmedicalhistory($patient_number, $patient_family_id_new);
			$data['legacymedicalhistory'] = $this->patient_history_model->getRecentHistory($patient_number, $patient_family_id_new);
			$data['presentinghistory'] = $this->Consultation_model->getPresentinghistory($patient_number, $patient_family_id_new);
			$data['systemreview'] = $this->Consultation_model->getSystemreview($patient_number, $patient_family_id_new);
			$data['surgery'] = $this->Consultation_model->getSurgery($patient_number, $patient_family_id_new);
			$data['treatment'] = $this->Consultation_model->getTreatment($patient_number, $patient_family_id_new);
			$data['vitalhistory'] = $this->Consultation_model->getVitalhistory($patient_number, $patient_family_id_new);
			$data['patienttype'] = $this->patient_type_model->getType();
			$data['intaketype'] = $this->intake_type_model->getIntake();
			
			$data['outputtype'] = $this->output_type_model->getOutput();
			$data['deliverttype'] = $this->delivery_type_model->getDeliveryType();

			$data['getintaketype'] = $this->intake_type_model->getIntakeByPatientNumber($patient_number);
			$data['getoutputtype'] = $this->output_type_model->getOutputByPatientNumber($patient_number);
			$data['postdelivery'] = $this->delivery_type_model->getDeliveryByPatientNumber($patient_number);
			$data['surgeryreport'] = $this->surgery_model->getSurgeryByPatientNumber($patient_number);
			$data['referralreport'] = $this->Consultation_model->getReferralDetails($patient_number);

            $alert = $this->session->userdata('alert');
            $this->session->unset_userdata('alert');

            if ($alert != "") {
                $data['alert'] = $alert;
            } else if ($this->session->unset_userdata('notice')) {
                $data['alert'] = $this->session->unset_userdata('notice');
            }
            $data['doctors'] = $this->staff_master_model->getDoctors();
            $data['unit'] = $this->unit_model->getUnit();
            $data['departments'] = $this->department_model->getDepartments();


            if (isset($data['family_member']) && $data['family_member'] != "") {
                $data['vitals'] = $this->vitals_model->getFamVitals($patient_number, $data['family_member']['patient_family_id']);
            } else {
                $data['vitals'] = $this->vitals_model->getVitals($patient_number);
            }

            $data['date'] = $todaysDate;
            $data['phenotype'] = $this->phenotype_model->getPhenotype($data['patient']['phenotype_id']);
            $data['bloodgroup'] = $this->bloodgrp_model->getBloodgrp($data['patient']['blood_group_id']);

            $data['phenotypes'] = $this->phenotype_model->getPhenotype();
            $data['bloodgroups'] = $this->bloodgrp_model->getBloodgrp();
            if ($data['patient']['patient_type_code'] == 'F') {
                $data['family_members'] = $this->patient_model->getPatientFamily($data['patient']['patient_number']);
            }

            $date = new DateTime($data['patient']['dob']);
            $dateToday = new DateTime();
            date_timezone_set($date, timezone_open('Africa/Lagos'));

            $splitdob = preg_split('[-]', $data['patient']['dob']);

            $data['dob'] = $splitdob[1] . "-" . $splitdob[2] . "-" . $splitdob[0];

            $diff = strtotime(date_format($dateToday, 'Y-m-d')) - strtotime(date_format($date, 'Y-m-d'));

            $data['age'] = floor($diff / (365 * 60 * 60 * 24));

            //all the wards
            $data['wards'] = $this->ward_model->getWard();


            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;
            //get patient admissions status

            $data['admission_status'] = $this->patient_admission_model->getPatientAdmission($patient_number);
            if (isset($data['admission_status']["ward_id"])) {
                $data["beds_in_ward"] = $this->bed_model->getBedByWard($data['admission_status'] ["ward_id"]);
            }


            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));


            $this->load->view('templates/header', $data);
            $this->load->view('templates/mainheader', $data);
            $this->load->view('frontdesk/patient/view', $data);
            $this->load->view('templates/footer');


        } else {
            redirect('/login');
        }
    }

    public function add()
    {
        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();

            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), ADD_NEW_PATIENT);
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permission to perform action");
                $this->session->set_userdata($array);
                redirect('/pages');
            }
            $data['title'] = "Medstation | Add Patient";

            $this->utilities->setSessionHome("/patient/add");


            //get all user module mappings by role
            $data['marital_stats'] = $this->marital_model->getMaritalStatus();
            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
            $data['religions'] = $this->religion_model->getReligion();
            $data['countries'] = $this->country_model->getCountries();
            $data['patient_types'] = $this->patient_type_model->getType();
            $data['occupations'] = $this->occupation_model->getOccupation();
            $data['counters'] = $this->file_counter_model->getCounters();
            $data['hmo'] = $this->hmo_model->getHmo();
            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;
            $data['freecodes'] = $this->free_code_model->getFreeCode();
            $data['freecodes2'] = $this->free_code_2_model->getFreeCode();
            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			$data['relationships'] = $this->relationship_model->getRelationship();


            //prepare form
            $this->load->helper('form');
            $this->load->library('form_validation');


            /**`patient_number`,
             *
             * `patient_number`, `first_name`, `last_name`, `middle_name`, `dob`, `legacy_file_number`, `occupation_id`,
             * `religion_id`, `marital_status`, `state_of_origin`, `orign_country_code`, `origin_lga_id`, `mobile_number`,
             * `cell_number`, `email`, `alt_email`, `address_line_1`, `address_line_2`, `address_state_code`,
             * `address_lga_id`, `address_country_code`, `patient_type_code`, `date_created`, `date_modified`, `status`, `legacy_date_opened`, `hmo_id`**/


            //form validations here
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('dob', 'Date Of Birth', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required');
            $this->form_validation->set_rules('sex', 'Sex', 'required');
            $this->form_validation->set_rules('marital_status', 'Marital Status', 'required');
            $this->form_validation->set_rules('patient_number', 'File Number', 'required');
            $this->form_validation->set_rules('patient_type_code', 'File Type', 'required');

            if (strtolower($this->input->post("patient_type_code")) == 'h') {
                $this->form_validation->set_rules('hmo_id', 'Provider', 'required');
                $this->form_validation->set_rules('enrolle_id', 'HMO Enrolled Number', 'required');
            }


            //save last posted data
            if ($this->input->post("first_name")) {
                $data["first_name"] = $this->input->post("first_name");
            }

            if ($this->input->post("enrolle_id")) {
                $data["enrolle_id"] = $this->input->post("enrolle_id");
            }

            if ($this->input->post("last_name")) {
                $data["last_name"] = $this->input->post("last_name");
            }
            if ($this->input->post("sex")) {
                $data["sex"] = $this->input->post("sex");
            }
            if ($this->input->post("middle_name")) {
                $data["middle_name"] = $this->input->post("middle_name");
            }
            if ($this->input->post("dob")) {
                $data["dob"] = $this->input->post("dob");
            }
            if ($this->input->post("occupation_id")) {
                $data["occupation_id"] = $this->input->post("occupation_id");
            }
            if ($this->input->post("religion_id")) {
                $data["religion_id"] = $this->input->post("religion_id");
            }
            if ($this->input->post("marital_status")) {
                $data["marital_status"] = $this->input->post("marital_status");
            }
            if ($this->input->post("state_of_origin")) {
                $data["state_of_origin"] = $this->input->post("state_of_origin");
            }
            if ($this->input->post("orign_country_code")) {
                $data["orign_country_code"] = $this->input->post("orign_country_code");
            }
            if ($this->input->post("orign_country_code")) {
                $data["orign_country_code"] = $this->input->post("orign_country_code");
            }
            if ($this->input->post("origin_lga_id")) {
                $data["origin_lga_id"] = $this->input->post("origin_lga_id");
            }
            if ($this->input->post("mobile_number")) {
                $data["mobile_number"] = $this->input->post("mobile_number");
            }
            if ($this->input->post("cell_number")) {
                $data["cell_number"] = $this->input->post("cell_number");
            }
            if ($this->input->post("email")) {
                $data["email"] = $this->input->post("email");
            }
            if ($this->input->post("alt_email")) {
                $data["alt_email"] = $this->input->post("alt_email");
            }
            if ($this->input->post("address_line_1")) {
                $data["address_line_1"] = $this->input->post("address_line_1");
            }
            if ($this->input->post("address_line_2")) {
                $data["address_line_2"] = $this->input->post("address_line_2");
            }
            if ($this->input->post("address_state_code")) {
                $data["address_state_code"] = $this->input->post("address_state_code");
            }
            if ($this->input->post("address_country_code")) {
                $data["address_country_code"] = $this->input->post("address_country_code");
            }
            if ($this->input->post("patient_type_code")) {
                $data["patient_type_code"] = $this->input->post("patient_type_code");
            }
            if ($this->input->post("hmo_id")) {
                $data["hmo_id"] = $this->input->post("hmo_id");
            }
			if ($this->input->post("hmo_id")) {
                $data["pri_enrolle_id"] = $this->input->post("pri_enrolle_id");
            }
			if ($this->input->post("rel_to_primary_enrollee")) {
                $data["rel_to_primary_enrollee"] = $this->input->post("rel_to_primary_enrollee");
            }
            if ($this->input->post("patient_number")) {
                $data["patient_number"] = $this->input->post("patient_number");
            }


            if ($this->form_validation->run() === FALSE) {


                $this->load->view('templates/header', $data);
                $this->load->view('templates/mainheader', $data);
                $this->load->view('frontdesk/patient/create', $data);
                $this->load->view('templates/footer');

            } else {
                $patient = $this->patient_model->getPatientByFullName($this->input->post("first_name"), $this->input->post("last_name"),
                    $this->input->post("middle_name"));

                if (empty($patient)) {
					
					if ($_POST['image']) {
						
						$img = $_POST['image'];
						$folderPath = "patients/profile_pics/";
					  
						$image_parts = explode(";base64,", $img);
						$image_type_aux = explode("image/", $image_parts[0]);
						$image_type = $image_type_aux[1];
					  
						$image_base64 = base64_decode($image_parts[1]);
						//$fileName = uniqid() . '.png';
						
						$fileName = $this->input->post('patient_number') . '.png';

						if ($this->input->post('patient_family_id')) {
							$fileName = $this->input->post('patient_number') . "-" . $this->input->post('patient_family_id') . '.png';
						}
					  
						$file = $folderPath . $fileName;
						file_put_contents($file, $image_base64);
						
						$data["patient_pic"] = $file;
					
					}
					 
					 
					 
					
                    //create the patient in the database
                    $this->patient_model->set_patient();
                    
                    $patient_number = $this->input->post("patient_number");
                    $patient_type = $this->input->post("patient_type_code");
                    $current_counters = $this->file_counter_model->getCounters();
                    //updateStandardCounter updateHmoCounter updateFamilyCounter
                    if (strtolower($patient_type) == "h") {
                        $this->file_counter_model->updateHmoCounter($current_counters['hmo'] + 1);
                    } else if (strtolower($patient_type) == "s") {
                        $this->file_counter_model->updateStandardCounter($current_counters['standard'] + 1);
                    } else if (strtolower($patient_type) == "f") {
                        $this->file_counter_model->updateFamilyCounter($current_counters['family'] + 1);
                    }


                    //$this->load->view('news/success');
                } else {
                    $data['validation-error'] = "User Already exists";
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/mainheader', $data);
                    $this->load->view('frontdesk/patient/create', $data);
                    $this->load->view('templates/footer');
                }
				
				

                $parameters["patient_name"] = $this->input->post("first_name") . " " . $this->input->post("middle_name") . " " . $this->input->post("last_name");
                $parameters["patient_number"] = $patient_number;
                $parameters["url"] = base_url();
                //send email to staff with his credentials
                $this->utilities->sendHtmlEmail(NEW_PATIENT_EMAIL_TEMPLATE,
                    $parameters, "chidumekwueme@gmail.com,ekenej@yahoo.com", "New Patient Creation Alert");

                unset($_POST);


                redirect('/patient/number/' . $patient_number);

            }


        } else {
            redirect('/login');
        }

    }
	
	
	public function changeFIleType()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), EDIT_EXISTING_PATIENT);

            //needs write access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/home');
            }

            if (!$this->input->post('patient_type')) {
                $array = array('notice' => "Invalid Function Call");
                $this->session->set_userdata($array);
                redirect('/home');
            }


            $table_name = "patient_master_table";
            $id = "patient_number";
            $id_value = $this->input->post('patient_number');

            $data["patient_type_code"] = $this->input->post('patient_type');
			//$data["patient_type_code"] = $this->input->post('patient_type');

            $this->general_update_model->update($table_name, $id, $id_value, $data);
            $array = array('notice' => "Patient File Type changed successfully");
            $this->session->set_userdata($array);
            redirect('/patient/number/' . $this->input->post('patient_number'));


        } else {
            redirect('/login');
        }
    }
	
	
	
	public function recordIntake()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), UPDATE_VITALS);

            //needs write access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/home');
            }


            $patient_number = $_POST['patient_number'];

            if (empty($patient_number)) {
                redirect('/frontdesk');
            }

            $this->intake_type_model->set_record_intake();

            if ($this->input->post('patient_family_id')) {
                $array['family_member'] = true;
                $array['patient_family_id'] = $this->input->post('patient_family_id');

            }

			$array = array('notice' => "Inpatient Intake done successfully");
            $this->session->set_userdata($array);

            redirect('/patient/number/' . $patient_number);

        } else {
            redirect('/login');
        }

    }
	
	
	
	public function recordOutput()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), UPDATE_VITALS);

            //needs write access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/home');
            }


            $patient_number = $_POST['patient_number'];

            if (empty($patient_number)) {
                redirect('/frontdesk');
            }

            $this->output_type_model->set_record_intake();

            if ($this->input->post('patient_family_id')) {
                $array['family_member'] = true;
                $array['patient_family_id'] = $this->input->post('patient_family_id');

            }

			$array = array('notice' => "Inpatient Output done successfully");
            $this->session->set_userdata($array);
            redirect('/patient/number/' . $patient_number);

        } else {
            redirect('/login');
        }

    }
	
	
	public function recordPostDelivery()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), UPDATE_VITALS);

            //needs write access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/home');
            }


            $patient_number = $_POST['patient_number'];

            if (empty($patient_number)) {
                redirect('/frontdesk');
            }

            $this->delivery_type_model->set_delivery();

            if ($this->input->post('patient_family_id')) {
                $array['family_member'] = true;
                $array['patient_family_id'] = $this->input->post('patient_family_id');

            }

			$array = array('notice' => "Deliver report recorded successfully");
            $this->session->set_userdata($array);
            redirect('/patient/number/' . $patient_number);

        } else {
            redirect('/login');
        }

    }
	
	
	public function recordPostSurgery()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), UPDATE_VITALS);

            //needs write access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/home');
            }


            $patient_number = $_POST['patient_number'];

            if (empty($patient_number)) {
                redirect('/frontdesk');
            }

            $this->surgery_model->set_surgery();

            if ($this->input->post('patient_family_id')) {
                $array['family_member'] = true;
                $array['patient_family_id'] = $this->input->post('patient_family_id');

            }

			$array = array('notice' => "Surgery report recorded successfully");
            $this->session->set_userdata($array);
            redirect('/patient/number/' . $patient_number);

        } else {
            redirect('/login');
        }

    }
	
	
	
	public function recordAddReferal()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), UPDATE_VITALS);

            //needs write access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/home');
            }


            $patient_number = $_POST['patient_number'];

            if (empty($patient_number)) {
                redirect('/frontdesk');
            }

            if($this->Consultation_model->set_referal()){
				
				$this->omt_model->set_Omt($this->session->userdata('staff_no'),
				  'referal', $history['patient_history_id'], 'Patient Referal');
				
			}

            if ($this->input->post('patient_family_id')) {
                $array['family_member'] = true;
                $array['patient_family_id'] = $this->input->post('patient_family_id');

            }
			
			
			$array = array('notice' => "Referal added successfully");
            $this->session->set_userdata($array);
            redirect('/patient/number/' . $patient_number);

        } else {
            redirect('/login');
        }

    }
	
	
	
	
	
	//updateQueueStatus
    public function queueCheckInVitals()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();

            log_message("debug", "about to check user into queue");

            $queueNumber = $this->getQueueNumber();

            log_message("debug", "queue number generated is ".$queueNumber);


            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), SUB_MODULE_NO);

            //read access
            if (!isset($moduleAccess) || $moduleAccess['access'] != 'W') {
                $status = array("STATUS" => "false", "ERROR" => "You do not have access to this function");
                log_message("debug", "user no access to function");
                echo json_encode($status);


            } else {

                $department = $this->input->post('dept_id');
                $staff_no = $this->input->post('staff_no');
                $patient_number = $this->input->post('patient_number');

                log_message("debug","got the following parameters from the request department : $department , patient number : $patient_number, 
                  staff number : $staff_no");
                /**
                 *
                 * $patient_number  = '2014CWG1';
                 * $department = 2;
                 * $staff_no = 'DOC001';
                 **/

                if ($this->input->post("patient_family_id")) {
                    $isInQueue = $this->daily_schedule_model->checkifFamAlreadyQueued($patient_number, $department, $this->input->post("patient_family_id"), $staff_no);
                } else {
                    $isInQueue = $this->daily_schedule_model->checkifAlreadyQueued($patient_number, $department, $staff_no);
                }

                //$isInQueue = TRUE;

                if(isset($isInQueue)){
                    log_message("debug", "is in queue value is ".json_encode($isInQueue));

                }


                if (isset($isInQueue) && $isInQueue != "") {
                    if ($isInQueue['status'] == "L") {

                        $table_name = "daily_schedule";
                        $id = "schdule_id";
                        $id_value = $isInQueue['schdule_id'];


                        $data = array(
                            'queue_number' => $queueNumber,
                            'status' => 'A'
                        );


                        if ($department) {
                            $data['dept_id'] = $department;
                        }

                        if ($staff_no) {
                            $data['staff_no'] = $staff_no;
                        }

                        if ($patient_number) {
                            $data['patient_number'] = $patient_number;
                        }

                        if ($this->input->post("patient_family_id")) {
                            $data['patient_family_id'] = $this->input->post("patient_family_id");
                        }

                        log_message("debug", "finished building queue update " . json_encode($data));

                        $this->general_update_model->update($table_name, $id, $id_value, $data);

                        $status = array("STATUS" => "true", "ERROR" => "", "NUMBER" => $queueNumber);

                        echo json_encode($status);
                    } else {

                        log_message("debug", "user already in todays queue");

                        $status = array("STATUS" => "false", "ERROR" => "Already In Today's Queue");

                        echo json_encode($status);
                    }

                } else {
                    $this->daily_schedule_model->set_queue($queueNumber);
                    log_message("debug", "finished adding new queue member");

                    $status = array("STATUS" => "true", "ERROR" => "", "NUMBER" => $queueNumber);
                    echo json_encode($status);
                }


            }


        } else {
            $status = array("STATUS" => "false", "ERROR" => "User Not logged in");
            echo json_encode($status);
        }
    }



}