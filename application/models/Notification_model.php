<?php
class Notification_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getUnreadNotifications($staff_no)
	    {
                        $this->db->order_by("date_created","desc");
                        $query = $this->db->get_where('notification', array('staff_no' => $staff_no, 'status' => 'A' ));
                        
                        return $query->result_array();
                
	    }
            public function getNotification($id)
            {
                $query = $this->db->get_where('notification', array('id' => $id ));
                return $query->row_array();
            }
            
            public function getUnreadNotificationCount($staff_no)
            {
                $this->db->select("count(`id`) as total", FALSE);
                $query = $this->db->get_where('notification', array('staff_no' => $staff_no, 'status' => 'A' ));
                 return $query->row_array();
            }
            
		
            public function set_notification($staff_no, $notification)
            {
                    $this->load->helper('url');
                    
                   
                    $time = new DateTime();
                    date_timezone_set($time, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($time, 'Y-m-d h:m:i') ;
                    
                    
                    $data = array(
                            'staff_no' => $staff_no,
                            'notification' => $notification,
                            'date_created' => $todaysDate,
			    'status' => 'A'
                    );
		    
		            
                    return $this->db->insert('notification', $data);
            }
	    
}