<?php
class Shift_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
        public function getShift($shift_id = FALSE)
            {
		if($shift_id === FALSE)
		{
		    $query = $this->db->get('shift_master_table');
                    return $query->result_array();
		}
                   
		
		
		    $query = $this->db->get_where('shift_master_table', array('shift_id' => $shift_id, 'status' => 'A'));
                    return $query->row_array();
            }
	    
	     public function deleteShift($shift_id)
		{
			$this->db->delete('shift_master_table', array('shift_id' => $shift_id));
		   
		}
                
         public function set_Shift($shift_name,$shift_start_time, $shift_end_time,$comments,$created_by)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
                
                
                  $data = array(
                            'shift_name' => $shift_name,
			    'shift_start_time' => $shift_start_time,
			    'shift_end_time' => $shift_end_time,
			    'comments' => $comments,
			    'date_created' => $todaysDate,
			    'created_by' => $created_by,
			    'status' => 'A'
                    );
            
                    return $this->db->insert('shift_master_table', $data);
            }
            
}