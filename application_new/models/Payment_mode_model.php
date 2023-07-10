<?php
class Payment_mode_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
	 public function getPostedPaymentMode($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("posted_on","desc");
			$this->db->from('patient_payment_mode');
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('patient_payment_mode', array('id' => $id));
                return $query->row_array();
	    }
       
	    public function getPostedPaymentModeByPatient($patient_number)
            {
                $query = $this->db->get_where('patient_payment_mode', array('patient_number' => $patient_number));
                return $query->result_array();
            }
	    
	    public function getPostedPaymentModeByReference($reference_id){
		
		$query = $this->db->get_where('patient_payment_mode', array('reference_id' => $reference_id));
		return $query->result_array();
	    }
	
	    
	   	    
	    
	    public function set_posted_payment_mode($patient_number, $reference_id, $amount_paid, $original_bill_amount, $paymentmode)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'patient_number' => $patient_number,
			    'reference_id' => $reference_id,
			    'amount_paid' => $amount_paid,
			    'original_bill_amount' => $original_bill_amount,
			    'posted_on' => $todaysDate,
			    'posted_by' => $this->session->userdata("staff_no"),
			    'mode' => $paymentmode
                    );		    
		  
                    return $this->db->insert('patient_payment_mode', $data);
            }
	    
	   
            
}