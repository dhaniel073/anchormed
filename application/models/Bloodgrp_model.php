<?php
class Bloodgrp_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getBloodgrp($blood_group_id = FALSE)
	    {
		if($blood_group_id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("blood_group_code","asc");
			$this->db->from('blood_group');
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('blood_group', array('blood_group_id' => $blood_group_id));
                return $query->row_array();
	    }
	    
	     public function getBloodgrpByCode($blood_group_code)
		{
		    
		    $query = $this->db->get_where('blood_group', array('blood_group_code' => $blood_group_code));
		    return $query->row_array();
		}
	    
	    
	    public function set_Bloodgrp()
            {
                    $this->load->helper('url');
            
                
                    $data = array(
                            'blood_group_code' => $this->input->post('blood_group_code'),
			    'status' => 'A'
                    );
            
                    return $this->db->insert('blood_group', $data);
            }
            
}