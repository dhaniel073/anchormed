<?php
class Module_map_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
        public function getrolemodules($role_id)
            {
                    $query = $this->db->get_where('module_role_mapping', array('role_id' => $role_id));
                    return $query->result_array();
            }
            
}
