<?php

/**
 * Created by PhpStorm.
 * User: dusty
 * Date: 9/28/16
 * Time: 11:25 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';


class MobileUser extends REST_Controller{


    const PAID_BILLS = "paidBills";
    const BILL_REFERENCE = "billReferenceId";
    const PAID_AMOUNT = "paidAmount";
    const PAYMENT_REFERENCE = "paymentReferenceId";

    public function __construct()
    {
        @session_start();
        parent::__construct();
        $this->load->library("services/mobile_user_service");
        $this->load->library("services/patient_service");
        $this->load->library("services/bill_service");
        $this->load->library("Server", "server");
        $this->server->require_scope(MOBILE_USER);//requires mobile user to function
    }


    public function getPatientDetails_post(){

        $patientDetails = $this->patient_service->findPatientByNumber($this->server->getLoggedInUserId());
        $this->response($patientDetails, REST_Controller::HTTP_OK);

    }

    public function paymentNotification_post(){

        $paidBills = $this->post(SELF::PAID_BILLS);
        $paidAmount = $this->post(SELF::PAID_AMOUNT);
        $billReference = $this->post(SELF::BILL_REFERENCE);
        $paymentReferenceId = $this->post(SELF::PAYMENT_REFERENCE);
        $patientNumber = $this->server->getLoggedInUserId();

        if(!isset($paidBills) || !isset($paidAmount) || !isset($billReference) || !isset($paymentReferenceId)){

            $result = array("status" => false, "description"=>"missing required parameter");
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);

        }else{

            log_message("debug", "validating request");

            $patientBills = $this->bill_service->getPatientCurrentBills($patientNumber);
            $storedReference = $patientBills["referenceId"];

            $isRequestValidated = true;

            if(trim($storedReference) != trim($billReference)){

                $isRequestValidated = false;
                log_message("debug", "refrences do not match $storedReference, $billReference");

            }else{

                $totalBillAmount = 0;

                if(isset($patientBills["bills"])){

                    //calulate amount and validate
                    foreach($patientBills["bills"] as $item){

                        log_message("debug", "decoded item : " .json_encode($item));
                        $totalBillAmount += $item["price"];
                    }
                }


                if($totalBillAmount != $paidAmount){

                    $isRequestValidated = false;
                    log_message("debug", "amounts don't match $totalBillAmount, $paidAmount");
                }

            }

            if(!$isRequestValidated){

                $result = array("status" => false, "description"=>"invalid request");
                $this->response($result, REST_Controller::HTTP_OK);

            }else{

                log_message("debug", "payment notification request");
                log_message("debug",
                    "patient number : $patientNumber, bill reference : $billReference , payment reference id : $paymentReferenceId, payment amount :$paidAmount" );

                //get patient details
                $patientDetails = $this->patient_service->findPatientByNumber($patientNumber);


                $result =$this->bill_service->postBill($patientNumber, $paidBills, "N", "N",
                    "", "", $patientDetails["patientTypeCode"], "N", "N", 0, "mobile", "reference");

                $this->response($result, REST_Controller::HTTP_OK);
            }



        }
    }


    public function getPatientBills_post(){
        $bills = $this->bill_service->getPatientCurrentBills($this->server->getLoggedInUserId());
        $this->response($bills, REST_Controller::HTTP_OK);

    }
    

}