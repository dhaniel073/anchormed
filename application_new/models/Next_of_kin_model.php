<?php
class Next_of_kin_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getNextOfKin($patient_number)
	    {
		
		$query = $this->db->get_where('patient_next_of_kin', array('patient_number' => $patient_number));
                return $query->row_array();
	    }
	    
            public function set_nextofkin($data)
            {
                    $this->load->helper('url');
                    
                    return $this->db->insert('patient_next_of_kin', $data);
            }
	  
            
}