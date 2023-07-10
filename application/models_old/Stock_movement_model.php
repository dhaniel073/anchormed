<?php
class Stock_movement_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getMovement($stock_move_id = FALSE)
	    {                
                
		if($stock_move_id === FALSE)
		{
		        $this->db->select('*');
			$this->db->from('pharmacy_stock_movement');
			$where_clause = "(`status` = 'A')";
			$this->db->where($where_clause);
			
			$query=$this->db->get();
			return $query->result_array();
		}
				
		
		$query = $this->db->get_where('pharmacy_stock_movement', array('stock_move_id' => $stock_move_id));
                return $query->row_array();
	    }
	    
	    
	    
	    public function set_stock_movement($supplier, $description, $drug_id , $updated_by , $quantity_moved,$quantity_in_stock_after_move)
	    {
                $date = new DateTime();
                date_timezone_set($date, timezone_open('Africa/Lagos'));
                $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
                    
                    
		$data = array('supplier'=> $supplier,
			      'description' => $description,
			      'status' => 'A',
                              'drug_id' => $drug_id,
			      'updated_by' => $updated_by,
			      'quantity_in_stock_after_move' => $quantity_in_stock_after_move,
			      'date_created' => $todaysDate,
			      'quantity_moved' => $quantity_moved);
		
		
		
		return $this->db->insert('pharmacy_stock_movement', $data);
	    }
	
	  
	
}