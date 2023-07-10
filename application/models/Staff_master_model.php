<?php

class Staff_master_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function getStaff($staff_no = FALSE)
    {
        if ($staff_no === FALSE) {
            $query = $this->db->get('staff_master');
            $this->db->where("status = 'A'");
            return $query->result_array();
        }


        $query = $this->db->get_where('staff_master', array('staff_no' => $staff_no));
        return $query->row_array();
    }

    public function getDoctors()
    {
        $query = $this->db->get_where('staff_master', array('role_id' => 1 , 'status' => 'A'));
        return $query->result_array();

    }
	


}