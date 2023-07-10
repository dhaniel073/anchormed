<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');


class State extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('state_model');
		
		
	}
        
        public function getStatesJson()
        {
            $states = $this->state_model->getState();
            echo json_encode ($states) ;
        }
	
        
         public function getStatesByCountryJson()
        {
            $country_code =  $_POST['country_code'];
            
            $states = $this->state_model->getStateByCountry($country_code);
            echo json_encode ($states) ;
        }
	

	
  
}