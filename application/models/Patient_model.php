<?php

class Patient_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }


    public function getPatient($patient_number = FALSE)
    {
        if ($patient_number === FALSE) {
            $this->db->select('*');
            $this->db->order_by("last_name", "asc");
            $this->db->from('patient_master_table');
            $this->db->where("status = 'A'");
            $query = $this->db->get();

            return $query->result_array();
        }

        $query = $this->db->get_where('patient_master_table', array('patient_number' => $patient_number, 'status' => 'A'));

        return $query->row_array();
    }

    public function getPatientByOldNumber($card_number)
    {
        $query = $this->db->get_where('patient_master_table', array('legacy_file_number' => $card_number, 'status' => 'A'));
        return $query->row_array();
    }

    public function getPatientByEnroleeId($enrolee_id, $hmo_code)
    {
        $query = $this->db->get_where('patient_master_table', array('hmo_enrolee_id' => $enrolee_id, 'hmo_code' => $hmo_code, 'status' => 'A'));
        return $query->row_array();
    }
	
	public function getPatientByPriEnroleeId($enrolee_id, $hmo_code)
    {
        $query = $this->db->get_where('patient_master_table', array('primary_enrollee_id' => $enrolee_id, 'hmo_code' => $hmo_code, 'status' => 'A'));
        return $query->result_array();
    }

    public function getPatientByFullName($first_name, $last_name, $middle_name)
    {
        $query = $this->db->get_where('patient_master_table', array('first_name' => $first_name, 'last_name' => $last_name, 'middle_name' => $middle_name));
        return $query->row_array();

    }

    public function getPatientByHmo($code = FALSE)
    {
        if ($code === FALSE) {
            $query = $this->db->get_where('patient_master_table', array('patient_type_code' => 'H'));
            return $query->result_array();

        }
        $query = $this->db->get_where('patient_master_table', array('hmo_code' => $code));
        return $query->result_array();

    }

	public function getHmoDetails($hmo_code)
			{
				$query = $this->db->get_where('hmo', array('hmo_code' => $hmo_code));
				return $query->row_array();

			}
			
    public function getPatientFamily($family_number)
    {
        $query = $this->db->get_where('patient_family_table', array('patient_family_number' => $family_number, 'status' => 'A'));
        return $query->result_array();
    }

    public function getPatientFamMember($member_id)
    {
        $query = $this->db->get_where('patient_family_table', array('patient_family_id' => $member_id, 'status' => 'A'));
        return $query->row_array();
    }

    public function getPatientByFamily()
    {
        $query = $this->db->get_where('patient_master_table', array('patient_type_code' => 'F'));
        return $query->result_array();
    }

    public function getPatientLikeNumber($patient_number)
    {
        //check if the patient exist first if the number matches a patient return that patient
        $query = $this->db->get_where('patient_master_table', array('patient_number' => $patient_number, 'status' => 'A'));
        $result_array = $query->result_array();
        if ($result_array && sizeof($result_array) > 0) {
            return $result_array;
        } else {
            $where_clause = "(`status` = 'A' AND  (`patient_number` LIKE '%$patient_number%' OR  `legacy_file_number` LIKE '%$patient_number%'  OR `hmo_enrolee_id` LIKE '%$patient_number%'))";

            $this->db->from('patient_master_table');
            $this->db->where($where_clause);


            $query = $this->db->get();

            return $query->result_array();
        }


    }

    /**
     * find patient by name
     * @param $name
     * @return mixed
     */
    public function getPatientLikeName($name)
    {

        $query = $this->db->get_where('patient_master_table', array('patient_number' => $name, 'status' => 'A'));
        $result_array = $query->result_array();
        if ($result_array && sizeof($result_array) > 0) {
            return $result_array;
        } else {

            $test = preg_split('[ ]', $name);

            $where_clause = "(";

            if (sizeof($test) > 1) {
                $i = 0;

                foreach ($test as $t) {
                    if ($i > 0) {
                        $where_clause = $where_clause . " OR  ";
                    }
                    $where_clause = $where_clause . "`first_name` LIKE '%$t%' OR  `last_name` LIKE '%$t%' OR `middle_name` LIKE '%$t%' OR `patient_number` LIKE '%$t%' ";

                    $i++;
                }

                $where_clause = $where_clause . " )";


            } else $where_clause = "(`first_name` LIKE '%$name%' OR  `last_name` LIKE '%$name%' OR `middle_name` LIKE '%$name%' OR `patient_number` LIKE '%$name%')";


            $where_clause = "(`status` = 'A' AND $where_clause)";


            $this->db->select('*');
            $this->db->order_by("last_name", "asc");
            $this->db->from('patient_master_table');
            $this->db->where($where_clause);


            $query = $this->db->get();
            return $query->result_array();
        }
    }

    public function set_patient_excel($data)
    {
        $this->load->helper('url');
        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');
        $data['date_created'] = $todaysDate;
        $data['created_by'] = $this->session->userdata("staff_no");
        return $this->db->insert('patient_master_table', $data);


    }

    public function set_patient_fam()
    {
        $this->load->helper('url');

        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');

        $dob = $this->input->post('fam_dob');

        $data = preg_split('[-]', $dob);

        $dob = $data[2] . "-" . $data[0] . "-" . $data[1];


        $data = array(
            'patient_family_number' => $this->input->post('patient_number'),
            'first_name' => strtolower($this->input->post('fam_first_name')),
            'last_name' => strtolower($this->input->post('fam_last_name')),
            'middle_name' => strtolower($this->input->post('fam_middle_name')),
            'dob' => $dob,
            'relationship_id' => $this->input->post('fam_relationship_id'),
            'mobile_number' => $this->input->post('mobile_number'),
            'cell_number' => $this->input->post('cell_number'),
            'email' => strtolower($this->input->post('email')),
            'alt_email' => strtolower($this->input->post('alt_email')),
            'patient_type_code' => "F",
            'date_created' => $todaysDate,
            'sex' => $this->input->post('sex'),
            'status' => 'A'
        );

        return $this->db->insert('patient_family_table', $data);
    }

    public function set_patient()
    {
        $this->load->helper('url');

        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');


        $dob = $this->input->post('dob');

        $data = preg_split('[-]', $dob);


        $dob = $data[2] . "-" . $data[0] . "-" . $data[1];
        $hmo_code = $this->input->post('hmo_id');

        if (strtolower($this->input->post('patient_type_code')) != "h") {
            $hmo_code = null;
        }


        $data = array(
            'patient_number' => $this->input->post('patient_number'),
            'first_name' => strtolower($this->input->post('first_name')),
            'last_name' => strtolower($this->input->post('last_name')),
            'middle_name' => strtolower($this->input->post('middle_name')),
            'dob' => $dob,
            'legacy_file_number' => strtolower($this->input->post('legacy_file_number')),
            'occupation_id' => $this->input->post('occupation_id'),
            'religion_id' => $this->input->post('religion_id'),
            'marital_status' => $this->input->post('marital_status'),
            'orign_country_code' => $this->input->post('orign_country_code'),
            'mobile_number' => $this->input->post('mobile_number'),
            'cell_number' => $this->input->post('cell_number'),
            'email' => strtolower($this->input->post('email')),
            'alt_email' => strtolower($this->input->post('alt_email')),
            'address_line_1' => strtolower($this->input->post('address_line_1')),
            'address_line_2' => strtolower($this->input->post('address_line_2')),
            'address_country_code' => $this->input->post('address_country_code'),
            'patient_type_code' => $this->input->post('patient_type_code'),
            'date_created' => $todaysDate,
            'created_by' => $this->session->userdata("staff_no"),
            'legacy_date_opened' => $this->input->post('legacy_date_opened'),
            'sex' => $this->input->post('sex'),
            'hmo_code' => $hmo_code,
            'status' => 'A'
        );

        $data['origin_lga_id'] = NULL;
        $data['state_of_origin'] = NULL;
        $data['address_state_code'] = NULL;
        $data['address_lga_id'] = NULL;
        $data['hmo_enrolee_id'] = NULL;
		$data['primary_enrollee_id'] = NULL;
		$data['rel_to_primary_enrolle'] = NULL;


        if (trim($this->input->post('enrolle_id')) != "") {

            $data['hmo_enrolee_id'] = $this->input->post('enrolle_id');
        }
		
		if (trim($this->input->post('pri_enrolle_id')) != "") {

            $data['primary_enrollee_id'] = $this->input->post('pri_enrolle_id');
        }
		
		if (trim($this->input->post('rel_to_primary_enrollee')) != "") {

            $data['rel_to_primary_enrolle'] = $this->input->post('rel_to_primary_enrollee');
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
        if (trim($this->input->post('free_code_1')) != "") {
            $data['free_code_1'] = $this->input->post('free_code_1');
        }

        if (trim($this->input->post('free_code_2')) != "") {
            $data['free_code_2'] = $this->input->post('free_code_2');
        }
		
		//if ($file) != "") {
            $data['patient_pic'] = 'patients/profile_pics/'.$this->input->post('patient_number').'.png';
        //}


        return $this->db->insert('patient_master_table', $data);
    }
	
	
	public function checkIfLocked($patient_number)
    {

		$query = $this->db->select('file_lock')->from('patient_master_table')->where('patient_number', $patient_number)->get();
		return $query->row()->file_lock;
		
		
    }
	
	
	public function getAdmissionDetails($patient_number)
    {
        $query = $this->db->get_where('patient_admissions', array('patient_number' => $patient_number));
		$this->db->order_by("date_created", "desc");
        return $query->result_array();
    }
	
	public function getNurseActions($patient_number)
    {
        $query = $this->db->get_where('in_patient_tasks', array('patient_number' => $patient_number));
		$this->db->order_by("date_created", "desc");
        return $query->result_array();
    }
	
	
	
	

}