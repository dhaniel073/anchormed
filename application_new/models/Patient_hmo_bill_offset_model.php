<?php

/**
 * Created by PhpStorm.
 * User: dusty
 * Date: 10/22/16
 * Time: 4:00 PM
 */
class Patient_hmo_bill_offset_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }


    public function findPatientOffsetByReference($reference){

        $query = $this->db->get_where('patient_hmo_bill_offset',
            array('bill_reference_id' => $reference, 'status' => 'A'));

        return $query->row_array();
    }

    public function createPatientOffset($offsetAmount, $patientNumber , $reference){


        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');


        $createdBy = $this->session->userdata("staff_no");
        if(!isset($createdBy) || $createdBy==""){

            $createdBy = "2005/10/01";
        }

        $data = array('patient_number'=> $patientNumber,
            'created_by' => $createdBy,
            'bill_reference_id' => $reference,
            'date_created' => $todaysDate,
            'amount_paid' => $offsetAmount,
            'status' => "A");


        return $this->db->insert('patient_hmo_bill_offset', $data);
    }


}