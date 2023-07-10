<?php
class Role_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
        public function getrole($role_id = FALSE)
            {
		if($role_id === FALSE)
		{
			 $this->db->select('*');
			$this->db->order_by("role_name","asc");
			$this->db->from('role');
			$query=$this->db->get();
			return $query->result_array();
		}
                    $query = $this->db->get_where('role', array('role_id' => $role_id));
                    return $query->row_array();
            }
	    
	public function getroles()
            {
                    $query = $this->db->get_where('role', array('status' => 'A'));
                    return $query->result_array();
            }
            
}
