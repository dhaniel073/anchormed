<?php
class Religion_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getReligion($religion_id = FALSE)
	    {
		if($religion_id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("religion_name","asc");
			$this->db->from('religion_master');
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('religion_master', array('religion_id' => $religion_id, 'status' => 'A'));
                return $query->row_array();
	    }
	    
	     public function getReligionByName($religion_name)
		{
		    
		    $query = $this->db->get_where('religion_master', array('religion_name' => $religion_name));
		    return $query->row_array();
		}
	    
	    
	    public function set_religion()
            {
                    $this->load->helper('url');
            
                
                    $data = array(
                            'religion_name' => strtolower($this->input->post('religion_name')),
			    'status' => 'A'
                    );
            
                    return $this->db->insert('religion_master', $data);
            }
            
}