<?php
class File_counter_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getCounters()
	    {
		
		$query = $this->db->get_where('p_number_last_gens', array('id' => 1));
                return $query->row_array();
	    }
	    
            
            public function updateStandardCounter($value)
            {
                $update = array(
                                'standard' => $value
                           );
                $this->db->where('id', 1);
                $this->db->update('p_number_last_gens', $update);
            }
            
             public function updateHmoCounter($value)
                {
                    $update = array(
                                    'hmo' => $value
                               );
                    $this->db->where('id', 1);
                    $this->db->update('p_number_last_gens', $update);
                }
                
                
	   public function updateFamilyCounter($value)
                {
                    $update = array(
                                    'family' => $value
                               );
                    $this->db->where('id', 1);
                    $this->db->update('p_number_last_gens', $update);
                }
	  
            
}