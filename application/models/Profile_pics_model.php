<?php
class Profile_pics_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
        public function getuserpic($staff_no)
            {
                    $query = $this->db->get_where('profile_pics', array('staff_no' => $staff_no));
                    return $query->row_array();
            }
            
	    
	    public function set_user_pic($staff_no, $piclocation = FALSE)
	    {
		if($piclocation === FALSE)
		{
			$data = array('staff_no' => $staff_no,
				      'picture' => "default.jpg"
				      );
			
			return $this->db->insert('profile_pics', $data);
		}
		
		$data = array('staff_no' => $staff_no,
				      'picture' => $piclocation
				      );
		
		return $this->db->insert('profile_pics', $data);
	    }
}
