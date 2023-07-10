<?php
class Daily_schedule_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getDailySchedule($id = FALSE)
	    {
                
                    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d') ;
                    
                    $where_clause = "((`date` = '$todaysDate' AND `status` = 'A') OR `status` = 'A')";
                
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("date","asc");
			$this->db->from('daily_schedule');
                        $this->db->where($where_clause);
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('daily_schedule', array('schdule_id' => $id));
                return $query->row_array();
	    }
	    
	    public function getDailyScheduleReadyForDoc()
	    {
		 $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d') ;
		    
		     $where_clause = "((`date` = '$todaysDate' AND `status` = 'E') OR `status` = 'E' )";
		     
			$this->db->order_by("date","asc");
                       $query = $this->db->get_where('daily_schedule', array('status' => 'E'));
			return $query->result_array();
	    }
	    
	    
	 public function get_number_dept($dept_id)
	    {
		$this->db->select("count(`schdule_id`) as total", FALSE);
		$query = $this->db->get_where('daily_schedule', array('dept_id' => $dept_id, 'status' => 'E'));
		
		return $query->row_array();
		
	    }
	     
	     /**
	     public function getPatientScheduleDetails()
	     {
		$query = $this->db->get_where('daily_schedule', array('staff_no' => $staff_no, 'patient_number' => $patient_number, 'status'));
		
		return $query->row_array();
	     }
	     **/
	     
	public function get_number_doc($staff_no)
	    {
		$this->db->select("count(`schdule_id`) as total", FALSE);
		$query = $this->db->get_where('daily_schedule', array('staff_no' => $staff_no, 'status' => 'E'));
		
		return $query->row_array();
		
	    }
	    
	    
	  public function obtainQueueNumber()
          {
                $date = new DateTime();
                date_timezone_set($date, timezone_open('Africa/Lagos'));
                $todaysDate =  date_format($date, 'Y-m-d') ;
                
                $where_clause = "(`date` = '$todaysDate')";
                
                $this->db->select('*');
			$this->db->order_by("queue_number","desc");
			$this->db->from('daily_schedule');
                        $this->db->where($where_clause);
			$this->db->limit(1);
			$query=$this->db->get();
                        
                         $resultarray = $query->row_array();
                         
			 if($resultarray)
			 {
				return $resultarray['queue_number'] + 1;
			 }
			 
			 return 1;
                         
          }
	  
	  public function checkifAlreadyQueued($patient_number, $dept_id, $staff_no)
	  {
		$date = new DateTime();
                date_timezone_set($date, timezone_open('Africa/Lagos'));
                $todaysDate =  date_format($date, 'Y-m-d') ;
		
		
		$where_clause = "(`date` = '$todaysDate' AND `dept_id` = $dept_id  AND `patient_number` = '$patient_number' AND `patient_family_id` is  NULL)";

		 if(isset($staff_no) && $staff_no != "")
			{
			$where_clause = "(`date` = '$todaysDate' AND `staff_no` = '$staff_no' AND `dept_id` = $dept_id  AND `patient_number` = '$patient_number' AND `patient_family_id` is  NULL)";
			    
			}
		
	 
			$this->db->select('*');
			$this->db->from('daily_schedule');
                        $this->db->where($where_clause);
			$this->db->limit(1);
			$query=$this->db->get();
                        
                         $resultarray = $query->row_array();
			
			return $resultarray;
			
	  }
	  
	  
	  public function checkifFamAlreadyQueued($patient_number, $dept_id, $patient_family_id, $staff_no)
	  {
		$date = new DateTime();
                date_timezone_set($date, timezone_open('Africa/Lagos'));
                $todaysDate =  date_format($date, 'Y-m-d') ;
		
		
		$where_clause = "(`date` = '$todaysDate' AND `dept_id` = $dept_id  AND `patient_number` = '$patient_number' AND `patient_family_id` = '$patient_family_id')";

		 if(isset($staff_no) && $staff_no != "")
			{
			$where_clause = "(`date` = '$todaysDate' AND `staff_no` = '$staff_no' AND `dept_id` = $dept_id  AND `patient_number` = '$patient_number' AND `patient_family_id` = '$patient_family_id')";
			    
			}
		
	 
			$this->db->select('*');
			$this->db->from('daily_schedule');
                        $this->db->where($where_clause);
			$query=$this->db->get();
			$this->db->limit(1);
                        
                         $resultarray = $query->row_array();
			
			 return $resultarray;
	  }
	  
	  
	  
	  public function update_queue($id)
	  {
		$this->load->helper('url');
		
		    
		    
		    $data = array(
					'status' => 'E'
				     );

			$this->db->where('schdule_id', $id);
			$this->db->update('daily_schedule', $data); 
		
	  }
	  
	  public function set_queue_proper($number, $dept, $staff_no, $patient_number, $patient_family_id)
	  {
		$date = new DateTime();
                date_timezone_set($date, timezone_open('Africa/Lagos'));
                $todaysDate =  date_format($date, 'Y-m-d') ;
		
		 $data = array(
                            'date' => $todaysDate,
                            'patient_number' => $patient_number,
                            'queue_number' => $number,
			    'dept_id' => $dept,
			    'staff_no' => $staff_no,
			    'status' => 'A'
                    );
		 
		if($patient_family_id)
		    {
			$data['patient_family_id'] = $patient_family_id;
				
		    }
            
                    return $this->db->insert('daily_schedule', $data);
	  }
	  
	  public function set_queue($number, $dept = FALSE)
	  {
		$this->load->helper('url');
                    
                    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d') ;
            /**
	     *
	     *`daily_schedule`(`schdule_id`, `date`, `patient_number`,
	     *`queue_number`, `status`, `dept_id`) 
	     *staff_no
	     */
                    $data = array(
                            'date' => $todaysDate,
                            'patient_number' => $this->input->post('patient_number'),
                            'queue_number' => $number,
			    'status' => 'A'
                    );
		    
		    
	    
	    $department = $this->input->post('dept_id');
	    $staff_no  = $this->input->post('staff_no');
	    
	    
	    
	    if($dept === FALSE)
	    {
		if(isset($department) && $department != "" && $department != 0)
		{
		    $data['dept_id'] = $department;
		}
		
	    }
	    
	    else
	    {
		$data['dept_id'] = $dept;
	    }
	    
	    
	    if(isset($staff_no) && $staff_no != "")
	    {
		$data['staff_no'] = $staff_no;
	    }
            
	    if($this->input->post('patient_family_id'))
	    {
		$data['patient_family_id'] = $this->input->post('patient_family_id');
			
	    }
            
                    return $this->db->insert('daily_schedule', $data);
		
	  }
}