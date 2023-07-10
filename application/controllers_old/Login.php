<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');


class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('passwordhash', array('iteration_count_log2' => 8, 'portable_hashes' => FALSE ));
		$this->load->model('ult');
		$this->load->model('staff_master_model');
		$this->load->model('profile_pics_model');
		
				
	}

	public function index()
	{
		$data['title'] = "Medstation | Login";
		$data['content-description'] = "Medstation Please Login";



		//echo $this->passwordhash->HashPassword("anchormed@123");


		$this->load->view('templates/header', $data);
                $this->load->view('pages/login');
		$this->load->view('templates/footer_abridged');

		 
	}
	
	public function signin()
	{

		
		$userName =  $_POST['username'];
		$userPassword =  $_POST['password'];

		$data['userlogindata'] = $this->ult->getuserlogin($userName);
		
		 if (empty($data['userlogindata']))
                {
                       $status = array("STATUS"=>"false","ERROR"=>"User does not exist");
		       echo json_encode ($status) ;
                }
		else
		{
			$storedUsername = $data['userlogindata']['username'];
			$storedPassword = $data['userlogindata']['password'];
			
			
			
			
			//check the user pasword
			
			$isPwdCorrect = $this->passwordhash->CheckPassword($userPassword,$storedPassword);
			
			
			$status = array("STATUS"=>"false","ERROR"=>"Incorrect Password");
			if($isPwdCorrect)
			{
				
				$data['user'] = $this->staff_master_model->getStaff($data['userlogindata']['staff_no']);
				$data['userpic']= $this->profile_pics_model->getuserpic($data['userlogindata']['staff_no']);
				
				if(sizeof($data['user']) < 1)
				{
					$status = array("STATUS"=>"false","ERROR"=>"User Not Active");
				}
				
				else
				{
					
				//set the sessioniformation
				$this->session->unset_userdata('patient_need_action');
				$this->session->unset_userdata('current_patient');
				
					//load application settings 
				$address_setting = $this->settings_model->getSettingByKey("HOSPITAL_ADDRESS");
                $showUnitPriceSettings = $this->settings_model->getSettingByKey("SETTING_BILL_SHOW_UNIT_PRICE");
                $allowRefunds = $this->settings_model->getSettingByKey("SETTING_ALLOW_REFUNDS");
                $allowEditableBills = $this->settings_model->getSettingByKey("SETTING_ALLOW_BILL_ITEM_EDIT");
                $showItemTotals = $this->settings_model->getSettingByKey("SETTING_SHOW_ITEM_TOTALS");
                $showItemQuantity = $this->settings_model->getSettingByKey("SETTING_SHOW_ITEM_QUANTITY");



				$newdata = array(
					'staff_no'=>$data['user']['staff_no'],
					'username'  => ucwords($data['user']['first_name']." ".$data['user']['last_name']),
					'dept_id'  => $data['user']['dept_id'],
					'email'     => $data['user']['email'],
					'picture'   => $data['userpic']['picture'],
					'role'   => $data['user']['role_id'],
					'group'   => $data['user']['group_id'],
					'base_url' => base_url(),
					'currency_symbol' => "&#8358;",
					'logged_in' => TRUE,
                    'show_unit_price' => $showUnitPriceSettings,
                    'allow_refunds' => $allowRefunds['value'],
                    'allow_editable_bills'=> $allowEditableBills['value'],
                    'show_item_quantity' =>$showItemQuantity['value'],
                    'show_item_totals' =>$showItemTotals['value']
				 );


				
				if($address_setting){
					$newdata["hospital_address"] = $address_setting['value'];
				}
				
				
					$status = array("STATUS"=>"true","ERROR"=>"Logged in");
					
					$this->session->set_userdata($newdata);
				}
				
			}
			


			echo json_encode ($status) ;
			
		}
		
		
		
	}
	
	
       
	
	public function logout()
	{
		unset($this->session->userdata); 
		$this->session->sess_destroy();
		redirect("/login");
	}

	
  
}