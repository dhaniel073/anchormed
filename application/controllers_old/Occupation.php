<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');


class Occupation extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('occupation_model');
		
		
	}
        
        public function getOccupationsJson()
        {
            $occupations = $this->occupation_model->getOccupation();
            echo json_encode ($occupations) ;
        }
	
	public function addNewOccupation()
	{
		
		$occupation_name =  $_POST['occupation_name'];
                
                 if (empty($occupation_name))
                {
                       $status = array("STATUS"=>"false","ERROR"=>"Enter Occupation Name");
		       echo json_encode ($status) ;
                }
                
                else
                {
                    
                    $occupation = $this->occupation_model->getOccupationByName(strtolower($occupation_name));
                     
                     if(empty($occupation))
                     {
                         $occupation = $this->occupation_model->set_occupation(strtolower($occupation_name));
                         
                          $status = array("STATUS"=>"true","ERROR"=>"Created sucessfully");
                        echo json_encode ($status) ;
                     }
                     else{
                        $status = array("STATUS"=>"false","ERROR"=>"Occupation Already Exists");
                        echo json_encode ($status) ;
                     }
                }
                
               
		
	}
	

	
  
}