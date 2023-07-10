<?php
class Department_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getDepartments($dept_id = FALSE)
	    {
                
                
		if($dept_id === FALSE)
		{
			$this->db->select('*');
			$this->db->order_by("name","asc");
			$this->db->from('department_master');
			$where_clause = "(`status` = 'A')";
			$this->db->where($where_clause);
			
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('department_master', array('dept_id' => $dept_id));
                return $query->row_array();
			
	    }
	    
	    public function set_department($staff_no)
	    {
		$data = array('name'=> $this->input->post('department_name'),
			      'created_by' => $staff_no,
			      'status' => 'A');
		return $this->db->insert('department_master', $data);
	    }
	
	  
	
}