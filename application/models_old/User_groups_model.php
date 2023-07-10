<?php
class User_groups_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
        public function getUserGroups($group_id = FALSE)
            {
		
		if($group_id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("name","asc");
			$this->db->from('user_group');
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('user_group', array('user_group_id' => $group_id));
                return $query->row_array();
            }
	    
	   
	    public function getUserGroupMembers($user_group_id)
	    {
		$query = $this->db->get_where('staff_master', array('group_id' => $user_group_id));
                return $query->result_array();
	    }
	    public function getUserGroupByName($name)
	    {
		$query = $this->db->get_where('user_group', array('name' => $name));
                return $query->row_array();
	    }
	    
	    
	    public function set_usergroup($name)
	    {
		$array = array('name' => $name,'status' => 'A');
		return $this->db->insert('user_group', $array);
	    }
            
           
            
            
	   
            
}