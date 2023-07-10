<?php
class Country_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getCountries($country_code = FALSE)
	    {
		if($country_code === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("country_name","asc");
			$this->db->from('country');
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('country', array('country_code' => $country_code));
                return $query->row_array();
	    }
	    
	     public function getCountryByName($country_name)
		{
		    $query = $this->db->get_where('country', array('country_name' => $country_name));
		    return $query->row_array();
		}
		
	    
	    
	    public function set_Country()
            {
                    $this->load->helper('url');
            
                
                    $data = array(
                            'country_name' => strtolower($this->input->post('country_name')),
			    'country_code' => strtolower($this->input->post('country_code')),
			    'status' => 'A'
                    );
            
                    return $this->db->insert('country', $data);
            }
	    
	    public function set_Country_Upload($country_code, $country_name)
            {
                    $this->load->helper('url');
            
                
                    $data = array(
                            'country_name' => strtolower($country_name),
			    'country_code' => strtoupper($country_code),
			    'status' => 'A'
                    );
            
                    return $this->db->insert('country', $data);
            }
            
}