<?php
class Drug_presentation_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getDrugPresentation($drug_presentation_id = FALSE)
	    {                
                
		if($drug_presentation_id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("name","asc");
			$this->db->from('drug_presentation_master_');
			$where_clause = "(`status` = 'A')";
			$this->db->where($where_clause);
			
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('drug_presentation_master_', array('drug_presentation_id' => $drug_presentation_id));
                return $query->row_array();
	    }
	    
	    public function getDrugPresentationByName($name)
	    {
		$query = $this->db->get_where('drug_presentation_master_', array('name' => $name));
              
		return $query->row_array();
	    }
	    
	    public function set_drug_presentation($staff_no, $name, $description)
	    {
                $date = new DateTime();
                date_timezone_set($date, timezone_open('Africa/Lagos'));
                $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
                    
                    
		$data = array('name'=> $name,
			      'created_by' => $staff_no,
			      'status' => 'A',
                              'date_created' => $todaysDate,
                              'description' => $description);
		return $this->db->insert('drug_presentation_master_', $data);
	    }
	
	  
	
}