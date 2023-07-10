<?php
class Appointment_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    
	    public function getAppointments($appointment_id = FALSE)
	    {
                
                    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d 00:00:00') ;
                    
                    $where_clause = "(`appointment_time` > '$todaysDate')";
                
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("appointment_time","asc");
			$this->db->from('appointment_manager');
                        $this->db->where($where_clause);
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('appointment_manager', array('appointment_id' => $appointment_id));
                return $query->row_array();
	    }
            
	    public function getTodaysAppointments($count = FALSE, $staff_id)
	    {
		$date = new DateTime();
                date_timezone_set($date, timezone_open('Africa/Lagos'));
                $startDate =  date_format($date, 'Y-m-d 00:00:00') ;
		
		$endDate = date_format($date, 'Y-m-d 23:59:59') ;
		
		 $where_clause = "(`appointment_time` > '$startDate' AND `appointment_time` < '$endDate' AND consulting_doctor = '$staff_id' AND status = 'A')";
		 if($count === FALSE)
		 {
			$this->db->select('*');
			$this->db->order_by("appointment_time","asc");
			$this->db->from('appointment_view');
                        $this->db->where($where_clause);
			$query=$this->db->get();
			return $query->result_array();
		 }
		  $this->db->select('count(appointment_id) as total',FALSE);
		  $this->db->from('appointment_view');
                        $this->db->where($where_clause);
			$query=$this->db->get();
			return $query->row_array();
		
	    }
	    public function getAllTodaysAppointments()
	    {
		$date = new DateTime();
                date_timezone_set($date, timezone_open('Africa/Lagos'));
                $startDate =  date_format($date, 'Y-m-d 00:00:00') ;
		
		$endDate = date_format($date, 'Y-m-d 23:59:59') ;
		
		 $where_clause = "(`appointment_time` > '$startDate' AND `appointment_time` < '$endDate' AND `status` = 'A')";
		 
		 $this->db->select('*');
			$this->db->order_by("appointment_time","asc");
			$this->db->from('appointment_view');
                        $this->db->where($where_clause);
			$query=$this->db->get();
			return $query->result_array();
		
		
	    }
	    
	    
             public function checkifAlreadyHaveAppointment($patient_number,$date, $time, $staff_no)
                {
                    
                   $d = $date;
                    
                    $split = preg_split('[-]',$d);
                    
                    
                    
                    $date = $split[2]."-".$split[0]."-".$split[1];
                    
                    $datetime = $date." ".$time;
                      
                      
                      $where_clause = "(`consulting_doctor` = '$staff_no' AND `appointment_time` = '$datetime'  AND `patient_number` = '$patient_number' AND `patient_family_id` is NULL )";
      
                              $this->db->select('*');
                              $this->db->from('appointment_manager');
                              $this->db->where($where_clause);
                              $query=$this->db->get();
                              
                               $resultarray = $query->result_array();
                              
                               if(sizeof($resultarray) > 0 )
                               {
                                        
                                      return true;
                               }
                               
                               else return false;
                }
            
	     public function checkifFamAlreadyHaveAppointment($patient_number,$date, $time,$patient_family_id, $staff_no)
                {
                    
                   $d = $date;
                    
                    $split = preg_split('[-]',$d);
                    
                    
                    
                    $date = $split[2]."-".$split[0]."-".$split[1];
                    
                    $datetime = $date." ".$time;
                      
                      
                      $where_clause = "(`consulting_doctor` = '$staff_no' AND `appointment_time` = '$datetime'  AND `patient_number` = '$patient_number' AND `patient_family_id` = '$patient_family_id')";
      
                              $this->db->select('*');
                              $this->db->from('appointment_manager');
                              $this->db->where($where_clause);
                              $query=$this->db->get();
                              
                               $resultarray = $query->result_array();
                              
                               if(sizeof($resultarray) > 0 )
                               {
                                        
                                      return true;
                               }
                               
                               else return false;
                }
		
		
            public function set_appointment()
            {
                    $this->load->helper('url');
                    
                   
                    $time = new DateTime();
                    date_timezone_set($time, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($time, 'Y-m-d h:m:i') ;
                    
                    
                
                    $date = $this->input->post('date');
                    
                    $split = preg_split('[-]',$date);
                    
                    
                    
                    $date = $split[2]."-".$split[0]."-".$split[1];
                    $time = $this->input->post('time');
                    
                    $datetime = $date." ".$time;

                    $data = array(
                            'patient_number' => $this->input->post('patient_number'),
                            'appointment_time' => $datetime,
                            'date_created' => $todaysDate,
                            'consulting_doctor' => $this->input->post('staff_no'),
                            'reason' => $this->input->post('reason'),
                            
			    'status' => 'A'
                    );
		    
		if($this->input->post('patient_family_id'))
		{
			$data['patient_family_id'] = $this->input->post('patient_family_id');
		}
            
                    return $this->db->insert('appointment_manager', $data);
            }
	    
}