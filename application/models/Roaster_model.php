<?php
class Roaster_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
       
	    
	    
	    public function getRoaster($date)
	    {
		
		$where_clause = "(`shift_day` = '$date' AND  `status` = 'A')";
			
			
			$this->db->select('*');
                        $this->db->order_by("shift_day","asc");
			$this->db->from('roaster');
                        $this->db->where($where_clause);
		    
                        $query=$this->db->get();
			return $query->result_array();
                    
	    }
	    public function removeFromRoaster($id)
            {
                return $this->db->delete('shift_assignment_table', array('id' => $id));	  	    
            }
            
            public function check_if_already_exist($shift_id, $staff_no,$day)
            {
                $where_clause = "(`shift_day` = '$day' AND  `shift_id` = '$shift_id' AND  `staff_no` = '$staff_no')";
                $this->db->from('roaster');
                        $this->db->where($where_clause);
		    
                        $query=$this->db->get();
			return $query->result_array();
            }
	   
           public function set_roasterDayMem($shift_id, $staff_no,$day)
           {
                 $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'shift_id' => $shift_id,
			    'staff_no' => $staff_no,
			    'date_created' => $todaysDate,
			    'shift_day' => $day,
			    'status' => 'A'
                    );
            
                    return $this->db->insert('shift_assignment_table', $data);
           }
}