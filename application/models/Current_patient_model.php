<?php
class Current_patient_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
       
	    
	    
	    public function getCurrentPatientWithDoc($staff_no)
	    {
				
		$query = $this->db->get_where('doctor_current_patient', array('staff_no' => $staff_no));
                return $query->row_array();
	    }
	    
            public function getCurrentActivePatientWithDoc($staff_no)
	    {
				
		$query = $this->db->get_where('doctor_current_patient', array('staff_no' => $staff_no, 'status'=> 'A'));
                return $query->row_array();
	    }       
            
	     
	
		    
	    public function set_CurrentPatientWithDoc($staff_no, $queue_number)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'H:i:s') ;
            
	    
                
                    $data = array(
                            'staff_no' => $staff_no,
			    'queue_number' => $queue_number,
			    'time_entered' => $todaysDate,
			    'status' => 'A'
                    );
            
                    return $this->db->insert('doctor_current_patient', $data);
            }
	    
	   
            
}