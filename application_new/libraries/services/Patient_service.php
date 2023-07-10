<?php
/**
 * Created by PhpStorm.
 * User: dusty
 * Date: 8/26/16
 * Time: 4:48 PM
 * patient service will handle all the patient service
 */

class Patient_service
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
        log_message("info", "finished creating patient service");
    }


    //search for patient by the patient name, if no name is passed will search for all patients
    public function findPatientByName($name){

        if (isset($name)) {
            $result = $this->medstation->patient_model->getPatientLikeName($name);
        } else {
            $result = $this->medstation->patient_model->getPatient();
        }

        return $result;
    }

    /**
     * @param $patientNumber
     * @return mixed
     */
    public function findPatientByNumber($patientNumber){

        /**
         * "patient_number": "2016F2",
        "first_name": "chukwudum",
        "last_name": "ekwueme",
        "middle_name": "nkemka",
        "dob": "2016-06-28",
        "legacy_file_number": "",
        "occupation_id": "206",
        "religion_id": "22",
        "marital_status": "M",
        "state_of_origin": "14",
        "orign_country_code": "NGA",
        "origin_lga_id": null,
        "mobile_number": "08091871598",
        "cell_number": "",
        "email": "chidumekwueme@gmail.com",
        "alt_email": "chidumekwueme@gmail.com",
        "address_line_1": "171 old ojo road",
        "address_line_2": "alakija",
        "address_state_code": "14",
        "address_lga_id": null,
        "address_country_code": "NGA",
        "patient_type_code": "F",
        "date_created": "2016-06-28 11:02:30",
        "date_modified": null,
        "status": "A",
        "legacy_date_opened": null,
        "hmo_code": null,
        "sex": "M",
        "height": null,
        "hmo_enrolee_id": null,
        "blood_group_id": null,
        "phenotype_id": null,
        "created_by": "2005/10/01",
        "modified_by": null,
        "allergies": null,
        "admission_status": null,
        "weight": null,
        "principal_number": null,
        "patient_pic": null,
        "old_patient_data": null,
        "free_code_1": "2",
        "free_code_2": "1"
         */
        $foundPatient = $this->medstation->patient_model->getPatient($patientNumber);

        $result["patientNumber"] = $foundPatient["patient_number"];
        $result["firstName"] = ucfirst($foundPatient["first_name"]);
        $result["middleName"] = ucfirst($foundPatient["middle_name"]);
        $result["lastName"] = ucfirst($foundPatient["last_name"]);
        $result["patientTypeCode"] = $foundPatient["patient_type_code"];
        //http://app.dusty.com/medstation/patients/profile_pics/2016F2.jpg
        $result["profilePic"] = base_url().$foundPatient["patient_pic"];
        $result["profilePic"] = "http://192.168.6.235/medstation/".$foundPatient["patient_pic"];
        
        return $result;
    }
}