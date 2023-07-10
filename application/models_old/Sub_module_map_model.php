<?php
class Sub_module_map_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
        public function getSubAccess($group_id,$sub_id)
            {
		 $query = $this->db->get_where('sub_module_mapping', array('user_group_id' => $group_id, 'sub_module_id' => $sub_id));
                 return $query->row_array();
            }
	    
	    
	public function getGroupAccess($group_id)
	{
		
            $query = $this->db->get_where('sub_module_mapping', array('user_group_id' => $group_id));
		return $query->result_array();
	}
	
	public function clear_permissions($user_group_id)
	{
		return $this->db->delete('sub_module_mapping', array('user_group_id' => $user_group_id)); 
	}
	
	 public function getUserGroupsWithModuleAccess($module_id)
	    {
			$this->db->select("distinct(user_group_id)");
			
			$this->db->from('sub_module_mapping');
			$this->db->where("module_id = ".$module_id." AND access = 'W'");
			$query=$this->db->get();
			return $query->result_array();
	    }
	    
	    
	
	public function set_permission($user_group_id,$module_id,$sub_module_id,$access)
	{
		
		$data = array(
			      'user_group_id' => $user_group_id,
			      'module_id' => $module_id,
			      'sub_module_id' => $sub_module_id,
			      'access' => $access);
		
		 return $this->db->insert('sub_module_mapping', $data);
	}
	
	public function getSubModules()
	{
		
            $this->db->select('*');
			$this->db->order_by("sub_name","asc");
			$this->db->from('sub_module');
			$query=$this->db->get();
			return $query->result_array();
	}
	
	public function getModules()
	{
		
            $this->db->select('*');
			$this->db->order_by("module_name","asc");
			$this->db->from('module_registry');
			$query=$this->db->get();
			return $query->result_array();
	}
}