<?php
class Relationship_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getRelationship($relationship_id = FALSE)
	    {
		if($relationship_id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("relationship_name","asc");
			$this->db->from('relationship');
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('relationship', array('relationship_id' => $relationship_id, 'status' => 'A'));
                return $query->row_array();
	    }
	    
	     public function getRelationshipByName($relationship_name)
		{
			
			
		    
		    $query = $this->db->get_where('relationship', array('relationship_name' => $relationship_name));
		    return $query->row_array();
		}
	    
	    
	    public function set_relationship()
            {
                    $this->load->helper('url');
            
                
                    $data = array(
                            'relationship_name' => strtolower($this->input->post('relationship_name')),
			    'status' => 'A'
                    );
		    
                    return $this->db->insert('relationship', $data);
            }
            
}