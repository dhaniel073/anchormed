<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

define ('MODULE_NO', 6);
define ('TITLE', 'Hospital Admin');
define ('VIEM_ROASTER', 27);
define ('EDIT_ROASTER', 28);
define('INVALID_FUNCTION_CALL', 'Action not permitted');

class Dailyroaster extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('passwordhash', array('iteration_count_log2' => 8, 'portable_hashes' => FALSE ));
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
		$this->load->model('shift_model');
                $this->load->model('user_groups_model');
		 $this->load->model('roaster_model');
		
		
		
		
	}
	
	 private function confirmUrl()
		{
			if($this->session->userdata('base_url') != base_url())
			{
				redirect("/logout");
			}
			
		}
	
	  private function moduleAccessCheckOverload($accessLevel)
		{
		     $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), $accessLevel);
			    
				if(!isset($moduleAccess) || $moduleAccess['access'] != "W")
					{
						return false;
					}
					
					return true;
		}
	
  private function moduleAccessCheck($accessLevel)
		{
			
		     $this->confirmUrl();
		     $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), $accessLevel);
			    
				if(!isset($moduleAccess) || $moduleAccess['access'] != "W")
					{
						$array = array('notice' => ACCESS_ERROR);
						$this->session->set_userdata($array);
					    redirect('/home');
					}
		}
		
public function addShiftMember()
{
	if($this->session->userdata('staff') && $this->session->userdata('shift_id'))
	{
		$this->confirmUrl();
		$staff = $this->session->userdata('staff');
		$shift_id = $this->session->userdata('shift_id');
		$date = $this->session->userdata('add_date');
		
		$this->session->unset_userdata('staff');
		$this->session->unset_userdata('shift_id');
		$this->session->unset_userdata('add_date');
		
		if($this->roaster_model->check_if_already_exist($shift_id, $staff['staff_no'],$date))
		{
			$array = array('notice'=>"Staff already assiggned to shift");
			$this->session->set_userdata($array);
			redirect('/dailyRoaster');
		}
		else
		{
			$this->roaster_model->set_roasterDayMem($shift_id, $staff['staff_no'],$date);
			$array = array('notice'=>"roaster update sucessfull");
			 $this->session->set_userdata($array);
			 redirect('/dailyRoaster');
			
		}
        
	}
	else
	{
		redirect('/dailyRoaster');
	}
	
}
//date format is mm/dd/yyyy
private function compare_dates($date1, $date2)
{
	list($month,$day,$year) = preg_split('/\//',$date1);
	$new_date1 = sprintf('%04d%02d%02d',$year,$month,$day);
	
	list($month,$day,$year) = preg_split('/\//',$date2);
	$new_date2 = sprintf('%04d%02d%02d',$year,$month,$day);
	
	return ($new_date1 >= $new_date2);	
	
	
}
public function addToRoaster()
{
	if($this->session->userdata('logged_in'))
		{
			$this->moduleAccessCheck(EDIT_ROASTER);
		
			
			
		
			if(!$this->input->post('shift_id'))
			{
				$array = array('notice'=>INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/home');
			}
			
			 $date = new DateTime();
			date_timezone_set($date, timezone_open('Africa/Lagos'));
			$todaysDate =  date_format($date, 'm/d/Y') ;
			
			$testdate = new DateTime($this->input->post('add_date'));
			date_format($testdate,'m/d/Y');
			
			$compare =  ($this->compare_dates($todaysDate,date_format($testdate,'m/d/Y')));
			
			if($compare)
			{
				$array = array('notice'=>"Invalid date, can't edit roaster of previous days or current day");
				$this->session->set_userdata($array);
				redirect('/dailyRoaster');
			}
			
		
		
		
			$array = array('shift_id'=>$this->input->post('shift_id'), 'add_date'=>$this->input->post('add_date'));
				$this->session->set_userdata($array);
				redirect('/staff/search');
			
		}	
		else{
			redirect('/login');
		}
}
		
		
	
	public function index()
	{
		
		if($this->session->userdata('logged_in'))
		{
			$this->moduleAccessCheck(VIEM_ROASTER);
			
			$data['can_edit'] = $this->moduleAccessCheckOverload(EDIT_ROASTER);
			
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			$data['shifts'] = $this->shift_model->getShift();
                        
                        $data['usergroups'] =  $this->user_groups_model->getUserGroups();
			$data['departments'] = $this->department_model->getDepartments();
			$data['roaster'] = true;
			
			$data['title'] = "Medstation | Hospital Admin";
			$data['content-description'] = "Hospital Admin Manager";
			
			
			//$data['title']=$this->passwordhash->HashPassword("password");
			$this->load->view('templates/header', $data);
			$this->load->view('templates/mainheader', $data);
			$this->load->view('admin/roaster/home');
			$this->load->view('templates/footer');
		
		}
		
		else
		{
			redirect('/login');
		}
	}

	public function removeFromRoaster()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->moduleAccessCheck(EDIT_ROASTER);
			if($this->input->post('roaster_id'))
			{
				$this->roaster_model->removeFromRoaster($this->input->post('roaster_id'));
				$array['notice'] = "Sucessfully Removed From Roaster";
				$this->session->set_userdata($array['notice']);
				redirect('/dailyRoaster');
			}else{
				
				
				$array['notice'] = INVALID_FUNCTION_CALL;
				$this->session->set_userdata($array['notice']);
				redirect('/dailyRoaster');
			}
		}
		else
		{
			redirect('/login');
		}
	}
	public function getRoasterByDayJson()
	{
		$day = $this->input->post('day');
		
		$data = $this->roaster_model->getRoaster($day);
		
		echo json_encode($data);
	}
     
	

	
  
}