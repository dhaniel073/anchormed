<?php
/**
 * Created by PhpStorm.
 * User: dusty
 * Date: 4/11/16
 * Time: 5:42 PM
 */


class Patient_deposit_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();

    }

    public function getPatientDeposit($patient_deposit_id = FALSE)
    {
        $this->load->helper('url');


        if ($patient_deposit_id === FALSE) {
            $this->db->select('*');
            $this->db->order_by("date_created", "desc");
            $this->db->from('patient_deposit');
            $query = $this->db->get();
            return $query->result_array();
        }

        $query = $this->db->get_where('patient_deposit', array('patient_deposit_id' => $patient_deposit_id, 'status' => 'A'));
        return $query->row_array();
    }


    public function getLatestDepositByPatientNumber($patient_number){

        $this->db->select('*');
        $this->db->limit(1);
        $query = $this->db->get_where('patient_deposit', array('patient_number' => $patient_number, 'status' => 'A'));

        return $query->row_array();
    }

    public function createPatientDepositRecord($patient_number, $deposit_amount, $reference_id){

        $this->load->helper('url');
        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');


        $data = array(
            'patient_number' => $patient_number,
            'deposit_amount' => $deposit_amount,
            'bill_reference_id' => $reference_id,
            'date_created' => $todaysDate,
            'status' => 'A'
        );

        return $this->db->insert('patient_deposit', $data);


    }


    public function updatePatientDepositRecord($deposit_id, $movement_type, $amount_moved, $bill_reference_id){

        $this->load->helper('url');
        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');

        $data = array(
            'patient_deposit_id' => $deposit_id,
            'amount_paid' => $amount_moved,
            'bill_reference_id' => $bill_reference_id,
            'date_created' => $todaysDate,
            'movement_type' => $movement_type,
            'status' => 'A'
        );

        $this->db->insert('patient_deposit_movement', $data);

        //update the patient record accordingly
        $status = 'A';
        //get the current patient deposit
        $patient_deposit = $this->getPatientDeposit($deposit_id);

        if($patient_deposit){

            $newAmount = 0;
            if($movement_type == 'D'){
                $newAmount = $patient_deposit['deposit_amount'] - $amount_moved;
            }else if($movement_type == 'C'){
                $newAmount = $patient_deposit['deposit_amount'] + $amount_moved;
            }

            if($newAmount < 1){

                $status = 'D';
            }

            $data = array(
                'deposit_amount' => $newAmount,
                'status' => $status
            );

            $this->db->where("patient_deposit_id", $deposit_id);

            return $this->db->update("patient_deposit", $data);

        }

    }


}