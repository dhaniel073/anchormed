<?php
class Sample_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
       
	    public function getSampleByRef($reference)
            {
                $query = $this->db->get_where('lab_test_samples', array('sample_reference' => $reference,  'status'=>'A' ));
                return $query->row_array();
            }
	    
	      public function getSamplesByPatientNumber($patient_number)
            {
                $query = $this->db->get_where('lab_test_samples', array('patient_number' => $patient_number,  'status'=>'A' ));
                return $query->result_array();
            }
	    
	       public function getSamplesByOrderId($order_id)
            {
                $query = $this->db->get_where('lab_test_samples', array('order_id' => $order_id,  'status'=>'A' ));
                return $query->row_array();
            }
	    
	    
	    
	    
	    public function getSample($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("date_created","desc");
			$this->db->from('lab_test_samples');
                        $this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('lab_test_samples', array('saved_sample_id' => $id, 'status'=>'A'));
                return $query->row_array();
	    }
	    
	  
	    
	    public function removeSample($id)
	    {
                $data = array('status'=>'D');
                	
		$this->db->where('saved_sample_id', $id);
	        return $this->db->update('lab_test_samples', $data);
                               
	    }
	    
	  
	    
	    public function set_Sample($reference, $description, $created_by, $sample_type, $patient_number, $order_id)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'sample_reference' => $reference,
			    'created_by' => $created_by,
                            'sample_description' => $description,
			    'date_created' => $todaysDate,
			    'sample_type' => $sample_type,
			    'patient_number' => $patient_number,
			    'order_id' => $order_id,
			    'status' => 'A'
                    );
		    
		  
                    return $this->db->insert('lab_test_samples', $data);
            }
	    
	   
            
}