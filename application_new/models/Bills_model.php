<?php

class Bills_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
        $this->load->model("patient_model");
        $this->load->model("partial_payments_model");

    }


    public function getBill($id = FALSE)
    {
        if ($id === FALSE) {
            $this->db->select('*');
            $this->db->order_by("date_created", "desc");
            $this->db->from('bills');
            $query = $this->db->get();
            return $query->result_array();
        }

        $query = $this->db->get_where('bills', array('id' => $id));
        return $query->row_array();
    }


    public function getBillsDispenseByReferenceNoPayment($reference_id)
    {
    }


    //gets all the pending dispense errors in the database
    public function getAllBillsNeedingDispense(){
        $this->db->select("*");
        $this->db->order_by("date_created", "desc");
        $this->db->from('pending_paid_dispense');

        $query = $this->db->get();
        return $query->result_array();

    }


    public function getBillReferencesNeedingDispense($patient_number)
    {

        $this->db->select('*');
        $this->db->order_by("date_posted", "desc");

        $where_clause = "(`dispense_needed` = 'Y' AND `patient_number` = '$patient_number')";
        $this->db->where($where_clause);

        $this->db->from('posted_bills');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllBillsNeedDispenseNoPayment()
    {
        $this->db->select("patient_number, reference_id, status, date_created, date_paid");
        $this->db->group_by("patient_number, reference_id, status, date_created, date_paid");
        $where_clause = "(`dispense_needed` = 'Y'  AND (status = 'N' OR status = 'R') )";
        $this->db->where($where_clause);
        $this->db->from('bills');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getBillsNeedDispenseNoPayment($patient_number)
    {
        $this->db->select("reference_id, status, date_created, date_paid");
        $this->db->group_by("reference_id, status, date_created, date_paid");
        $where_clause = "(`dispense_needed` = 'Y' AND `patient_number` = '$patient_number' AND (status = 'N' OR status = 'R') )";
        $this->db->where($where_clause);
        $this->db->from('bills');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getBillReferencesNeedingDispenseHmo($patient_number)
    {

        $this->db->select('*');
        $this->db->order_by("date_posted", "desc");

        $where_clause = "(`dispense_needed` = 'Y' AND `patient_number` = '$patient_number')";
        $this->db->where($where_clause);

        $this->db->from('hmo_bills_to_post');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function getBillByLabIdAndReference($reference_id, $lab_price_id)
    {
        $query = $this->db->get_where('bills', array('reference_id' => $reference_id, 'lab_price_id' => $lab_price_id));
        return $query->row_array();
    }


    public function getBillByReference($reference_id)
    {
        $query = $this->db->get_where('bills', array('reference_id' => $reference_id));
        return $query->result_array();
    }
	
	public function getBillPartialByReference($reference_id)
    {
        $query = $this->db->get_where('patient_partial_payments', array('reference_id' => $reference_id));
        return $query->result_array();
    }
	
	public function getBillPartialByReferenceCount($reference_id)
    {
        //$query = $this->db->get_where('patient_partial_payments', array('reference_id' => $reference_id));
        //return $query->count();
		
		$this->db->select("count(`id`) as total_count", FALSE);
        $query = $this->db->get_where('patient_partial_payments', array('reference_id' => $reference_id));
        return $query->row_array();
    }
	
		



    public function getBillByStatus($status)
    {
        $query = $this->db->get_where('bills', array('status' => $status));
        return $query->result_array();
    }

    public function addBillToHmo($bills, $refrence, $patient_number, $amount, $dispenseData)
    {
        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');

        $patient = $this->patient_model->getPatient($patient_number);


        $data = array('status' => 'H', 'reference_id' => $refrence, 'date_paid' => $todaysDate);

        $dispenseNeeded = null;

        foreach ($bills as $bill) {
            $data['dispense_needed'] = $dispenseData[$bill]['dispense_needed'];
            if ($data['dispense_needed'] == "Y") {
                $dispenseNeeded = "Y";
            }
            $this->db->where('id', $bill);
            $this->db->update('bills', $data);
        }


        $postedData = array('patient_number' => $patient_number,
            'reference_id' => $refrence,
            'date_posted' => $todaysDate,
            'dispense_needed' => $dispenseNeeded,
            'total_amount' => $amount,
            'status' => 'N',
            'hmo_code' => $patient["hmo_code"]);

        return $this->db->insert('hmo_bills_to_post', $postedData);
    }

    public function getHMOBillToPostByHmo($hmo)
    {
        $query = $this->db->get_where('hmo_bills_to_post', array('hmo_code' => $hmo, 'status' => 'N'));
        return $query->result_array();
    }

    public function createPartialPayment($bills, $refrence, $patient_number, $amount, $dispenseData, $partial_amount)
    {

        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');


        $data = array('status' => 'R', 'reference_id' => $refrence, 'date_paid' => $todaysDate);

        $dispenseNeeded = null;

        foreach ($bills as $bill) {
            $data['dispense_needed'] = $dispenseData[$bill]['dispense_needed'];
            if ($data['dispense_needed'] == "Y") {
                $dispenseNeeded = "Y";
            }
            $this->db->where('id', $bill);
            $this->db->update('bills', $data);
        }

        $this->partial_payments_model
            ->set_partial_payment($patient_number, $refrence, $partial_amount, $amount);

        return;

    }

    /**
     *
     * Completely closes a partial payment transaction, this is called when the last part payment is made
     *
     */
    public function postPartialPaymentCompletely($bills, $refrence, $patient_number, $amount, $partial_amount)
    {

        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');

        //post the last partial payment
        $this->partial_payments_model
            ->set_partial_payment($patient_number, $refrence, $partial_amount, $amount);


        $data = array('status' => 'P', 'reference_id' => $refrence, 'date_paid' => $todaysDate);
        //update all bills to paid and check if dispense is still needed for any

        $dispenseNeeded = null;
        foreach ($bills as $bill) {

            $billData = $this->getBill($bill);
            if ($billData['dispense_needed'] == 'Y') {
                $dispenseNeeded = 'Y';
            }


            $this->db->where('id', $bill);
            $this->db->update('bills', $data);
        }

        //create posted record in posted bills table
        $postedData = array('patient_number' => $patient_number,
            'reference_id' => $refrence,
            'date_posted' => $todaysDate,
            'dispense_needed' => $dispenseNeeded,
            'total_amount' => $amount,
            'posted_by' => $this->session->userdata("staff_no"));


        return $this->db->insert('posted_bills', $postedData);
    }

    public function postBills($bills, $refrence, $patient_number, $amount, $dispenseData)
    {
        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');


        $data = array('status' => 'P', 'reference_id' => $refrence, 'date_paid' => $todaysDate);

        $dispenseNeeded = null;

        foreach ($bills as $bill) {
            $data['dispense_needed'] = $dispenseData[$bill]['dispense_needed'];
            if ($data['dispense_needed'] == "Y") {
                $dispenseNeeded = "Y";
            }
            $this->db->where('id', $bill);
            $this->db->update('bills', $data);
        }


        $createdBy = $this->session->userdata("staff_no");
        if(!isset($createdBy) || $createdBy==""){

            $createdBy = "2005/10/01";
        }

        //create psoted record in posted bills table
        $postedData = array('patient_number' => $patient_number,
            'reference_id' => $refrence,
            'date_posted' => $todaysDate,
            'dispense_needed' => $dispenseNeeded,
            'total_amount' => $amount,
            'posted_by' => $createdBy);

        return $this->db->insert('posted_bills', $postedData);
    }


    public function removeBillItems($bills)
    {
        foreach ($bills as $bill) {

            $this->db->delete('bills', array('id' => $bill));

        }
    }

    public function getPostedBillsByPatient($patient_number)
    {

        $query = $this->db->get_where('posted_bills', array('patient_number' => $patient_number));

        return $query->result_array();
    }

    public function getPostedBillsByReference($reference)
    {

        $this->db->where("reference_id LIKE '%$reference%'");
        $this->db->from("posted_bills");

        $query = $this->db->get();

        return $query->result_array();
    }


    public function get_all_unposted($search = FALSE)
    {
        if ($search === FALSE) {
            $this->db->from('unposted_bills');
            $query = $this->db->get();

            return $query->result_array();
        }
        $where_clause = "(`reference_id` LIKE '%$search%' or `first_name` LIKE '%$search%' or `last_name` LIKE '%$search%' or `patient_number` LIKE '%$search%')";
        $this->db->from('unposted_bills');
        $this->db->where($where_clause);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_uncompleted_partial_bills_count($patient_number)
    {
        $this->db->select("count(`id`) as total", FALSE);
        $query = $this->db->get_where('bills', array('patient_number' => $patient_number, 'status' => 'R'));
        return $query->row_array();
    }

    public function get_number_unposted($patient_number)
    {
        $this->db->select("count(`id`) as total", FALSE);
        $query = $this->db->get_where('bills', array('patient_number' => $patient_number, 'status' => 'N'));

        return $query->row_array();

    }

    public function get_current_bill($patient_number)
    {

        $this->db->select("distinct(`reference_id`)");
        $query = $this->db->get_where('bills', array('patient_number' => $patient_number, 'status' => 'N'));

        return $query->row_array();
    }


    public function addBill($reference_id, $bill, $needDispense, $patient_number, $qty, $staff_no, $dept_id)
    {


        $this->load->helper('url');
        $this->load->helper('date');

        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');


        if ($bill["lab_price_id"]) {
            $qty = 1;
        }

        $data = array(
            'patient_number' => $patient_number,
            'staff_no' => $staff_no,
            'dept_id' => $dept_id,
            'description' => $bill['description'],
            'qty' => $qty,
            'unit_price' => $bill['unit_price'],
            'reference_id' => $reference_id,
            'date_created' => $todaysDate,
            'service_name' => $bill['service_name'],
            'bill_id' => $bill['bill_id'],
            'status' => 'N',
            'dispense_needed' => $needDispense
        );


        return $this->db->insert('bills', $data);


    }

    public function set_Bill($reference_id, $bill, $needDispense)
    {

        return $this->addBill($reference_id, $bill, $needDispense, $this->input->post('patient_number'),
            $this->input->post('qty'), $this->input->post('staff_no'), $this->input->post('dept_id'));

        /*$this->load->helper('url');
        $this->load->helper('date');

        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');

        $qty = $this->input->post('qty');

        if ($bill["lab_price_id"]) {
            $qty = 1;
        }

        $data = array(
            'patient_number' => $this->input->post('patient_number'),
            'staff_no' => $this->input->post('staff_no'),
            'dept_id' => $this->input->post('dept_id'),
            'description' => $bill['description'],
            'qty' => $qty,
            'unit_price' => $bill['unit_price'],
            'reference_id' => $reference_id,
            'date_created' => $todaysDate,
            'service_name' => $bill['service_name'],
            'bill_id' => $bill['bill_id'],
            'status' => 'N',
            'dispense_needed' => $needDispense
        );


        return $this->db->insert('bills', $data);*/
    }
	
	
	
	public function getBillDate($reference_id)
    {

		$query = $this->db->select('min(date_created) as bill_date')->from('bills')->where('reference_id', $reference_id)->get();
		return $query->row()->bill_date;
		
		
    }
	
	
	
	 public function getFinancialRecords($patient_number)
    {
		
		$query = $this->db->get_where('bills', array('patient_number' => $patient_number));
		$this->db->order_by("date_created", "desc");
        return $query->result_array();
    }


}