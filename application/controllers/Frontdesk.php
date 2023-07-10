<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

define ('MODULE_NO', 3);
define ('TITLE', 'FrontDesk');
define ('PERFORM_FRONTDESK_OPERATIONS', 37);

class Frontdesk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('passwordhash',
			array('iteration_count_log2' => 8, 'portable_hashes' => FALSE ));
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
		$this->load->model('patient_admission_model');
		
		
		
	}

	private function confirmUrl()
		{
			if($this->session->userdata('base_url') != base_url())
			{
				redirect("/logout");
			}
			
		}
		
	 private function access_check($accessLevel)
		{
			$this->confirmUrl();
			
		     $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), $accessLevel);
		     
		     if($moduleAccess)
		     {
			if(!isset($moduleAccess) || $moduleAccess['access'] != "W")
					{
						return false;
					}
					
					return true;
		     }
		     
		     return false;
			    
				
		}
		
		
	public function index()
	{

		if($this->session->userdata('logged_in'))
		{
		
			$this->confirmUrl();

			$this->utilities->setSessionHome("/frontdesk");
			
			$data['front_desk_operations'] = $this->access_check(PERFORM_FRONTDESK_OPERATIONS);
		
			$data['title'] = "Medstation | Front Desk";
			$data['content-description'] = "Front Desk";
		
			//get all user module mappings by role
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			$data['hmos'] = $this->hmo_model->getHmo();
			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			$data['queue'] = $this->daily_schedule_model->getDailySchedule();
			
			$todays_appointments = $this->appointment_model->getAllTodaysAppointments();
			$data['appointments'] = null;
			
			$counter = 0;
			foreach($todays_appointments as $appointments)
			{
				$data['appointments'][$counter] = $this->patient_model->getPatient($appointments['patient_number']);
				
				//fix for family member
				if(isset($appointments['patient_family_id']) && $appointments['patient_family_id'] !="")
				{
					$family_member = $this->patient_model->getPatientFamMember($appointments['patient_family_id']);
					
					$data['appointments'][$counter]['first_name'] = $family_member['first_name'];
					$data['appointments'][$counter]['last_name'] = $family_member['last_name'];
					$data['appointments'][$counter]['middle_name'] = $family_member['middle_name'];
					$data['appointments'][$counter]['patient_family_id'] = $family_member['patient_family_id'];
					
				}
				$data['appointments'][$counter]['appointment_id'] = $appointments['appointment_id'];
				$data['appointments'][$counter]['reason'] = $appointments['reason'];
				$data['appointments'][$counter]['consulting_doctor'] = $this->staff_master_model->getStaff($appointments['consulting_doctor']);
				$data['appointments'][$counter]['appointment_time'] = $appointments['appointment_time'];
				
				$counter++;
			}
			
			$counter = 0;
			foreach($data['queue'] as $queue)
			{
				
				$data['patients'][$counter] = $this->patient_model->getPatient($queue['patient_number']);
				$data['patients'][$counter]['patient_family_id'] = "";
				
				if(isset($queue['patient_family_id']) && $queue['patient_family_id'] != "")
				{
				 $family_member = $this->patient_model->getPatientFamMember($queue['patient_family_id']);
				
				$data['patients'][$counter]['first_name'] = $family_member['first_name'];
				$data['patients'][$counter]['last_name'] = $family_member['last_name'];
				$data['patients'][$counter]['middle_name'] = $family_member['middle_name'];
				$data['patients'][$counter]['patient_family_id'] = $family_member['patient_family_id'];
				
				}
				
				$data['queue'][$counter]["admission_status"] = "Out Patient";
				if($this->patient_admission_model->getPatientAdmission($queue['patient_number']))
				{
					$data['queue'][$counter]["admission_status"] = "In Patient";
				}
				
				$counter++;
			}
			
			//$data['patients'] = $this->patient_model->getPatient();
			$data['departments'] = $this->department_model->getDepartments();
			$data['doctors'] = $this->staff_master_model->getDoctors();
			
			$data['title'] = "Medstation | FrontDesk";
			$data['content-description'] = "Front Desk Manager";
			//$data['title']=$this->passwordhash->HashPassword("password");
			$this->load->view('templates/header', $data);
			$this->load->view('templates/mainheader', $data);
			$this->load->view('frontdesk/home');
			$this->load->view('templates/footer');
		}
		else
		{
			redirect('/login');
		 
		}
	}
	

	
  
}