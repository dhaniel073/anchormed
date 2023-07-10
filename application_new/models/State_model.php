<?php
class State_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getState($state_code = FALSE)
	    {
		if($state_code === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("state_name","asc");
			$this->db->from('state');
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('state', array('state_code' => $state_code));
                return $query->row_array();
	    }
	    
	     public function getStateByName($state_name)
		{
		    $query = $this->db->get_where('state', array('state_name' => $state_name));
		    return $query->row_array();
		}
		
		 public function getStateByCountry($country_code)
		{
		    $query = $this->db->get_where('state', array('country_code' => $country_code, 'status' => "A"));
		    return $query->result_array();
		}
	    
	    
	    public function set_State()
            {
                    $this->load->helper('url');
            
                
                    $data = array(
                            'state_name' => strtolower($this->input->post('state_name')),
			    'state_code' => strtolower($this->input->post('state_code')),
			    'country_code' => strtolower($this->input->post('country_code')),
			    'status' => 'A'
                    );
            
                    return $this->db->insert('state', $data);
            }
	    
	    
	    public function set_State_Excel($state_name, $state_code, $country_code)
            {
                    $this->load->helper('url');
            
                
                    $data = array(
                            'state_name' => strtolower($state_name),
			    'state_code' => strtoupper($state_code),
			    'country_code' =>  strtoupper($country_code),
			    'status' => 'A'
                    );
            
                    return $this->db->insert('state', $data);
            }
            
}