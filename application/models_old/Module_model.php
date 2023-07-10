<?php
class Module_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
        public function getModule($module_id)
            {
                    $query = $this->db->get_where('module_registry', array('module_id' => $module_id));
                    return $query->row_array();
            }
            
}
