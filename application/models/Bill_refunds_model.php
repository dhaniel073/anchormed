<?php

class Bill_refunds_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }


    public function getBillRefunds($refund_id = FALSE)
    {
        if ($refund_id === FALSE) {
            $this->db->select('*');
            $this->db->order_by("date_created", "asc");
            $this->db->from('bill_refunds');
            $this->db->where("status = 'A'");
            $query = $this->db->get();
            return $query->result_array();
        }

        $query = $this->db->get_where('bill_refunds', array('bill_refunds_id' => $refund_id));
        return $query->row_array();
    }

    public function getRefundsByReference($reference_id)
    {
        $query = $this->db->get_where('bill_refunds', array('bill_reference_id' => $reference_id));
        return $query->result_array();
    }


    public function createRefund($reference_id, $amount,$staff_no)
    {
        $this->load->helper('url');

        $data = array(
            'refund_amount' => $amount,
            'bill_reference_id' => $reference_id,
            'date_created' => $this->utilities->getDate(),
            'created_by' => $staff_no,
            'status' => 'A'
        );

        return $this->db->insert('bill_refunds', $data);
    }

}