<?php
class Drug_price_master_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getDrugPriceMaster($drug_price_id = FALSE)
	    {                
                
		if($drug_price_id === FALSE)
		{
		        $this->db->select('*');
			$this->db->from('drug_price_master');
			$where_clause = "(`status` = 'A')";
			$this->db->where($where_clause);
			
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('drug_price_master', array('drug_price_id' => $drug_price_id));
                return $query->row_array();
	    }
	    
	    
	    
	    public function getDrugPriceMasterByDrug($drug_id)
	    {
		$query = $this->db->get_where('drug_price_master', array('drug_id' => $drug_id , 'status' => 'A'));
		return $query->result_array();
	    }
	   
	    public function getDrugPriceByPackage($drug_id, $package_id)
	    {
		$query = $this->db->get_where('drug_price_master', array('drug_id' => $drug_id , 'drug_bill_package_id' => $package_id, 'status' => 'A'));
		return $query->row_array();
	    }
	    public function set_drug_price_master($staff_no,$drug_presentation_id,$drug_bill_package_id,$currency_code,$unit_price,$drug_id,$weight,$weight_unit)
	    {
                $date = new DateTime();
                date_timezone_set($date, timezone_open('Africa/Lagos'));
                $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
                    
                    
		$data = array(
			       'drug_presentation_id' => $drug_presentation_id,
			      'drug_bill_package_id' => $drug_bill_package_id,
			      'currency_code' => $currency_code,
			      'unit_price' => $unit_price,
			      'drug_id' => $drug_id,
			      'created_by' => $staff_no,
			      'status' => 'A',
			      'weight' => $weight,
			      'weight_unit' => $weight_unit,
                              'date_created' => $todaysDate);
		
		
		return $this->db->insert('drug_price_master', $data);
	    }
	
	  
	
}