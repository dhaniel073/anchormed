<?php
class Non_customer_order_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
     
	public function getNonCustomerOrderByReference($reference)
	{
	
	 	$query = $this->db->get_where('non_customer_orders', array('reference_id' => $reference));
                return $query->row_array();
	    }
	
	public function getNonCustomerPaidDispenseOrdersLikeName($name)
	{
	        $this->db->from("non_customer_orders");
		$this->db->where("name LIKE '%$name%' AND status = 'P' AND dispense_needed = 'Y'");
		$query = $this->db->get();
			
			return $query->result_array();
	}
	
	public function getNonCustomerUnPaidDispenseOrdersLikeName($name)
	{
	        $this->db->from("non_customer_orders");
		$this->db->where("name LIKE '%$name%' AND status = 'N' AND dispense_needed = 'Y'");
		$query = $this->db->get();
			
			return $query->result_array();
	}

    public function removeOrderByRefrence($reference){

      return $this->db->delete('non_customer_orders', array('reference_id' => $reference));
    }
	
		public function getNonCustomerOrdersLikeName($name)
		{
			$this->db->select("distinct(reference_id)");
			$this->db->from("non_customer_orders");
			$this->db->where("name LIKE '%$name%'");
			$query = $this->db->get();
			
			return $query->result_array();
		}
	    public function createNonCustomerOrder($name, $type, $reference_id, $dispense_needed, $lab_operation_needed)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'name' => $name,
			    'type' => $type,
			    'reference_id' => $reference_id,
			    'date_created' => $todaysDate,
			    'created_by' => $this->session->userdata("staff_no"),
			    'status' => 'N',
			    'dispense_needed' => $dispense_needed,
			    'lab_operation_needed' => $lab_operation_needed
			    
                    );
		    
		  
                    return $this->db->insert('non_customer_orders', $data);
            }
	    
	  // public deleteNonCustomerOrder
            
}