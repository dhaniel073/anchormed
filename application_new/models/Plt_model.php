<?php

/**
 * Created by PhpStorm.
 * User: dusty
 * Date: 9/15/16
 * Time: 1:52 PM
 */
class Plt_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
    }

    public function findPltByPatientNumber($patient_number){

        $query =
            $this->db->get_where('plt',
                array('patient_number' => $patient_number));

        return $query->row_array();
    }

    public function clearVerificationCode($patient_number){

        $data = array("verification_code"=>"");
        $this->db->where("patient_number", $patient_number);
        return $this->db->update("plt", $data);
    }


    public function updateUserStatus($patient_number, $status){

        $data = array("status"=>$status);
        $this->db->where("patient_number", $patient_number);
        return $this->db->update("plt", $data);
    }

    public function updatePassword($patient_number, $hashedPassword){

        $data = array("password"=>$hashedPassword);
        $this->db->where("patient_number", $patient_number);
        return $this->db->update("plt", $data);
    }

    public function updateVeriCode($patient_number, $hashedVerificationCode){

        $data = array("verification_code"=>$hashedVerificationCode);
        $this->db->where("patient_number", $patient_number);
        return $this->db->update("plt", $data);
    }

    
    public function create_new($patient_number, $hashedVerificationCode ){

        $this->load->helper('url');

        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');

        $data = array(
            "patient_number"=>$patient_number,
            "verification_code"=> $hashedVerificationCode,
            "status" => "U",
            "date_created" => $todaysDate,
            "is_user_locked" => "N",
            "login_failure_count" => 0);

        return $this->db->insert('plt', $data);
    }
}