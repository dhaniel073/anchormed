<?php
class Hmo_Transactions_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
        
	public function getHmoTransactionByHmo($hmo_code)
	{
		 $this->db->select("*");
		 $this->db->where("hmo_code = '$hmo_code'");
		 $this->db->from('hmo_transactions');
		 $query=$this->db->get();
		 return $query->result_array();
	}
        
	
	public function getHmoTransactionByRef($reference_id)
	{
		$query = $this->db->get_where('hmo_transactions', array('payment_ref' => $reference_id));
                return $query->result_array();
	}
	
      public function getHmoTransactions($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("date_created","desc");
			$this->db->from('hmo_transactions');
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('hmo_transactions', array('id' => $id));
                return $query->row_array();
	    }
            
     

       public function setHmoTransaction($hmo_code, $reference_id, $transaction_amount, $staff_no, $description)
            {
                    $this->load->helper('url');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
                
                    $data = array(
                            'hmo_code' => $hmo_code,
			    'payment_ref' => $reference_id,
			    'transaction_amount' => $transaction_amount,
			    'created_by' => $staff_no,
			    'date_created' => $todaysDate,
			    'description' => $description,
			    'status' => 'A'
                    );
            
                    return $this->db->insert('hmo_transactions', $data);
            }
     
}
    