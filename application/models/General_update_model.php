<?php
class General_update_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	    
	    public function update($table_name,$id,$id_value, $data)
	    {
		
		$this->db->where($id, $id_value);
                $this->db->update($table_name, $data);
         
	    }
	    
          
	  
            
}