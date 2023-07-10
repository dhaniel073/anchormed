<?php
class Text_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
        public function getMedstationText($lang)
            {
		
			$this->db->select('*');
			$this->db->order_by("text_key","asc");
                        $this->db->where("lang_code = '$lang'");
			$this->db->from('medstation_text');
			$query=$this->db->get();
			return $query->result_array();
		
                    
            }
	    
	
            
}
