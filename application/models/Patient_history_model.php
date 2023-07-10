<?php

class Patient_history_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }


    public function getHistory($patient_history_id = FALSE, $patient_number)
    {
        $this->load->helper('url');


        if ($patient_history_id === FALSE) {
            $this->db->select('*');
            $this->db->order_by("date_created", "desc");
            $this->db->from('patient_history');
            $this->db->where("(`patient_number` = '$patient_number')");
            $query = $this->db->get();
            return $query->result_array();
        }

        $query = $this->db->get_where('patient_history', array('patient_history_id' => $patient_history_id, 'status' => 'A'));
        return $query->row_array();
    }
	
	public function getConsultation($patient_history_id = FALSE, $patient_number)
    {
        $this->load->helper('url');

				
		$this->db->select ( '*' ); 
		$this->db->from ( 'consultation_master' );
		$this->db->join ( 'consultation_treatment', 'consultation_treatment.consultation_id = consultation_master.id' , 'left' );
		$this->db->join ( 'consultation_diagnosis', 'consultation_diagnosis.consultation_id = consultation_master.id' , 'left' );
		$this->db->join ( 'consultation_examination', 'consultation_examination.consultation_id = consultation_master.id' , 'left' );
		$this->db->join ( 'consultation_presenting_history', 'consultation_presenting_history.consultation_id = consultation_master.id' , 'left' );
		$this->db->join ( 'consultation_review_systems', 'consultation_review_systems.consultation_id = consultation_master.id' , 'left' );
		$this->db->where ( 'consultation_master.id', $patient_history_id);
		$query = $this->db->get();
		return $query->row_array();


    }
	
	
	
	
    public function getRecentHistory($patient_number)
    {
        $this->load->helper('url');

        $this->db->select('*');
        $this->db->order_by("date_created", "desc");
        $this->db->from('patient_history');
        $this->db->where("(`patient_number` = '$patient_number')");
        // $this->db->limit(4);
        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function getRecentConsultation($patient_number)
    {
        $this->load->helper('url');

        $this->db->select('*');
        $this->db->order_by("date_created", "desc");
        $this->db->from('consultation_master');
        $this->db->where("(`patient_number` = '$patient_number')");
        // $this->db->limit(20);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCurrentHistory($patient_number)
    {
        $this->load->helper('url');


        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $endate = date_format($date, 'Y-m-d H:i:s');

        $startdate = date("Y-m-d H:i:s", strtotime('-24 hours'));


        $this->db->select('*');
        $this->db->order_by("date_created", "desc");
        $this->db->from('patient_history');
        $this->db->where("(`patient_number` = '$patient_number' AND (date_created BETWEEN '$startdate' AND '$endate' ) )");
        // $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();


    }


    public function set_History($patient_number, $staff_no, $description, $doctors_notes)
    {
        $this->load->helper('url');

        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');


        $data = array(
            'patient_number' => $patient_number,
            'consulting_doctor' => $staff_no,
            'description' => $description,
            'doctors_notes' => $doctors_notes,
            'date_created' => $todaysDate,
            'status' => 'A'
        );

        if ($this->input->post('patient_family_id')) {
            $data['patient_family_id'] = $this->input->post('patient_family_id');
        }

        return $this->db->insert('patient_history', $data);

    }


}