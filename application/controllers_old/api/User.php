<?php

/**
 * Created by PhpStorm.
 * User: dusty
 * Date: 9/14/16
 * Time: 5:26 PM
 */


defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';


class User extends REST_Controller{

    const PATIENT_NUMBER = "patientNumber";
    const VERIFICATION_CODE = "verificationCode";
    const PHONE_NUMBER = "mobile";
    const PASSWORD = "pwd";
    /**
     * Resource constructor.
     */
    public function __construct()
    {
        @session_start();
        parent::__construct();
        $this->load->library("services/mobile_user_service");
        $this->load->library("Server", "server");
        $this->server->require_scope(MOBILE_ADMIN);//requires mobile admin to function
    }

    /*
     * api to create user password, part of verification process requires generated code
     */
    public function createPassword_post(){

        $patientNumber = $this->post(SELF::PATIENT_NUMBER);
        $verificationCode = $this->post(SELF::VERIFICATION_CODE);
        $password = $this->post(SELF::PASSWORD);

        if(!isset($patientNumber) || !isset($verificationCode) || !isset($password)){

            $result = array("status" => false, "description"=>"missing required parameter");
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);

        }else{

            $result = $this->mobile_user_service->createNewUserPassword($patientNumber, $verificationCode, $password);
            $this->response($result, REST_Controller::HTTP_OK);
        }
    }



    public function verifyAccount_post(){

        $patientNumber = $this->post(SELF::PATIENT_NUMBER);
        $verificationCode = $this->post(SELF::VERIFICATION_CODE);

        if(!isset($patientNumber) || !isset($verificationCode)){

            $result = array("status" => false, "description"=>"missing required parameter");
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);

        }else{

            $result = $this->mobile_user_service->verifyMobileUser($patientNumber, $verificationCode);
            $this->response($result, REST_Controller::HTTP_OK);


        }

    }



    public function genNewCode_post(){

        $patientNumber = $this->post(SELF::PATIENT_NUMBER);

        if(!isset($patientNumber)){

            $result = array("status" => false, "description"=>"missing required parameter");
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);

        }else{

            log_message("debug", "about generating new verification code");
            $result = $this->mobile_user_service->regenerateVerificationCode($patientNumber);
            $this->response($result, REST_Controller::HTTP_OK);
        }
    }

    public function register_post(){

        $patientNumber = $this->post(SELF::PATIENT_NUMBER);
        $mobile = $this->post(SELF::PHONE_NUMBER);

        log_message("debug", "received $mobile, $patientNumber");

        if(!isset($patientNumber) || !isset($mobile)){

            $result = array("status" => false, "description"=>"missing required parameter");
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);

        }else{

            log_message("debug", "patient number submitted is :  $patientNumber");
            $result = $this->mobile_user_service->registerNewUser($patientNumber, $mobile);

            $this->response($result, REST_Controller::HTTP_OK);
        }


    }


}