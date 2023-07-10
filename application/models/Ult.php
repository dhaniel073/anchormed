<?php
class Ult extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
		public function getAcctStat($username){
			$query = $this->db->get_where('ult', array('username' => $username));
			return $query->row_array();
		}

		public function userState($staff_no){
			$query = $this->db->get_where('ult', array('staff_no' => $staff_no,));
			return $query->row_array();
		}


        public function getuserlogin($username)
            {
                    $query = $this->db->get_where('ult', array('username' => $username, 'status' => "A"));
                    return $query->row_array();
            }
	    
	    public function getuserloginByStaff($staff_no)
	    {
		 $query = $this->db->get_where('ult', array('staff_no' => $staff_no , 'status' => "A"));
                return $query->row_array();
	    }
	    
	    /**
	     *
	     *`id`, `username`, `password`, `status`, `date_created`, `date_modified`, `staff_no`)
	     */
	public function set_user($username,$password,$staff_no)
	{
		
		
            $this->load->helper('url');
	    $date = new DateTime();
            date_timezone_set($date, timezone_open('Africa/Lagos'));
            $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
	    
	    $data = array(
		'username' => $username,
		'password' => $password,
		'staff_no' => $staff_no,
		'status' => 'A',
 		'date_created' => $todaysDate	  
			  );
	    
	    return $this->db->insert('ult', $data);
	}
	
	
}