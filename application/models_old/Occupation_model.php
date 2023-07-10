<?php
class Occupation_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getOccupation($occupation_id = FALSE)
	    {
		if($occupation_id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("occupation_name","asc");
			$this->db->from('occupation_master');
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('occupation_master', array('occupation_id' => $occupation_id, 'status' => 'A'));
                return $query->row_array();
	    }
	    
	     public function getOccupationByName($occupation_name)
		{
			
			
		    
		    $query = $this->db->get_where('occupation_master', array('occupation_name' => $occupation_name));
		    return $query->row_array();
		}
	    
	    
	    public function set_occupation()
            {
                    $this->load->helper('url');
            
                
                    $data = array(
                            'occupation_name' => strtolower($this->input->post('occupation_name')),
			    'status' => 'A'
                    );
		    
                    return $this->db->insert('occupation_master', $data);
            }
            
}