<?php
class Drug_stock_rules_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
       
	    public function getDrugStockRule($drug_id)
            {
                $query = $this->db->get_where('drug_stock_rules', array('drug_id' => $drug_id,  'status'=>'A'));
                return $query->result_array();
            }
	    
	    
	    public function getStockRule($rule_id)
            {
                $query = $this->db->get_where('drug_stock_rules', array('drug_stock_rule_id' => $rule_id,  'status'=>'A'));
                return $query->row_array();
            }
	    
	
	    public function setDrugStockRule($drug_id, $drug_bill_package_id, $multiplied_package_id, $multiplier, $created_by)
            {
                   $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'drug_id' => $drug_id,
			    'drug_bill_package_id' => $drug_bill_package_id,
			    'multiplied_package_id' => $multiplied_package_id,
			    'multiplier' => $multiplier,
			    'created_by' => $created_by,
			    'date_created' => $todaysDate,
			    'status' => 'A'
                    );
		    
		  
                    return $this->db->insert('drug_stock_rules', $data);
            }
	    
	   
            
}