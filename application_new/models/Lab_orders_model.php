<?php
class Lab_orders_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}

	    
	    public function getOrder($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("date_created","desc");
			$this->db->from('laboratory_test_orders');
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('laboratory_test_orders', array('order_id' => $id));
                return $query->row_array();
	    }
	    
	    public function getOrdersWithoutResultByReference($reference)
	    {
		$this->db->select('*');
		$this->db->order_by("date_created","desc");
		
		$where_clause = "(`status` = 'R' AND `reference_id` = '$reference')";
		$this->db->where($where_clause);
		
		$this->db->from('laboratory_test_orders');
		$query=$this->db->get();
		return $query->result_array();	
	    }
	   
	   public function getOrdersWithoutResult($patient_number)
	   {
		$this->db->select('*');
		$this->db->order_by("date_created","desc");
		
		$where_clause = "(`status` = 'R' AND `patient_number` = '$patient_number')";
		$this->db->where($where_clause);
		
		$this->db->from('laboratory_test_orders');
		$query=$this->db->get();
		return $query->result_array();	
	   }
	   
	   public function getPendingResultsForNonPatientNameLike($name)
	   {
		$this->db->select('*');
		$this->db->order_by("date_created","desc");
		$where_clause = "(`name` LIKE '%$name%' AND `lab_operation_needed` = 'R')";
		$this->db->where($where_clause);
		
		$this->db->from('non_customer_orders');
		$query=$this->db->get();
		return $query->result_array();
	   }
	   
	   
	   public function getPendingOrdersForNonPatientNameLike($name)
	   {
		$this->db->select('*');
		$this->db->order_by("date_created","desc");
		$where_clause = "(`name` LIKE '%$name%' AND `lab_operation_needed` = 'Y')";
		$this->db->where($where_clause);
		
		$this->db->from('non_customer_orders');
		$query=$this->db->get();
		return $query->result_array();
	   }
	   
	   public function getPendingOrderByReference($reference)
	   {
		$this->db->select('*');
		$this->db->order_by("date_created","desc");
		
		$where_clause = "(`status` = 'N' AND `reference_id` = '$reference')";
		
		$this->db->where($where_clause);

		$this->db->from('laboratory_test_orders');
		$query=$this->db->get();
		return $query->result_array();
		
	   }
	   
	   public function getLabOrdersThatHaveResultInReferences($references)
	   {
		$this->db->select('*');
		$this->db->order_by("date_created","desc");
		
		$this->db->from('laboratory_test_orders');
		
		$in_clause = "( ";
		$counter = 0;
		foreach($references as $reference){
			
			if($counter > 0)
			{
				$in_clause = $in_clause.",";
			}
			$in_clause = $in_clause."'".$reference['reference_id']."'";
			$counter++;
		}
		
		$in_clause = $in_clause." )";
		
		$this->db->where("reference_id in $in_clause AND status = 'P'");
		
		$query=$this->db->get();
		return $query->result_array();
		
	   }
	    public function getPendingOrdersByPatient($patient_number)
	    {
		
		$this->db->select('*');
		$this->db->order_by("date_created","desc");
		
		$where_clause = "(`status` = 'N' AND `patient_number` = '$patient_number')";
		$this->db->where($where_clause);
		
		$this->db->from('laboratory_test_orders');
		$query=$this->db->get();
		return $query->result_array();
	    }
	    
	     public function getPerfomedOrdersByPatient($patient_number)
	    {
		
		$this->db->select('*');
		$this->db->order_by("date_created","desc");
		
		$where_clause = "(`status` = 'P' AND `patient_number` = '$patient_number')";
		$this->db->where($where_clause);
		
		$this->db->from('laboratory_test_orders');
		$query=$this->db->get();
		return $query->result_array();
	    }
	    
	     public function getPerfomedOrdersByOrderId($patient_number, $order_id)
	    {
		
		$this->db->select('*');
		$this->db->order_by("date_created","desc");
		
		$where_clause = "(`status` = 'P' AND `patient_number` = '$patient_number' AND `order_id` = '$order_id')";
		$this->db->where($where_clause);
		
		$this->db->from('laboratory_test_orders');
		$query=$this->db->get();
		return $query->row_array();
	    }


	public function getOrderByReferenceIdAndPatientId($reference_id, $patient_number){

		$this->db->select('*');
		$this->db->order_by("date_created","desc");

		$where_clause = "(`patient_number` = '$patient_number' AND `reference_id` = '$reference_id')";
		$this->db->where($where_clause);

		$this->db->from('laboratory_test_orders');
		$query=$this->db->get();
		return $query->row_array();

	}
	    
	    
	    
	    
	  
		
		 public function getOrderByStatus($status)
		{
		    $query = $this->db->get_where('laboratory_test_orders', array('status' => $status));
		    return $query->result_array();
		}
		
	
	 public function removeOrder($reference)
	    {
				
		 return $this->db->delete('laboratory_test_orders', array('reference_id' => $reference));
				
			
	    }
	    
	    
	    public function set_Order($patient_number, $patient_family_id, $lab_id, $reference_id, $staff_no)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'patient_number' => $patient_number,
			    'created_by' => $staff_no,
			    'patient_family_id' => $patient_family_id,
			    'lab_id' => $lab_id,
			    'reference_id' => $reference_id,
			    'date_created' => $todaysDate,
			    'status' => 'N'
                    );
            
                    return $this->db->insert('laboratory_test_orders', $data);
            }
	    
	   
            
}