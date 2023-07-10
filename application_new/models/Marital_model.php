<?php
class Marital_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
       
	    
	    
	    public function getMaritalStatus($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->from('marital_stats');
			$this->db->order_by("description","asc");
			$this->db->where("Status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('marital_stats', array('id' => $id));
                return $query->row_array();
	    }
	    
	    public function getMaritalStatusByCode($code)
	    {
		$query = $this->db->get_where('marital_stats', array('marital_status' => $code));
                return $query->row_array();
	    }
	    
	    
		
	
	  
	    public function set_MaritalStatus()
            {
                    $this->load->helper('url');
		   
                
                
                    $data = array(
                            'marital_status' => $this->input->post('marital_status'),
			    'description' => $this->input->post('marital_description'),
			    'status' => 'A'
			    
			  
                    );
            
                    return $this->db->insert('marital_stats', $data);
            }
	    
	   
            
}