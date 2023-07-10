<?php
class Pharmacy_stock_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
       
       public function getOneStockBatch($drug_id){
	$this->db->limit(1);
	$this->db->order_by("qty_in_stock","DESC");
	$query = $this->db->get_where('pharmacy_stock', array('drug_id' => $drug_id, 'status'=>"A"));
        return $query->row_array();
	
       }
       
       public function getStockByBatchNumber($drug_id, $batch_no){
	
	$query = $this->db->get_where('pharmacy_stock', array('drug_id' => $drug_id,
							      'batch_no' => $batch_no));
	
	return $query->row_array();

	
       }
       
       
       public function getActiveStock($drug_id){
	
	$query = $this->db->get_where('pharmacy_stock', array('drug_id' => $drug_id, 'status'=>"A"));
        return $query->result_array();
       }
          
	    
	    
	    public function getStock($drug_id = FALSE)
	    {                
                
		if($drug_id === FALSE)
		{
		        $this->db->select('*');
			$this->db->from('pharmacy_stock');
			$where_clause = "(`status` = 'A')";
			$this->db->where($where_clause);
			
			$query=$this->db->get();
			return $query->result_array();
		}
				
		
		$query = $this->db->get_where('pharmacy_stock', array('drug_id' => $drug_id));
                return $query->result_array();
	    }
	    
	    
	    
	    public function set_Stock($staff_no,$drug_id, $no_in_stock,$drug_bill_package_id,$batch_no,
				  $manufacture_date,$expiry_date)
	    {
                $date = new DateTime();
                date_timezone_set($date, timezone_open('Africa/Lagos'));
                $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
                    
		$split = preg_split('[-]',$manufacture_date);
                $manufacture_date = $split[2]."-".$split[0]."-".$split[1];
		   
		$split = preg_split('[-]',$expiry_date);
                $expiry_date = $split[2]."-".$split[0]."-".$split[1];
		$status = "A";
		if($no_in_stock < 1){
			
			$status = "I";
		}
		
		$data = array('drug_id'=> $drug_id,
			      'created_by' => $staff_no,
			      'status' => $status,
                              'date_created' => $todaysDate,
			      'drug_bill_package_id' => $drug_bill_package_id,
			      'qty_in_stock' => $no_in_stock,
			      'batch_no' => $batch_no,
			      'manufacture_date' => $manufacture_date,
			      'expiry_date' => $expiry_date);
		
		
		
		return $this->db->insert('pharmacy_stock', $data);
	    }
	
	  
	
}