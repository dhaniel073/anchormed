<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
define ('MODULE_NO', 1);
define ('SUB_MODULE_NO', 2);
define ('TITLE', 'Data Upload');

class Upload extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('sub_module_map_model');
        $this->load->model('module_map_model');
        $this->load->model('role_model');
        $this->load->model('country_model');
        $this->load->model('state_model');
        $this->load->helper(array('form', 'url'));
        $this->load->model('lga_model');
        $this->load->model('hmo_model');
        $this->load->model('patient_model');
        $this->load->model('religion_model');
        $this->load->model('bloodgrp_model');
        $this->load->model('phenotype_model');
        $this->load->model('occupation_model');
        $this->load->model('relationship_model');
        $this->load->model('hmo_model');
        $this->load->model('file_counter_model');
        $this->load->model('next_of_kin_model');
        $this->load->model('general_update_model');
        $this->load->model('drug_master_model');
        $this->load->model('drug_bill_form_model');
        $this->load->model('bill_master_model');
        $this->load->model('pharmacy_stock_model');
        $this->load->model('drug_presentation_model');
        $this->load->model('drug_price_master_model');
        $this->load->model('unit_model');


    }

    public function downloadTemplates()
    {


    }

    private function confirmUrl()
    {
        if ($this->session->userdata('base_url') != base_url()) {
            redirect("/logout");
        }

    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();

            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), SUB_MODULE_NO);

            if (!isset($moduleAccess) || $moduleAccess['access'] != "W") {
                redirect('/pages');
            }

            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

            $data['title'] = "Medstation | Data Upload";
            $data['content-description'] = "Patient Legacy Uploader";
            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/mainheader', $data);
            $this->load->view('upload/home', array('error' => ' '));
            $this->load->view('templates/footer');
        } else {

            redirect('/login');
        }

    }

    private function uploadDrugs($drugs){

        $returnArray['error'] = FALSE;
        $returnArray['error']['details'] = "uploaded successfully";
        $error = FALSE;
        $errorDetails = "uploaded successfully";

        $counter = 0;

        foreach($drugs as $drug){

            if($counter != 0){

                $name = $drug[0];
                $manufacturer = $drug[1];
                $packDesc = $drug[2];
                $dosageForm = $drug[3];
                $billForm = $drug[4];
                $price = $drug[5];
                $measurement = $drug[6];
                $unit = $drug[7];
				$manufacturedate = $drug[8];
				$expirydate = $drug[9];
				$quantity = $drug[10];
				$batchnumber = $drug[11];

                $drugPresentation = $this->drug_presentation_model->getDrugPresentationByName(trim($dosageForm));
                $drugBillForm = $this->drug_bill_form_model->getDrugBillByName($billForm);
                $measurementUnit = $this->unit_model->getUnitByName($unit);


                if(!is_numeric($price)){

                    $error = TRUE;
                    $errorDetails = "Check record $counter, invalid price $price, for $name manufactured by $manufacturer. must be numeric";
                    $returnArray['error']['details'] = $errorDetails;
                    break;
                }

                if(!is_numeric($measurement)){

                    $error = TRUE;
                    $errorDetails = "Check record $counter, invalid measurement $measurement, for $name manufactured by $manufacturer. must be numeric";
                    $returnArray['error']['details'] = $errorDetails;
                    break;
                }

                if(!$drugBillForm){

                    $error = TRUE;
                    $errorDetails = "Check record $counter, invalid billing form $billForm, for $name manufactured by $manufacturer";
                    $returnArray['error']['details'] = $errorDetails;
                    break;
                }

                if(!$drugPresentation){
                    $error = TRUE;
                    $errorDetails = "Check record $counter, invalid dosage form $dosageForm, for $name manufactured by $manufacturer";
                    $returnArray['error']['details'] = $errorDetails;
                    break;
                }

                if(!$measurementUnit){
                    $error = TRUE;
                    $errorDetails = "Check record $counter, invalid unit measurement $unit, for $name manufactured by $manufacturer";
                    $returnArray['error']['details'] = $errorDetails;
                    break;
                }
				
				if(!$manufacturedate){
                    $error = TRUE;
                    $errorDetails = "Check record $counter, invalid manufacturing date $manufacturedate, for $name manufactured by $manufacturer";
                    $returnArray['error']['details'] = $errorDetails;
                    break;
                }
				
				if(!$expirydate){
                    $error = TRUE;
                    $errorDetails = "Check record $counter, invalid expiry date $expirydate, for $name manufactured by $manufacturer";
                    $returnArray['error']['details'] = $errorDetails;
                    break;
                }

				if(!$quantity){
                    $error = TRUE;
                    $errorDetails = "Check record $counter, invalid quantity $quantity, for $name manufactured by $manufacturer";
                    $returnArray['error']['details'] = $errorDetails;
                    break;
                }
				
				if(!$batchnumber){
                    $error = TRUE;
                    $errorDetails = "Check record $counter, invalid batch number $batchnumber, for $name manufactured by $manufacturer";
                    $returnArray['error']['details'] = $errorDetails;
                    break;
                }

               //perform validations

                //check if drug exists
                if(strlen($name) < 1 || strlen($manufacturer) < 1 ){
                    $error = TRUE;
                    $errorDetails = "Check record $counter, no name or manufacturer specified";
                    $returnArray['error']['details'] = $errorDetails;
                    break;
                }

                $drug = $this->drug_master_model->getDrugByNameAndManufacturer($name, $manufacturer);

                if(is_array($drug) && sizeof($drug) > 1){

                    $error = TRUE;
                    $errorDetails = "invalid Excel sheet, $name made by $manufacturer already exists";
                    $returnArray['error']['details'] = $errorDetails;
                    break;
                }

                //find the dosage form


                // [0] => name [1] => manufacturer [2] => packaging description [3]
                // => dosage form [4] => billing form [5] => price [6] => measurement [7] => measurement unit
            }

            $counter++;
        }


        if ($error) {

        } else {
            $counter = 0;
            //if no errors then commit to database
            foreach ($drugs as $drug) {

                $name = trim($drug[0]);
                $manufacturer = trim($drug[1]);
                $packDesc = trim($drug[2]);
                $dosageForm = $drug[3];
                $billForm = $drug[4];
                $price = $drug[5];
                $measurement = $drug[6];
                $unit = $drug[7];
				$manufacturedate = $drug[8];
				$expirydate = $drug[9];
				$quantity = $drug[10];
				$batchnumber = $drug[11];


                if ($counter != 0) {

                    $drugPresentation = $this->drug_presentation_model->getDrugPresentationByName(trim($dosageForm));
                    $drugBillForm = $this->drug_bill_form_model->getDrugBillByName($billForm);
                    $measurementUnit = $this->unit_model->getUnitByName($unit);


                    //create drug
                    $this->drug_master_model->set_drug_excel($name,$manufacturer,$drugPresentation['drug_presentation_id'],
                        $packDesc,$this->session->userdata("staff_no"));

                    //find created drug and create stock
                    $drug = $this->drug_master_model->getDrugByNameAndManufacturer($name,
                        $manufacturer);

                    //after uploading populate the stock

                    //note if the stock is 0 just add a null dummy data

                    $this->pharmacy_stock_model->set_Stock($this->session->userdata("staff_no")
                        ,$drug['drug_id'],
                        $quantity,
                        $drugBillForm['drug_bill_package_id'],
                        $batchnumber,
                        $manufacturedate,
                        $expirydate);


                    $this->drug_price_master_model->set_drug_price_master(
                        $this->session->userdata("staff_no"),
                        $drugPresentation['drug_presentation_id'],
                        $drugBillForm['drug_bill_package_id'],
                        "NGN",
                        $price,
                        $drug['drug_id'],
                        $measurement,
                        $measurementUnit["id"]);

                    $drug_price_master = $this->drug_price_master_model->getDrugPriceByPackage(
                        $drug['drug_id'],
                        $drugBillForm['drug_bill_package_id']);


                    //add link to billing master
                    $description = ucfirst($drug['name'])."( Sold by ".$drugBillForm['name']." )";
                    if($packDesc)
                    {
                        $description = $packDesc;
                    }

                    $this->bill_master_model->set_drug_bill(
                        $this->session->userdata("staff_no"),
                        $description,
                        ucfirst($drug['name'])."( Sold by ".$drugBillForm['name']." )",
                        $drug_price_master['unit_price'],
                        $drug_price_master['drug_price_id']);

                }

                $counter++;
            }
        }



        $returnArray['error'] = $error;
        $returnArray['details'] = $errorDetails;



        return $returnArray;
    }

    public function uploadLegacyHistory()
    {
        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), SUB_MODULE_NO);

            if (!isset($moduleAccess) || $moduleAccess['access'] != "W") {
                redirect('/pages');
            }

            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

            $data['title'] = "Medstation | Data Upload";
            $data['content-description'] = "Patient Legacy Uploader";
            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;


            $config['upload_path'] = 'uploads/zip/';
            $config['allowed_types'] = 'zip';


            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());
                $this->loadErrorPage($data, $error);

            } else {
                $uploadedZip = $this->upload->data();


                $zip = new ZipArchive;

                if ($zip->open($uploadedZip['full_path']) === TRUE) {
                    $zip->extractTo('uploads/zip/');
                    $zip->close();

                    unlink($uploadedZip['full_path']);


                    $historyFiles = scandir('uploads/zip/');
                    $zipfiles[0] = "";
                    $error[1] = false;
                    $counter = 0;
                    foreach ($historyFiles as $file) {

                        $info = new SplFileInfo($file);

                        $extension = $info->getExtension();

                        if (strtolower($extension) == "pdf") {
                            $zipfiles[$counter] = strtolower($file);
                            $counter++;
                        }


                    }


                    if (sizeof($zipfiles) > 0) {
                        foreach ($zipfiles as $z) {
                            $old_number = str_replace(".pdf", "", $z);
                            $patientData = $this->patient_model->getPatientByOldNumber($old_number);

                            if (sizeof($patientData) > 1) {
                                //do nothing it past the test
                            } else {
                                //add error make sure not found
                                $error[1] = true;
                                $error[0] = $old_number;
                                break;
                            }
                        }

                        if ($error[1]) {

                            //clean up work directory
                            foreach ($historyFiles as $file) {
                                $pdf = "uploads/zip/" . $file;
                                if (is_file($pdf)) {
                                    unlink($pdf);
                                }

                            }
                            $error = array('error' => "patient number " . $old_number . " was not found in the database, all changes reverted");

                            $this->loadErrorPage($data, $error);
                        } else {

                            foreach ($zipfiles as $z) {
                                $old_number = str_replace(".pdf", "", $z);
                                $patientData = $this->patient_model->getPatientByOldNumber($old_number);


                                //update patient_master_data table to reflect the upload
                                $updatedata['old_patient_data'] = "Y";
                                $table_name = "patient_master_table";
                                $id = "patient_number";
                                $id_value = $patientData['patient_number'];
                                $this->general_update_model->update($table_name, $id, $id_value, $updatedata);


                                //move the pdf file to its the patient history location
                                rename("uploads/zip/" . $z, "patients/legacy_history/" . $patientData['patient_number'] . ".pdf");


                            }

                            //clean up directory
                            foreach ($historyFiles as $file) {
                                $pdf = "uploads/zip/" . $file;
                                if (is_file($pdf)) {
                                    unlink($pdf);
                                }

                            }

                            $error = array('error' => "Sucessfully uploaded history");
                            $this->loadErrorPage($data, $error);
                        }
                    } else {
                        $error = array('error' => "no valid history file was found in the zip file");
                        $this->loadErrorPage($data, $error);
                    }

                    //create an array of pdffiles


                } else {
                    echo 'failed';
                }

            }

        } else {

            redirect('/login');
        }

    }

    function do_upload()
    {
        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();
            $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), SUB_MODULE_NO);

            if (!isset($moduleAccess) || $moduleAccess['access'] != "W") {
                redirect('/pages');
            }

            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

            $data['title'] = "Medstation | Data Upload";
            $data['content-description'] = "Patient Legacy Uploader";
            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;


            $config['upload_path'] = 'uploads/excel/';
            $config['allowed_types'] = 'xls|xlsx';
            //$config['max_size']	= '2000';


            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());
                $this->loadErrorPage($data, $error);
            } else {
                $data['upload_data'] = $this->upload->data();

                $this->load->library('excel');

                $objPHPExcel = $this->excel;

                $inputFileType = PHPExcel_IOFactory::identify('uploads/excel/' . $data['upload_data']['file_name']);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);

                $objReader->setReadDataOnly(true);

                /**  Load $inputFileName to a PHPExcel Object  **/
                $objPHPExcel = $objReader->load('uploads/excel/' . $data['upload_data']['file_name']);

                $total_sheets = $objPHPExcel->getSheetCount();

                $allSheetName = $objPHPExcel->getSheetNames();
                $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
                $highestRow = $objWorksheet->getHighestRow();
                $highestColumn = $objWorksheet->getHighestColumn();
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                for ($row = 1; $row <= $highestRow; ++$row) {
                    for ($col = 0; $col < $highestColumnIndex; ++$col) {
                        $value = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();

                        $arraydata[$row - 1][$col] = $value;


                    }

                }

                //delete excel file
                unlink('uploads/excel/' . $data['upload_data']['file_name']);

                $type = $this->input->post('upload_type');

                if ($type == "country") {
                    if (sizeof($arraydata[0]) != 2) {
                        $error = array('error' => "Invalid Excel Sheet, Please view template");
                        $this->loadErrorPage($data, $error);
                    } else {

                        $response = $this->uploadCountry($arraydata);
                        if ($response['error']) {
                            $error = array('error' => $response['details']);
                            $this->loadErrorPage($data, $error);

                        } else {
                            $data['sucess'] = "Sucessfully uploaded data";

                            $this->loadSucessPage($data);
                        }
                    }
                } else if ($type == "state") {
                    if (sizeof($arraydata[0]) != 3) {
                        $error = array('error' => "Invalid Excel Sheet, Please view template");
                        $this->loadErrorPage($data, $error);
                    } else {
                        $response = $this->uploadState($arraydata);

                        if ($response['error']) {
                            $error = array('error' => $response['details']);
                            $this->loadErrorPage($data, $error);

                        } else {
                            $data['sucess'] = "Successfully uploaded data";

                            $this->loadSucessPage($data);
                        }
                    }
                } else if ($type == "lga") {

                    if (sizeof($arraydata[0]) != 3) {
                        $error = array('error' => "Invalid Excel Sheet, Please view template");
                        $this->loadErrorPage($data, $error);
                    } else {


                        $response = $this->uploadLga($arraydata);

                        if ($response['error']) {
                            $error = array('error' => $response['details']);
                            $this->loadErrorPage($data, $error);

                        } else {
                            $data['sucess'] = "Successfully uploaded data";

                            $this->loadSucessPage($data);
                        }
                    }
                }
                else if($type == "drug"){

                    if (sizeof($arraydata[0]) != 12) {
                        $error = array('error' => "Invalid Excel Sheet, Please view template");
                        $this->loadErrorPage($data, $error);
                    } else {

                        $response = $this->uploadDrugs($arraydata);


                        if ($response['error']) {
                            $error = array('error' => $response['details']);
                            $this->loadErrorPage($data, $error);

                        } else {
                            $data['sucess'] = "Successfully uploaded data";

                            $this->loadSucessPage($data);
                        }
                    }
                }
                else if ($type == "hmo") {
                    if (sizeof($arraydata[0]) != 8) {
                        $error = array('error' => "Invalid Excel Sheet, Please view template");
                        $this->loadErrorPage($data, $error);
                    } else {


                        $response = $this->uploadProvider($arraydata);

                        if ($response['error']) {
                            $error = array('error' => $response['details']);
                            $this->loadErrorPage($data, $error);

                        } else {
                            $data['sucess'] = "Successfully uploaded data";

                            $this->loadSucessPage($data);
                        }
                    }
                } else if ($type == "patient") {
                    if (sizeof($arraydata[0]) != 38) {
                        $error = array('error' => "Invalid Excel Sheet, Please view template");
                        $this->loadErrorPage($data, $error);
                    } else {

                        $response = $this->uploadPatients($arraydata);

                        if ($response['error']) {
                            $error = array('error' => $response['details']);
                            $this->loadErrorPage($data, $error);

                        } else {
                            $data['sucess'] = "Successfully uploaded data";

                            $this->loadSucessPage($data);
                        }
                    }

                }


            }
        } else {

            redirect('/login');
        }
    }

    private function loadErrorPage($data, $error)
    {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/mainheader', $data);

        $this->load->view('upload/home', $error);
        $this->load->view('templates/footer');

    }

    private function loadSucessPage($data)
    {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/mainheader', $data);

        $this->load->view('upload/home', $data);
        $this->load->view('templates/footer');
    }

    private function uploadCountry($countryData)
    {
        $returnArray['error'] = FALSE;
        $returnArray['error']['details'] = "";

        //validate country data
        $error = FALSE;
        $errorDetails = "";

        $counter = 0;
        foreach ($countryData as $country) {
            if (sizeof($country) != 2) {
                $error = TRUE;
                $errorDetails = "invalid Excel sheet, please use the template as a guide";
                $returnArray['error']['details'] = $errorDetails;
                break;
            }
            if ($counter != 0) {
                //country code
                if (strlen($country[0]) != 3) {
                    //if country code is invalid break out of loop
                    $error = TRUE;
                    $errorDetails = "Country code : " . $country[0] . " is invalid";
                    $returnArray['error']['details'] = $errorDetails;
                    break;
                } else {

                    $result = $this->country_model->getCountries($country[0]);


                    if (sizeof($result) > 0) {
                        $error = TRUE;
                        $errorDetails = "Country code : " . $country[0] . " already exists";
                        $returnArray['error']['details'] = $errorDetails;
                        //echo $returnArray['error']['details'];

                        break;
                    }
                }

            }
            $counter++;
        }

        if ($error) {

        } else {
            $counter = 0;
            //if no errors then commit to database
            foreach ($countryData as $country) {
                if ($counter != 0) {
                    $this->country_model->set_Country_Upload($country[0], $country[1]);
                }

                $counter++;
            }
        }

        $returnArray['error'] = $error;
        $returnArray['details'] = $errorDetails;

        return $returnArray;


    }


    private function uploadState($statedata)
    {
        $returnArray['error'] = FALSE;
        $returnArray['error']['details'] = "";

        //validate country data
        $error = FALSE;
        $errorDetails = "";

        $counter = 0;
        foreach ($statedata as $state) {
            if (sizeof($state) != 3) {
                $error = TRUE;
                $errorDetails = "invalid Excel sheet, please use the template as a guide";
                $returnArray['error']['details'] = $errorDetails;
                break;
            }
            if ($counter != 0) {
                //country code
                if (strlen($state[0]) > 3 || strlen($state[0]) < 1) {
                    //if state code is invalid break out of loop
                    $error = TRUE;
                    $errorDetails = "State code : " . $state[0] . " is invalid";
                    $returnArray['error']['details'] = $errorDetails;
                    break;
                } else {

                    $result = $this->country_model->getCountries(trim(strtoupper($state[2])));
                    $formalStateData = $this->state_model->getState(trim(strtoupper($state[0])));


                    if (empty($result)) {
                        $error = TRUE;
                        $errorDetails = "Country code : " . $state[2] . " does not exist in the database";
                        $returnArray['error']['details'] = $errorDetails;
                        //echo $returnArray['error']['details'];

                        break;
                    }

                    if (sizeof($formalStateData) > 0) {
                        $error = TRUE;
                        $errorDetails = "State code : " . $state[0] . " already exists";
                        $returnArray['error']['details'] = $errorDetails;
                        //echo $returnArray['error']['details'];

                        break;
                    }
                }

            }
            $counter++;
        }

        if ($error) {

        } else {
            $counter = 0;
            //if no errors then commit to database
            foreach ($statedata as $state) {
                if ($counter != 0) {
                    $this->state_model->set_State_Excel($state[1], $state[0], $state[2]);
                }

                $counter++;
            }
        }

        $returnArray['error'] = $error;
        $returnArray['details'] = $errorDetails;


        return $returnArray;


    }


    private function uploadLga($lgadata)
    {
        $returnArray['error'] = FALSE;
        $returnArray['error']['details'] = "";

        //validate country data
        $error = FALSE;
        $errorDetails = "";

        $counter = 0;
        foreach ($lgadata as $lga) {
            if (sizeof($lga) != 3) {
                $error = TRUE;
                $errorDetails = "invalid Excel sheet, please use the template as a guide";
                $returnArray['error']['details'] = $errorDetails;
                break;
            }
            if ($counter != 0) {


                $result = $this->country_model->getCountries(trim(strtoupper($lga[2])));
                $formalStateData = $this->state_model->getState(trim(strtoupper($lga[0])));
                $lgaReult = $this->lga_model->getLgaByName(trim(strtolower($lga[1])));


                if (empty($result)) {
                    $error = TRUE;
                    $errorDetails = "Country code : " . $lga[2] . " does not exist in the database";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }

                if (sizeof($lgaReult) > 0) {
                    $error = TRUE;
                    $errorDetails = "Lga name : " . $lga[1] . " already exists";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }

                if (empty($formalStateData)) {
                    $error = TRUE;
                    $errorDetails = "State code : " . $lga[0] . " does not exist in the database";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }


            }
            $counter++;
        }

        if ($error) {
            //echo $returnArray['error']['details'];
        } else {
            $counter = 0;
            //if no errors then commit to database
            foreach ($lgadata as $lga) {
                if ($counter != 0) {
                    $this->lga_model->set_lga_excel($lga[1], $lga[0], $lga[2]);
                }

                $counter++;
            }
        }

        $returnArray['error'] = $error;
        $returnArray['details'] = $errorDetails;


        return $returnArray;


    }

    private function nextOfKinArray($patient_no, $patient)

    {
        $output['patient_number'] = $patient_no;

        $patient['kin_name'] = trim(strtolower($patient[29]));

        $splitname = preg_split('[ ]', $patient['kin_name']);

        if (sizeof($splitname) == 3) {
            $output['first_name'] = $splitname[0];
            $output['middle_name'] = $splitname[1];
            $output['last_name'] = $splitname[2];
        } else if (sizeof($splitname) == 2) {
            $output['first_name'] = $splitname[0];
            $output['last_name'] = $splitname[1];
        } else {
            $output['first_name'] = $splitname[0];
        }

        $patient['kin_relationship'] = trim(strtolower($patient[32]));

        if (!isset($patient['kin_relationship']) || $patient['kin_relationship'] = "") {
            return null;
        }
        $relationship = $this->relationship_model->getRelationshipByName($patient['kin_relationship']);


        $output['relationship_id'] = $relationship['relationship_id'];

        $patient['kin_mobile'] = trim(strtolower($patient[30]));

        $output['mobile_number'] = $patient['kin_mobile'];

        $patient['kin_address'] = trim(strtolower($patient[31]));

        $output['address_line_1'] = $patient['kin_address'];


        return $output;


    }

    private function patientArray($patient)
    {
        /**
         *`patient_master_table`(`patient_number`, `first_name`, `last_name`, `middle_name`,
         *`dob`, `legacy_file_number`, `occupation_id`, `religion_id`,
         *`marital_status`, `state_of_origin`, `orign_country_code`, `origin_lga_id`,
         *`mobile_number`, `cell_number`, `email`, `alt_email`, `address_line_1`, `address_line_2`,
         *`address_state_code`, `address_lga_id`, `address_country_code`, `patient_type_code`, `date_created`,
         *`date_modified`, `status`, `legacy_date_opened`, `hmo_code`, `sex`, `height`, `hmo_enrolee_id`,
         *`blood_group_id`, `phenotype_id`, `created_by`, `modified_by`, `allergies`, `admission_status`
         */

        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $year = date_format($date, 'Y');


        $output['hmo_code'] = NULL;

        if (trim($patient[33]) != "") {
            $output['hmo_code'] = trim($patient[33]);
        }


        $counters = $this->file_counter_model->getCounters();
        $output['patient_type_code'] = trim($patient[36]);
        $output['patient_number'] = $year;
        if (strtolower($output['patient_type_code']) != "h") {
            $output['patient_number'] = $output['patient_number'] . strtoupper($output['patient_type_code']);
        } else {
            $output['patient_number'] = $output['patient_number'] . strtoupper($output['hmo_code']);
        }


        if (strtolower($output['patient_type_code']) == "h") {
            $output['patient_number'] = $output['patient_number'] . ($counters['hmo'] + 1);
        } else if (strtolower($output['patient_type_code']) == "f" || strtolower($output['patient_type_code']) == "d") {
            $output['patient_number'] = $output['patient_number'] . ($counters['family'] + 1);
        } else {
            $output['patient_number'] = $output['patient_number'] . ($counters['standard'] + 1);
        }

        /**
         * if(strtolower($output['patient_type_code']) == "s" || strtolower($output['patient_type_code']) == "f" || strtolower($output['patient_type_code']) == "d")
         * {
         * $output['patient_number'] = $year.strtoupper($output['patient_type_code']);
         *
         * }
         **/


        $output['first_name'] = trim($patient[3]);
        $output['middle_name'] = trim($patient[2]);
        $output['last_name'] = trim($patient[1]);
        $output['legacy_file_number'] = trim($patient[4]);
        $output['sex'] = trim($patient[5]);
        $dobsplit = preg_split('[/]', trim($patient[6]));
        $output['dob'] = $dobsplit[2] . "-" . $dobsplit[1] . "-" . $dobsplit[0];
        $output['height'] = trim($patient[8]);
        $output['weight'] = trim($patient[9]);
        $output['allergies'] = trim($patient[13]);
        $output['marital_status'] = trim($patient[14]);
        $output['email'] = trim($patient[18]);
        $output['mobile_number'] = trim($patient[19]);
        $output['cell_number'] = trim($patient[20]);
        $output['address_line_1'] = trim($patient[24]);
        $output['address_line_2'] = trim($patient[25]) . " " . trim($patient[26]);

        $output['hmo_enrolee_id'] = trim($patient[34]);
        if ($output['hmo_enrolee_id'] == "") {
            $output['hmo_enrolee_id'] = NULL;
        }

        $output['admission_status'] = trim($patient[35]);
        $output['status'] = "A";
        $output['principal_number'] = NULL;

        if (trim($patient[37]) != "") {
            $output['principal_number'] = trim($patient[37]);
        }

        $output['hmo_code'] = NULL;

        if (trim($patient[33]) != "") {
            $output['hmo_code'] = trim($patient[33]);
        }

        $output['blood_group_id'] = NULL;

        if (trim($patient[10]) != "") {
            $blood_groupdb = $this->bloodgrp_model->getBloodgrpByCode(trim($patient[10]));
            $output['blood_group_id'] = $blood_groupdb['blood_group_id'];
        }

        $output['phenotype_id'] = NULL;

        if (trim($patient[11]) != "") {
            $genotypedb = $this->phenotype_model->getPhenotypeByCode(trim($patient[11]));
            $output['phenotype_id'] = $genotypedb['phenotype_id'];
        }

        $output['religion_id'] = NULL;

        if (trim($patient[7]) != "") {
            $religion = trim($patient[7]);
            $religionindb = $this->religion_model->getReligionByName(strtolower($religion));
            $output['religion_id'] = $religionindb['religion_id'];
        }

        $output['occupation_id'] = NULL;

        if (trim($patient[12]) != "") {
            $occupation = trim($patient[12]);
            $occupationdb = $this->occupation_model->getOccupationByName($occupation);
            $output['occupation_id'] = $occupationdb['occupation_id'];
        }

        $output['origin_lga_id'] = NULL;

        if (trim($patient[15]) != "") {
            $lga = trim($patient[15]);
            $lgadb = $this->lga_model->getLgaByName($lga);
            $output['origin_lga_id'] = $lgadb['lga_id'];
        }

        $output['state_of_origin'] = NULL;

        if (trim($patient[16]) != "") {
            $originstate = trim($patient[16]);
            $originstatedb = $this->state_model->getStateByName($originstate);
            $output['state_of_origin'] = $originstatedb['state_code'];
        }

        $output['orign_country_code'] = NULL;

        if (trim($patient[17]) != "") {
            $origincountry = trim($patient[17]);
            $origincountrydb = $this->country_model->getCountryByName($origincountry);

            $output['orign_country_code'] = $origincountrydb['country_code'];
        }

        $output['address_state_code'] = NULL;

        if (trim($patient[27]) != "") {
            $addystate = trim($patient[27]);
            $addystatedb = $this->state_model->getStateByName($addystate);
            $output['address_state_code'] = $addystatedb['state_code'];
        }

        $output['address_country_code'] = NULL;

        if (trim($patient[28]) != "") {
            $addycountry = trim($patient[28]);
            $addycountrydb = $this->country_model->getCountryByName($addycountry);

            $output['address_country_code'] = $addycountrydb['country_code'];
        }


        /**
         *
         *
         *
         *
         *
         * $patient['kin_name'] = trim($patient[29]);
         * $patient['kin_mobile'] = trim($patient[30]);
         * $patient['kin_address'] = trim($patient[31]);
         * $patient['kin_relationship'] = trim($patient[32]);
         **/


        return $output;

    }

    /**
     *
     *function to upload patients to the database from the formatted excel
     *
     */
    private function uploadPatients($patientdata)
    {
        $returnArray['error'] = FALSE;
        $returnArray['error']['details'] = "";

        //validate country data
        $error = FALSE;
        $errorDetails = "";

        $counter = 0;
        foreach ($patientdata as $patient) {
            /**
             * if(sizeof($provider) != 8)
             * {
             * $error = TRUE;
             * $errorDetails = "invalid Excel sheet, please use the template as a guide";
             * $returnArray['error']['details'] = $errorDetails;
             * break;
             * }
             **/
            if ($counter != 0) {


                $first_name = trim($patient[3]);
                $middle_name = trim($patient[2]);
                $last_name = trim($patient[1]);
                $old_cardnumber = trim($patient[4]);
                $sex = trim($patient[5]);
                $dob = trim($patient[6]);
                $religion = trim($patient[7]);
                $height = trim($patient[8]);
                $weight = trim($patient[9]);
                $blood_group = trim($patient[10]);
                $genotype = trim($patient[11]);
                $occupation = trim($patient[12]);
                $allergies = trim($patient[13]);
                $maritalstatus = trim($patient[14]);
                $lga = trim($patient[15]);
                $originstate = trim($patient[16]);
                $origincountry = trim($patient[17]);
                $email = trim($patient[18]);
                $mobile1 = trim($patient[19]);
                $mobile2 = trim($patient[20]);
                $homephone = trim($patient[21]);
                $zipcode = trim($patient[22]);
                $website = trim($patient[23]);
                $addressline1 = trim($patient[24]);
                $addressline2 = trim($patient[25]);
                $city = trim($patient[26]);
                $address_state = trim($patient[27]);
                $address_country = trim($patient[28]);
                $kin_name = trim($patient[29]);
                $kin_mobile = trim($patient[30]);
                $kin_address = trim($patient[31]);
                $kin_relationship = trim($patient[32]);
                $hmo = trim($patient[33]);
                $hmo_enrollee_id = trim($patient[34]);
                $admission_status = trim($patient[35]);
                $patient_type = trim($patient[36]);
                $principal_number = trim($patient[37]);


                if ($first_name == "" || $last_name == "") {
                    $error = TRUE;
                    $errorDetails = "Excel sheet Invalid, all patient first names and last names must be provided. ";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }
                /**
                 *
                 *
                 * //validate the old card number

                 */
                if ($old_cardnumber == "") {
                    $error = TRUE;
                    $errorDetails = "Excel sheet Invalid, card number not present at record number " . $counter;
                    $returnArray['error']['details'] = $errorDetails;
                    ////echo $returnArray['error']['details'];

                    break;
                }

                //confirm card number not already uploaded

                $patientrecord = $this->patient_model->getPatientByOldNumber($old_cardnumber);

                if (sizeof($patientrecord) > 0) {
                    $error = TRUE;
                    $errorDetails = "Patient with the card number " . $old_cardnumber . " already exists";
                    $returnArray['error']['details'] = $errorDetails;
                    ////echo $returnArray['error']['details'];

                    break;
                }

                //validate the sex
                if (strlen($sex) > 1 || (strtoupper($sex) != "M" && strtoupper($sex) != "H" && strtoupper($sex) != "F" && strtoupper($sex) != "")) {
                    $error = TRUE;
                    $errorDetails = "Invalid sex for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    ////echo $returnArray['error']['details'];

                    break;
                }

                /********************************************************************************************************************************************
                 **************************************************************Begining of date of birth validation******************************************
                 *********************************************************************************************************************************************/

                if ($dob == '') {
                    $dob = "01/01/1800";
                } else {
                    //validate the date of birth
                    $dob_split = preg_split('[/]', $dob);

                    if (sizeof($dob_split) != 3) {
                        $error = TRUE;
                        $errorDetails = "Invalid date of birth for card number " . $old_cardnumber . ".";
                        $returnArray['error']['details'] = $errorDetails;
                        //echo $returnArray['error']['details'];

                        break;
                    }
                    if ($dob_split[0] < 1 || $dob_split[0] > 31) {
                        $error = TRUE;
                        $errorDetails = "Invalid date of birth for card number " . $old_cardnumber . ".";
                        $returnArray['error']['details'] = $errorDetails;
                        //echo $returnArray['error']['details'];

                        break;
                    }
                    if ($dob_split[1] < 1 || $dob_split[1] > 12) {
                        $error = TRUE;
                        $errorDetails = "Invalid date of birth for card number " . $old_cardnumber . ".";
                        $returnArray['error']['details'] = $errorDetails;
                        //echo $returnArray['error']['details'];

                        break;
                    }
                    //if month is equal to feburary and day is greater that 29 throw invalid date
                    if ($dob_split[1] == 2 && $dob_split[0] > 29) {
                        $error = TRUE;
                        $errorDetails = "Invalid date of birth for card number " . $old_cardnumber . ".";
                        $returnArray['error']['details'] = $errorDetails;
                        //echo $returnArray['error']['details'];

                        break;
                    }
                    //6 4 11 9
                    //if month is eaual to septmeber april june november and greater than 30 days
                    if (($dob_split[1] == 6 || $dob_split[1] == 4 || $dob_split[1] == 11 || $dob_split[1] == 9) && $dob_split[0] > 30) {
                        $error = TRUE;
                        $errorDetails = "Invalid date of birth for card number " . $old_cardnumber . ".";
                        $returnArray['error']['details'] = $errorDetails;
                        //echo $returnArray['error']['details'];

                        break;
                    }
                    if (strlen($dob_split[2]) != 4) {
                        $error = TRUE;
                        $errorDetails = "Invalid date of birth for card number " . $old_cardnumber . ".";
                        $returnArray['error']['details'] = $errorDetails;
                        //echo $returnArray['error']['details'];

                        break;
                    }
                }

                /********************************************************************************************************************************************
                 **************************************************************end of date of birth validation ***********************************************
                 *********************************************************************************************************************************************/
                /********************************************************************************************************************************************
                 **************************************************************begin religion validation *****************************************************
                 *********************************************************************************************************************************************/


                $religionindb = $this->religion_model->getReligionByName(strtolower($religion));

                if (empty($religionindb)) {
                    $error = TRUE;
                    $errorDetails = "Invalid religion: " . $religion . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    ////echo $returnArray['error']['details'];

                    break;
                }

                /********************************************************************************************************************************************
                 **************************************************************begin blood group validation *****************************************************
                 *********************************************************************************************************************************************/

                $blood_groupdb = $this->bloodgrp_model->getBloodgrpByCode($blood_group);

                if ($blood_group != "" && empty($blood_groupdb)) {
                    $error = TRUE;
                    $errorDetails = "Invalid Bloodgroup: " . $blood_group . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }
                /********************************************************************************************************************************************
                 **************************************************************begin relationship validation *****************************************************
                 *********************************************************************************************************************************************/


                if ($kin_relationship != "") {
                    $relationship_chk = $this->relationship_model->getRelationshipByName($kin_relationship);

                    if ($relationship_chk != "" && empty($relationship_chk)) {
                        $error = TRUE;
                        $errorDetails = "Invalid Relationship: " . $kin_relationship . " for card number " . $old_cardnumber . ".";
                        $returnArray['error']['details'] = $errorDetails;
                        //echo $returnArray['error']['details'];

                        break;
                    }

                    if ($kin_name == "") {
                        $error = TRUE;
                        $errorDetails = "Kin Name cannot be empty  for card number " . $old_cardnumber . ".";
                        $returnArray['error']['details'] = $errorDetails;
                        //echo $returnArray['error']['details'];

                        break;
                    }
                }


                $genotypedb = $this->phenotype_model->getPhenotypeByCode($genotype);

                if ($genotype != "" && empty($genotypedb)) {
                    $error = TRUE;
                    $errorDetails = "Invalid Phenotype: " . $genotype . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }

                $occupationdb = $this->occupation_model->getOccupationByName($occupation);

                if ($occupation != "" && empty($occupationdb)) {
                    $error = TRUE;
                    $errorDetails = "Invalid Occupation: " . $occupation . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;

                }

                if ($maritalstatus != "" && ($maritalstatus != "S" && $maritalstatus != "M" && $maritalstatus != "W")) {
                    $error = TRUE;
                    $errorDetails = "Invalid Marital status: " . $maritalstatus . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }
                if ($patient_type == "" || ($patient_type != "H" && $patient_type != "F" && $patient_type != "S" && $patient_type != "D")) {
                    $error = TRUE;
                    $errorDetails = "Invalid Patient Type: " . $patient_type . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }

                if ($admission_status != "" && ($admission_status != "A" && $admission_status != "D")) {
                    $error = TRUE;
                    $errorDetails = "Invalid Admission status: " . $admission_status . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }

                $lgadb = $this->lga_model->getLgaByName($lga);
                if (empty($lgadb) && $lga != "") {

                    $error = TRUE;
                    $errorDetails = "Invalid Local Govermnment: " . $lga . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }
                $originstatedb = $this->state_model->getStateByName($originstate);

                if (empty($originstatedb) && $originstate != "") {
                    $error = TRUE;
                    $errorDetails = "Invalid State of Origin: " . $originstate . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }

                $origincountrydb = $this->country_model->getCountryByName($origincountry);

                if (empty($origincountrydb) && $origincountry != "") {
                    $error = TRUE;
                    $errorDetails = "Invalid Country Of Origin : " . $origincountry . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }

                $address_statedb = $this->state_model->getStateByName($address_state);

                if (empty($address_statedb) && $address_state != "") {
                    $error = TRUE;
                    $errorDetails = "Invalid Address State: " . $address_state . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;

                }

                $address_countrydb = $this->country_model->getCountryByName($address_country);

                if (empty($address_countrydb) && $address_country != "") {
                    $error = TRUE;
                    $errorDetails = "Invalid Address Country : " . $address_country . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }

                $kin_relationshipdb = $this->relationship_model->getRelationshipByName($kin_relationship);

                if (empty($kin_relationshipdb) && $kin_relationship != "") {
                    $error = TRUE;
                    $errorDetails = "Invalid Kin Relationship : " . $kin_relationship . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }

                if ($patient_type == "H" && $hmo == "") {
                    $error = TRUE;
                    $errorDetails = "Hmo code cannot be empty" . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }

                if ($patient_type == "D" && $principal_number == "") {
                    $error = TRUE;
                    $errorDetails = "Must specify a principal" . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }

                if ($patient_type == "D") {
                    $principal_numberdb = $this->patient_model->getPatientByOldNumber($principal_number);

                    if (empty($principal_numberdb)) {
                        $error = TRUE;
                        $errorDetails = "Principal does not exist" . " for card number " . $old_cardnumber . ".";
                        $returnArray['error']['details'] = $errorDetails;
                        //echo $returnArray['error']['details'];

                        break;
                    }

                }


                $hmodb = $this->hmo_model->getHmo($hmo);

                if (empty($hmodb) && $hmo != "" && $patient_type == "H") {
                    $error = TRUE;
                    $errorDetails = "Invalid HMO Code : " . $hmo . " for card number " . $old_cardnumber . ".";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }


                if ($hmo != "" && $patient_type == "H") {
                    if ($hmo_enrollee_id == "") {
                        $error = TRUE;
                        $errorDetails = "enrolee id can not be empty: " . $hmo . " for card number " . $old_cardnumber . ".";
                        $returnArray['error']['details'] = $errorDetails;
                        //echo $returnArray['error']['details'];

                        break;

                    }
                    $enroleedb = $this->patient_model->getPatientByEnroleeId($hmo_enrollee_id, $hmo);

                    if (sizeof($enroleedb) > 0) {
                        $error = TRUE;
                        $errorDetails = "enrolee id : " . $hmo_enrollee_id . " already exists, specified in card number " . $old_cardnumber . ".";
                        $returnArray['error']['details'] = $errorDetails;
                        //echo $returnArray['error']['details'];

                        break;

                    }
                }


            }
            $counter++;
        }


        if ($error) {
            //echo $returnArray['error']['details'];
        } else {
            $counter = 0;
            //if no errors then commit to database
            foreach ($patientdata as $p) {
                if ($counter != 0) {

                    $data = $this->patientArray($p);

                    $nextOfKin = $this->nextOfKinArray($data['patient_number'], $p);

                    $this->patient_model->set_patient_excel($data);

                    if (isset($nextOfKin)) {
                        $this->next_of_kin_model->set_nextofkin($nextOfKin);
                    }


                    $patient_type = $data['patient_type_code'];

                    $current_counters = $this->file_counter_model->getCounters();
                    //updateStandardCounter updateHmoCounter updateFamilyCounter
                    if (strtolower($patient_type) == "h") {
                        $this->file_counter_model->updateHmoCounter($current_counters['hmo'] + 1);
                    } else if (strtolower($patient_type) == "s") {
                        $this->file_counter_model->updateStandardCounter($current_counters['standard'] + 1);
                    } else if (strtolower($patient_type) == "f" || strtolower($patient_type) == "d") {
                        $this->file_counter_model->updateFamilyCounter($current_counters['family'] + 1);
                    }

                }

                $counter++;
            }
        }

        $returnArray['error'] = $error;
        $returnArray['details'] = $errorDetails;


        return $returnArray;


    }

    /**
     *
     *function to upload the hmo base data into the system
     *
     */

    private function uploadProvider($providerdata)
    {
        $returnArray['error'] = FALSE;
        $returnArray['error']['details'] = "";

        //validate country data
        $error = FALSE;
        $errorDetails = "";

        $counter = 0;
        foreach ($providerdata as $provider) {
            if (sizeof($provider) != 8) {
                $error = TRUE;
                $errorDetails = "invalid Excel sheet, please use the template as a guide";
                $returnArray['error']['details'] = $errorDetails;
                break;
            }
            if ($counter != 0) {


                $result = $this->country_model->getCountries(trim(strtoupper($provider[4])));
                $formalStateData = $this->state_model->getState(trim(strtoupper($provider[3])));
                $hmodata = $this->hmo_model->getHmo(trim(strtoupper($provider[7])));


                if (empty($result)) {
                    $error = TRUE;
                    $errorDetails = "Country code : " . $provider[4] . " does not exist in the database";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }

                if (sizeof($hmodata) > 0) {
                    $error = TRUE;
                    $errorDetails = "HMO Code : " . $provider[7] . " already exists";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }

                if (empty($formalStateData)) {
                    $error = TRUE;
                    $errorDetails = "State code : " . $provider[3] . " does not exist in the database";
                    $returnArray['error']['details'] = $errorDetails;
                    //echo $returnArray['error']['details'];

                    break;
                }


            }
            $counter++;
        }

        if ($error) {
            echo $returnArray['error']['details'];
        } else {
            $counter = 0;
            //if no errors then commit to database
            foreach ($providerdata as $provider) {
                if ($counter != 0) {
                    $this->hmo_model->set_Hmo_Excel($provider[0], $provider[1], $provider[2],
                        $provider[3], $provider[4], $provider[5], $provider[6], $provider[7]);
                }

                $counter++;
            }
        }

        $returnArray['error'] = $error;
        $returnArray['details'] = $errorDetails;


        return $returnArray;


    }


}