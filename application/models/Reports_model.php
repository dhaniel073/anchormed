<?php
class Reports_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
       
	    
	    
	    public function getReports($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->from('report_master');
			$this->db->order_by("report_name","asc");
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('report_master', array('report_id' => $id));
                return $query->row_array();
	    }
	    
	    public function getReportsByName($name)
	    {
		$query = $this->db->get_where('report_master', array('report_name' => $name));
                return $query->row_array();
	    }
	    
	    
		
	
	  
	   
            
}