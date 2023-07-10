<?php

/**
 * Created by PhpStorm.
 * User: dusty
 * Date: 10/22/16
 * Time: 12:54 PM
 */
class Hmo_bills_to_post_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }



    public function getHmoBillsByPaymentRef($paymentRef){

        $query = $this->db->get_where('hmo_bills_to_post', array('payment_ref' => $paymentRef));

        return $query->result_array();


    }
}