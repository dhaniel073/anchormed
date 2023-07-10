<?php
class Message_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
		
		 public function getUnreadNotificationCount($staff_no)
			{
			    $this->db->select("count(`title`) as total", FALSE);
			    $query = $this->db->get_where('unread_messages_prev', array('to' => $staff_no));
			     return $query->row_array();
			}
	    
	    
	    public function getUnreadMessagesPrev($staff_no)
	    {
			$this->db->select('*');
			$this->db->order_by("date_sent","desc");
			$this->db->limit(15);
			$query=$this->db->get_where('unread_messages_prev', array('to' => $staff_no));
			return $query->result_array();
	    }
	    
	    
	    public function getMessage($id = FALSE, $staff_no)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("date_sent","desc");
			$query=$this->db->get_where('messages', array('to' => $staff_no));
			return $query->result_array();
		}
		
		$query = $this->db->get_where('messages', array('message_id' => $id));
                return $query->row_array();
	    }
	    
	    public function getUnreadMessages($staff_no)
            {
                
		$query = $this->db->get_where('message_table', array('to' => $staff_no, 'status' => 'N'));
                return $query->result_array();
            }
          
	  
	    
	    public function set_Message($message, $title, $to, $from, $ref_id)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
		
                
                    $data = array(
                            'from' => $from,
			    'to' => $to,
			    'title' => $title,
			    'message' => $message,
			    'date_sent' => $todaysDate,
			    'reference_id' => $ref_id,
			    'status' => 'A'
                    );
            
                    return $this->db->insert('message_table', $data);
            }
	    
	   
            
}