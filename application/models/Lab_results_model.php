<?php
class Lab_results_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
       
	    
	    
	    public function getLabResult($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("date_created","desc");
			$this->db->from('lab_test_results');
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('lab_test_results', array('id' => $id));
                return $query->row_array();
	    }
	   
	     
	        public function getResultsByOrderId($orderIds)
		{
			$this->db->from("lab_test_results");
			
			$counter = 0;
			$inClause = "( ";
			foreach($orderIds as $orderid)
			{
				if($counter != 0)
				{
					$inClause = $inClause.",";
				}
				
				$inClause = $inClause.$orderid;
				$counter ++;
			}
			
			$inClause = $inClause." )";
			
			$this->db->where("order_id in $inClause");
			
			$query = $this->db->get();
			return $query->result_array();
		}
		
		
		 public function getResultByOrderId($order_id)
		{
		    $query = $this->db->get_where('lab_test_results', array('order_id' => $order_id));
		    return $query->row_array();
		}
		
	
	 public function getResultByPatient($patient_number)
		{
		$this->db->order_by("date_created","desc");
		    $query = $this->db->get_where('lab_test_results', array('patient_number' => $patient_number));
		    return $query->result_array();
		}
		
		    
	    
	    public function set_Result($patient_number, $result, $order_id, $staff_no)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	                    
                    $data = array(
                            'patient_number' => $patient_number,
			    'created_by' => $staff_no,
			    'result' => $result,
			    'order_id' => $order_id,
			    'date_created' => $todaysDate,
			    'status' => 'P'
                    );
            
                    return $this->db->insert('lab_test_results', $data);
            }
	    
	   
            
}