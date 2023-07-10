<?php

class Staff_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    /**
     * staff_master
     *
     * (`staff_no`, `first_name`, `last_name`, `middle_name`, `dob`, `role_id`, `religion_id`, `marital_status`, `state_of_origin`,
     * `orign_country_code`, `origin_lga_id`, `mobile_number`, `cell_number`, `email`, `alt_email`, `address_line_1`, `address_line_2`,
     * `address_state_code`, `address_lga_id`, `address_country_code`, `date_created`, `date_modified`, `status`, `group_id`, `dept_id`**/


    public function getStaff($staff_no = FALSE)
    {
        if ($staff_no === FALSE) {
            $this->db->select('*');
            $this->db->order_by("last_name", "asc");
            $this->db->from('staff_master');
            $this->db->where("status = 'A'");
            $query = $this->db->get();
            return $query->result_array();
        }

        $query = $this->db->get_where('staff_master', array('staff_no' => $staff_no));
        return $query->row_array();
    }


    public function getStaffByFullName($first_name, $last_name, $middle_name)
    {
        $query = $this->db->get_where('staff_master', array('first_name' => $first_name, 'last_name' => $last_name, 'middle_name' => $middle_name, 'status' => 'A'));
        return $query->row_array();

    }

    public function getStaffByUserGroup($usergroups)
    {
        $this->db->select('distinct(staff_no)');
        $this->db->from('staff_master');


        $whereClause = '';
        if (!$usergroups) {
            return array();
        }
        $counter = 0;
        foreach ($usergroups as $usergroup) {
            if ($counter == 0) {
                $whereClause = "group_id = $usergroup";
            } else {
                $whereClause = $whereClause . " OR group_id = $usergroup";
            }


            $counter++;
        }

        $whereClause = $whereClause . " AND (status = 'A')";
        $this->db->where($whereClause);
        $query = $this->db->get();


        return $query->result_array();
    }


    public function getStaffByDeptId($deptid)
    {
        $query = $this->db->get_where('staff_master', array('dept_id' => $deptid, 'status' => 'A'));
        return $query->result_array();
    }

    public function getStaffByEmail($email)
    {
        $query = $this->db->get_where('staff_master', array('email' => $email , 'status' => 'A'));
        return $query->result_array();
    }

    public function getStaffLikeNumber($staff_no)
    {

        $this->db->like('staff_no', $staff_no);
        $this->db->where("status = 'A'");
        $query = $this->db->get('staff_master');

        return $query->result_array();
    }

    public function getStaffLikeName($name)
    {

        $test = preg_split('[ ]', $name);

        $where_clause = "(";

        if (sizeof($test) > 1) {
            $i = 0;

            foreach ($test as $t) {
                if ($i > 0) {
                    $where_clause = $where_clause . " OR  ";
                }
                $where_clause = $where_clause . "`first_name` LIKE '%$t%' OR  `last_name` LIKE '%$t%' OR `middle_name` LIKE '%$t%'";

                $i++;
            }

            $where_clause = $where_clause . ")";


        } else $where_clause = "(`first_name` LIKE '%$name%' OR  `last_name` LIKE '%$name%' OR `middle_name` LIKE '%$name%')";


        $where_clause = $where_clause . " AND (`status` = 'A')";

        $this->db->select('*');
        $this->db->order_by("last_name", "asc");
        $this->db->from('staff_master');
        $this->db->where($where_clause);


        $query = $this->db->get();
        return $query->result_array();
    }


    public function set_staff()
    {
        $this->load->helper('url');

        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');


        $dob = $this->input->post('dob');

        $data = preg_split('[-]', $dob);


        $dob = $data[2] . "-" . $data[0] . "-" . $data[1];

        /**`staff_no`, `first_name`, `last_name`, `middle_name`, `dob`, `role_id`, `religion_id`, `marital_status`, `state_of_origin`,
         * `orign_country_code`, `origin_lga_id`, `mobile_number`, `cell_number`, `email`, `alt_email`, `address_line_1`, `address_line_2`,
         * `address_state_code`, `address_lga_id`, `address_country_code`, `date_created`, `date_modified`, `status`, `group_id`, `dept_id`**/

        $data = array(
            'staff_no' => $this->input->post('staff_no'),
            'first_name' => strtolower($this->input->post('first_name')),
            'last_name' => strtolower($this->input->post('last_name')),
            'middle_name' => strtolower($this->input->post('middle_name')),
            'dob' => $dob,
            'marital_status' => $this->input->post('marital_status'),
            'orign_country_code' => $this->input->post('orign_country_code'),
            'mobile_number' => $this->input->post('mobile_number'),
            'cell_number' => $this->input->post('cell_number'),
            'email' => strtolower($this->input->post('email')),
            'alt_email' => strtolower($this->input->post('alt_email')),
            'address_line_1' => strtolower($this->input->post('address_line_1')),
            'address_line_2' => strtolower($this->input->post('address_line_2')),
            'address_country_code' => $this->input->post('address_country_code'),
            'date_created' => $todaysDate,
            'sex' => $this->input->post('sex'),
            'status' => 'A'
        );

        $data['origin_lga_id'] = NULL;
        $data['state_of_origin'] = NULL;
        $data['address_state_code'] = NULL;
        $data['address_lga_id'] = NULL;
        $data['group_id'] = NULL;
        $data['dept_id'] = NULL;
        $data['role_id'] = NULL;
        $data['religion_id'] = NULL;

        if (trim($this->input->post('role_id')) != "") {
            $data['role_id'] = $this->input->post('role_id');
        }
        if (trim($this->input->post('religion_id')) != "") {
            $data['religion_id'] = $this->input->post('religion_id');
        }

        if (trim($this->input->post('dept_id')) != "") {
            $data['dept_id'] = $this->input->post('dept_id');
        }
        if (trim($this->input->post('group_id')) != "") {
            $data['group_id'] = $this->input->post('group_id');
        }
        if (trim($this->input->post('origin_lga_id')) != "") {
            $data['origin_lga_id'] = $this->input->post('origin_lga_id');
        }

        if (trim($this->input->post('state_of_origin')) != "") {
            $data['state_of_origin'] = $this->input->post('state_of_origin');
        }
        if (trim($this->input->post('address_state_code')) != "") {
            $data['address_state_code'] = $this->input->post('address_state_code');
        }
        if (trim($this->input->post('address_lga_id')) != "") {
            $data['address_lga_id'] = $this->input->post('address_lga_id');
        }


        return $this->db->insert('staff_master', $data);
    }

}