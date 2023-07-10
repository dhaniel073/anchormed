<?php
/**
 * Created by PhpStorm.
 * User: dusty
 * Date: 8/26/16
 * Time: 4:48 PM
 * patient service will handle all the patient service
 */

class Mobile_user_service
{

    //codeigniter reference in this case medstation
    private $medstation;
    

    /**
     * PatientService constructor.
     */
    public function __construct()
    {
        $this->medstation =& get_instance();
        $this->medstation->load->database();
        $this->medstation->load->model('patient_model');
        $this->medstation->load->model('plt_model');
        log_message("info", "after plt model");

        $this->medstation->load->library('passwordhash', array('iteration_count_log2' => 8, 'portable_hashes' => FALSE ));
        log_message("info", "after constructor");

    }

    public function createNewUserPassword($patient_number, $code, $password){

        $result = $this->verifyMobileUser($patient_number, $code);

        if($result["status"] == true){

            //update password, since the verification code is correct
            $hashedPwd = $this->medstation->passwordhash->HashPassword($password);
            log_message("debug", "about updating password of user $patient_number");

            $this->medstation->plt_model->updatePassword($patient_number, $hashedPwd);

            log_message("debug", "updating user status");

            $this->medstation->plt_model->clearVerificationCode($patient_number);

            $this->medstation->plt_model->updateUserStatus($patient_number, 'A');

            $result["description"] = "Password successfully created, please log in";
        }

        return $result;
    }

    
    public function verifyMobileUser($patient_number, $code){

        $result = array("status"=>false, "description"=> "", "errorCode" => "");

        $plt = $this->medstation->plt_model->findPltByPatientNumber($patient_number);

        if(isset($plt)){

            //if the status is unverified
            if($plt["status"] == 'U'){

                //verify the patient
                if($plt["verification_code"] == $code){

                    $result["status"] = true;
                    $result["description"] = "Verified";

                }else{

                    $result["description"] = "invalid code";
                    $result["errorCode"] = ERROR_CODE_GENERAL_API_FAIL;
                }
            }else{

                $result["description"] = "invalid request";

            }


        }else{

            $result["description"] = "patient not enabled for mobile ";
            $result["errorCode"] = ERROR_CODE_INVALID_PATIENT;
        }

        return $result;
    }


    public function regenerateVerificationCode($patient_number){

        $result = array("status"=>false, "description"=> "");

        //first confirm the patient exists in the hospital
        $plt = $this->medstation->plt_model->findPltByPatientNumber($patient_number);
        log_message("debug", "regenerate code called");


        if(isset($plt)){

            if($plt["status"] == 'U'){

                //doesn't exist, create and generate a code
                $randomCode = $this->medstation->utilities->generateRandomVerificationCode();

                $this->medstation->plt_model->updateVeriCode($patient_number, $randomCode);

                //TODO: send sms to user with the verification code

                $result["status"] = true;
                $result["description"] = "regenerated verification code";

            }else{

                $result["description"] = "user already registered";
            }


        }else{

            $result["description"] = "patient not registered";
        }

        return $result;
    }
    
    //search for patient by the patient name, if no name is passed will search for all patients
    public function registerNewUser($patient_number, $mobile){

        log_message("debug", "register new user api called");

        $result = array("status"=>false, "description"=> "", "errorCode" => "");

        //first confirm the patient exists in the hospital
        $foundPatient = $this->medstation->patient_model->getPatient($patient_number);

        if(isset($foundPatient)){

            //next check if user has already been created in the plt table
            $plt = $this->medstation->plt_model->findPltByPatientNumber($patient_number);

            //already created
            if(isset($plt)){

                log_message("debug", "user already created in the plt, checking if user has finished the process");
                //if the user is still unverified
                if($plt["status"] == 'U'){

                    log_message("debug", "user has not finished the process");

                    if($mobile != $foundPatient["mobile_number"] && $mobile != $foundPatient["cell_number"]) {

                        log_message("debug", "invalid phone number provided for patient number $patient_number");
                        $result["description"] = "invalid phone number, please contact your hospital";


                    }else{

                        log_message("debug", "about to regenerate code");

                        $result = $this->regenerateVerificationCode($patient_number);

                        log_message("debug", json_encode($result));

                        return $result;
                    }


                }else{

                    $result["errorCode"] = ERROR_CODE_GENERAL_API_FAIL;
                    log_message("debug", "patient number $patient_number already registered as a user");
                    $result["description"] = "already registered, please sign in";
                }
                

                
            }else{

                if($mobile != $foundPatient["mobile_number"] && $mobile != $foundPatient["cell_number"]){

                    log_message("debug", "valid phone numbers ".$foundPatient["cell_number"]." and ". $foundPatient["mobile_number"]);
                    log_message("debug", "invalid phone number provided for patient number $patient_number");
                    $result["description"] = "invalid phone number, please contact your hospital";


                }else{

                    //doesn't exist, create and generate a code
                    $randomCode = $this->medstation->utilities->generateRandomVerificationCode();

                    $this->medstation->plt_model->create_new($patient_number, $randomCode);

                    //TODO: send sms to user with the verification code

                    $result["status"] = true;
                    $result["description"] = "successfully added user";

                }



            }

        }else{

            $result["description"] = "invalid patient number, verify with hospital";
            log_message("debug", "invalid patient number $patient_number");
        }

        return $result;
    }


}