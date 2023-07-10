<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');


class Lga extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('lga_model');
		
		
	}
        
        public function getlgasJson()
        {
            $lgas = $this->lga_model->getLga();
            echo json_encode ($lgas) ;
        }
	
        
         public function getLgasByStateJson()
        {
            $state_code =  $_POST['state_code'];
           // $state_code = "LAG";
            
            $lgas = $this->lga_model->getLgaByState($state_code);
            echo json_encode ($lgas) ;
        }
	

	
  
}