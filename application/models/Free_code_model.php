<?php
class Free_code_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getFreeCode($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("name","asc");
			$this->db->from('free_code');
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('free_code', array('id' => $id));
                return $query->row_array();
	    }
	    
	    public function getFreeCodeByName($name)
	    {
		$query = $this->db->get_where('free_code', array('name' => $name));
		 return $query->row_array();
	    }
	
	    public function set_FreeCode($name)
            {
                    $this->load->helper('url');
            
                
                    $data = array(
                            'name' => $name,
			    'created_by' => $this->session->userdata("staff_no"),
			    'status' => 'A',
			    'date_created' => $this->utilities->getDate()
                     );
            
                    return $this->db->insert('free_code', $data);
            }
            
}