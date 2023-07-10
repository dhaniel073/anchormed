<?php
class Drug_bill_form_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getDrugBillForms($drug_bill_form_id = FALSE)
	    {                
                
		if($drug_bill_form_id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("name","asc");
			$this->db->from('drug_bill_package_type');
			$where_clause = "(`status` = 'A')";
			$this->db->where($where_clause);
			
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('drug_bill_package_type', array('drug_bill_package_id' => $drug_bill_form_id));
                return $query->row_array();
	    }
	    
	    
        public function getDrugBillByName($name)
	    {
		$query = $this->db->get_where('drug_bill_package_type', array('name' => $name));
              
		return $query->row_array();
	    }
	    
	    
	    public function set_drug_bill_form($staff_no, $name)
	    {
                $date = new DateTime();
                date_timezone_set($date, timezone_open('Africa/Lagos'));
                $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
                    
                    
		$data = array('name'=> $name,
			      'created_by' => $staff_no,
			      'status' => 'A',
                              'date_created' => $todaysDate);
		return $this->db->insert('drug_bill_package_type', $data);
	    }
	
	  
	
}