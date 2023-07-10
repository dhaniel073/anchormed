<?php
class Patient_type_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getType($code = FALSE)
	    {
		if($code === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("patient_type_name","asc");
			$this->db->from('patient_type_master');
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('patient_type_master', array('patient_type_code' => $code, 'status' => 'A'));
                return $query->row_array();
	    }
	    
	  
            
}