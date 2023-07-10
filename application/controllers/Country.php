<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');


class Country extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('country_model');
		
		
	}
	
	 private function confirmUrl()
		{
			if($this->session->userdata('base_url') != base_url())
			{
				redirect("/logout");
			}
			
		}
        
        public function getCountriesJson()
        {
            $countries = $this->country_model->getCountries();
            echo json_encode ($countries) ;
        }
	
	public function addNewCountry()
	{
		$this->confirmUrl();
		
		$country_name =  $_POST['country_name'];
                $country_code =  $_POST['country_code'];
                
                 if (empty($country_name))
                {
                       $status = array("STATUS"=>"false","ERROR"=>"Enter Country Name");
		       echo json_encode ($status) ;
                }
                 
                 else if (empty($country_code))
                {
                       $status = array("STATUS"=>"false","ERROR"=>"Enter Country Code");
		       echo json_encode ($status) ;
                }
                else
                {
                    
                    $country = $this->country_model->getCountries(strtolower($country_code));
                     $country2 = $this->country_model->getCountryByName(strtolower($country_name));
                    
                     
                     if(empty($country) && empty($country2)) 
                     {
                         $occupation = $this->country_model->set_Country();
                         
                          $status = array("STATUS"=>"true","ERROR"=>"Created sucessfully");
                        echo json_encode ($status) ;
                     }
                     else{
                        $status = array("STATUS"=>"false","ERROR"=>"Country Already Exists");
                        echo json_encode ($status) ;
                     }
                }
                
               
		
	}
	

	
  
}