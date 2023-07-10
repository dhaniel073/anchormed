<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');


class Religion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('religion_model');
		
		
	}
        
        public function getReligionsJson()
        {
            $religions = $this->religion_model->getReligion();
            echo json_encode ($religions) ;
        }
	
	public function addNewReligion()
	{
		
		$religion_name =  $_POST['religion_name'];
                
                 if (empty($religion_name))
                {
                       $status = array("STATUS"=>"false","ERROR"=>"Enter Religion Name");
		       echo json_encode ($status) ;
                }
                
                else
                {
                     $religion = $this->religion_model->getReligionByName(strtolower($religion_name));
                     
                     if(empty($religion))
                     {
                         $religion = $this->religion_model->set_religion(strtolower($religion_name));
                         
                          $status = array("STATUS"=>"true","ERROR"=>"Created sucessfully");
                        echo json_encode ($status) ;
                     }
                     else{
                        $status = array("STATUS"=>"false","ERROR"=>"Religion Already Exists");
                        echo json_encode ($status) ;
                     }
                }
                
               
		
	}
	

	
  
}