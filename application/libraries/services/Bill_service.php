<?php

/**
 * Created by PhpStorm.
 * User: dusty
 * Date: 10/10/16
 * Time: 10:13 AM
 */
class Bill_service{

    private $medstation;

    /**
     * PatientService constructor.
     */
    public function __construct()
    {
        $this->medstation =& get_instance();
        $this->medstation->load->database();
        $this->medstation->load->model('patient_model');
        $this->medstation->load->model('bills_model');
        $this->medstation->load->model('partial_payments_model');
        $this->medstation->load->model('bill_master_model');
        $this->medstation->load->model('drug_price_master_model');
        $this->medstation->load->model('pharmacy_stock_model');
        $this->medstation->load->model('drug_bill_form_model');
        $this->medstation->load->model('drug_stock_rules_model');
        $this->medstation->load->model('general_update_model');
        $this->medstation->load->model('patient_deposit_model');
        $this->medstation->load->model('hmo_bills_model');
        $this->medstation->load->model('hmo_bills_to_post_model');
        $this->medstation->load->model('patient_hmo_bill_offset_model');
		$this->medstation->load->model('Payment_mode_model');
		
        $this->medstation->load->helper('date');

        //patient_deposit_model
    }


    public function getHmoBillBreakDown($hmoPaymentRef){

        $response = array("bills"=>array(), "patientOffsets" => array());


        log_message("debug", "about to get the full breakdown of the hmo bill $hmoPaymentRef");
        $hmoBill = $this->medstation->hmo_bills_model->getHmoBillByRef($hmoPaymentRef);

        log_message("debug", "hmo bill found is ".json_encode($hmoBill));
        $offsets = array();


        if(isset($hmoBill)){

           $billsByPatient =
               $this->medstation->hmo_bills_to_post_model->getHmoBillsByPaymentRef($hmoBill["reference_id"]);

            $counter = 0;
            $offsetCounter = 0;

            if(isset($billsByPatient)){

                log_message("debug", "found bills, will proceed to get individual definitions");
                foreach ($billsByPatient as $patientBill){

                    $patientBillItems = $this->getBillBreakDown($patientBill["reference_id"]);
                    log_message("debug", "checking if patient has made any offsets ". $patientBill["reference_id"]);
                    $foundOffSet = $this->medstation->patient_hmo_bill_offset_model->findPatientOffsetByReference($patientBill["reference_id"]);

                    if(isset($foundOffSet) && $foundOffSet != ""){

                        log_message("debug", "found the offset " .json_encode($foundOffSet));
                        $foundOffSet["patient"] = $this->medstation->patient_model->getPatient($foundOffSet['patient_number']);
                        $response["patientOffsets"][$offsetCounter] = $foundOffSet;
                        $offsetCounter++;
                    }

                    foreach($patientBillItems as $item){

                        $response["bills"][$counter] = $item;
                        $counter ++;
                    }

                    log_message("debug", "finished adding bills for patient ". $patientBill["patient_number"]);


                }
            }

        }


        return $response;
    }


    public function getBillBreakDown($reference){


        log_message("debug", "about to get bill breakdown reference $reference");

        $bills = $this->medstation->bills_model->getBillByReference($reference);

        log_message("debug","found the following bills " . json_encode($bills));


        if(isset($bills)){

            $counter = 0;

            foreach($bills as $bill){

                log_message("debug", "find the patient record for the patient id " . $bill['patient_number']);
                $patient = $this->medstation->patient_model->getPatient($bill['patient_number']);


                $bills[$counter]["patient"] = $patient;
                $counter ++;
            }
        }




        return $bills;
    }


    public function postBill($patientNumber, $postedBills, $partialPaymentFlag, $partialPreviouslyRecieved,
                                 $partialPaymentRef, $partialAmount, $patientTypeCode, $offsetFromDepositFlag, $hmoSplitFlag,
                                    $hmo_patient_split_amount, $paymentMode, $paymentReference, $paymentModeInvoice)
    {

        log_message("info", "about to post a bill ");

        $result = array("status"=>false, "description"=> "");

        //if partial payment and a walk in customer, not supported
        if($patientNumber == NON_CUSTOMER_ID && $partialPaymentFlag == 'Y'){

            $result["description"] = "Partial Payment not supported for walk in customer";
            return $result;
        }

        log_message("debug", "finished verifying walk in customer against partial ");

        //get all the selected bills ids
        $selectedBills = $postedBills;

        $isSecurityDeposit = false;

        //check to make sure it is not a security bill
        if(sizeof($selectedBills) == 1){
            $master = $this->medstation->bills_model->getBill($selectedBills[0]);
            if(strtolower($master["service_name"]) == "deposit"){
                $isSecurityDeposit = true;
            }
        }

        log_message("debug", "after deposit check ");

        //check to make sure partial bill and security deposit are not selected at the same time
        if($partialPaymentFlag == 'Y' && $isSecurityDeposit){

            log_message("error", "partial deposit not allowed for a security deposit ");
            $result["description"] = "Partial deposit not allowed for a security deposit";
            return $result;
        }

        if (null == $postedBills) {

            log_message("error", "no bill item was selected");
            $result["description"] = "No Bill Item was selected";
            return $result;

            //finishing leg for parial payments previously received
        } else if ($partialPreviouslyRecieved == 'Y') {

            $bills = $postedBills;
            log_message("debug", "partial payment leg entered");

            //TODO: adjust to handle edited bills

            $original_bill_amount = 0;
            foreach ($bills as $bill) {
                $bill_item = $this->medstation->bills_model->getBill($bill);
                $original_bill_amount = $original_bill_amount + ($bill_item['unit_price'] * $bill_item['qty']);
            }

            //if it is yet another partial payment
            if ($partialPaymentFlag == "Y") {
                $this->medstation->partial_payments_model->set_partial_payment($patientNumber,
                    $partialPaymentRef,
                    $partialAmount,
                    $original_bill_amount);

                log_message("debug", "partial payment posted successfully");
				
				if($paymentModeInvoice){

                    log_message("debug", "adding payment method to posting");

                    $this->medstation->Payment_mode_model->set_posted_payment_mode($patientNumber,
                    $partialPaymentRef,
                    $partialAmount,
                    $original_bill_amount,
					$paymentModeInvoice);
					
                }else{

                    log_message("debug", "patient payment method could not be added");

                }
				
				if($offsetFromDepositFlag == 'Y' ){

						log_message("debug", "offseting amount in the deposit model");
						$deposit = $this->medstation->patient_deposit_model->
											getLatestDepositByPatientNumber($patientNumber);
						
						$this->medstation->patient_deposit_model->updatePatientDepositRecord($deposit["patient_deposit_id"],
							"D",$partialAmount,
							$reference);
					}

                $result["status"] = true;
                $result["description"] = "partial payment posted successfully";
                return $result;
            }
            //if it is finally a full payment, close partial payments
            else {

                log_message("debug", "final leg of the partial payment");

                $this->medstation->bills_model->postPartialPaymentCompletely($bills,
                    $partialPaymentRef,
                    $patientNumber,
                    $original_bill_amount,
                    $partialAmount);

				if($paymentModeInvoice){

                    log_message("debug", "adding payment method to posting");

                    $this->medstation->Payment_mode_model->set_posted_payment_mode($patientNumber,
                    $partialPaymentRef,
                    $partialAmount,
                    $original_bill_amount,
					$paymentModeInvoice);
					
                }else{

                    log_message("debug", "patient payment method could not be added");

                }
				
				 //if amount was offset from the current deposit

				 //$partialAmount=40000;
					if($offsetFromDepositFlag == 'Y' ){

						log_message("debug", "offseting amount in the deposit model");
						$deposit = $this->medstation->patient_deposit_model->
											getLatestDepositByPatientNumber($patientNumber);
						
						$this->medstation->patient_deposit_model->updatePatientDepositRecord($deposit["patient_deposit_id"],
							"D",$partialAmount,
							$reference);
					}


                $result["description"] = "full partial payment successfully posted";
                $result["status"] = true;
                return $result;
            }

        } else{
            //refractor start, neglecting partial payments and security deposits
            if ($patientNumber != NON_CUSTOMER_ID) {

                log_message("debug", "patient is a full customer,not a walk in patient");
                //why am i doing this
                $reference = $patientNumber . now();
            }

            log_message("debug", "about to begin bill verification");

            $formalReference = "";

            $patient_type_code = $patientTypeCode;
            $patient_number = $patientNumber;
            $bills = $postedBills;
            $amount = 0;
            $StockUpdateArray = null;
            $stockArrayCounter = 0;

            $isInStock = true;
            $dispenseData = null;
            $last_drug_id = "";
            $currentStock = 0;


            $validationErrorMessage = "";

            log_message("debug", "about to validating all bills ");
            //for each of the selected bill items, to be posted
            foreach ($bills as $bill) {

                //get the generated bill from the bills table, will hold specific information like qty and selling_price
                $bill_item = $this->medstation->bills_model->getBill($bill);

                //find the formal reference from the stored data
                $formalReference = $bill_item["reference_id"];

                //TODO:: I am not sure why i set a new reference
                //TODO :: set reference to the formal reference, test for redundancy later
                $reference = $formalReference;

                if ($patientNumber == NON_CUSTOMER_ID) {
                    $reference = $formalReference;
                }

                log_message("debug", "getting bill master record");
                //find the bill original master item that has the bill definitions
                $bill_master = $this->medstation->bill_master_model->getBill($bill_item['bill_id']);


                $dispenseData[$bill]['dispense_needed'] = null;

                //if it is a drug and has not yet been dispensed, if it has been dispensed status will be D
                if (isset($bill_master['drug_price_id']) && $bill_master['drug_price_id'] != ""
                    && (!isset($bill_item["dispense_needed"]) || $bill_item["dispense_needed"] != "D")) {
                    $dispenseData[$bill]['dispense_needed'] = "Y";

                    log_message("debug","found a drug, getting the current drug master record");
                    //find the price master record of the drug
                    $drug_price_master = $this->medstation->drug_price_master_model->getDrugPriceMaster($bill_master['drug_price_id']);

                    log_message("debug","find the drug stock");
                    //get the current number in stock
                    $pharmacy_stock = $this->medstation->pharmacy_stock_model->getOneStockBatch($drug_price_master['drug_id']);

                    log_message("debug","getting the drug batches");
                    //get all active batches of the drug
                    $pharmacy_all_active_batches = $this->medstation->pharmacy_stock_model->getActiveStock($drug_price_master['drug_id']);

                    $total_number_in_stock = 0;

                    //aggregate all the stocks to get the total available stock
                    foreach ($pharmacy_all_active_batches as $batch) {

                        $total_number_in_stock = $total_number_in_stock + $batch['qty_in_stock'];
                    }

                    //if a valid stock was not found
                    if (!$pharmacy_stock || sizeof($pharmacy_stock) < 2 || $total_number_in_stock < 1) {

                        $isInStock = false;
                        $validationErrorMessage = $bill_master['service_name'] . " is not in stock. ";
                        break;
                    }


                    //validate stock
                    $package_id_to_dispense = $drug_price_master['drug_bill_package_id'];
                    $default_package_id = $pharmacy_stock['drug_bill_package_id'];

                    //get package information
                    $dispensePackageInfo = $this->medstation->drug_bill_form_model->getDrugBillForms($package_id_to_dispense);

                    if ($default_package_id == $package_id_to_dispense) {
                        if ($last_drug_id == $drug_price_master['drug_id']) {
                            $pharmacy_stock['qty_in_stock'] = $currentStock;
                        }

                        $last_drug_id == $drug_price_master['drug_id'];

                        //since its in the same package confirm stock before bill posting

                        if ($bill_item['qty'] > $total_number_in_stock) {
                            $isInStock = false;
                            $validationErrorMessage = $bill_master['service_name'] . " is not in stock. ";
                            break;

                        } else {
                            //if the random batch selected can handle it dispense from it
                            if ($bill_item['qty'] <= $pharmacy_stock['qty_in_stock']) {

                                //populate stock array update
                                $StockUpdateArray[$stockArrayCounter]['bill_id'] = $bill_item['id'];
                                $StockUpdateArray[$stockArrayCounter]['dispense_info'] = "Dispense from batch " . $pharmacy_stock['batch_no'];
                                $StockUpdateArray[$stockArrayCounter]['stock_id'] = $pharmacy_stock['stock_id'];
                                $currentStock = $pharmacy_stock['qty_in_stock'] - $bill_item['qty'];
                                $StockUpdateArray[$stockArrayCounter]['qty_to_reduce'] = $bill_item['qty'];
                                $StockUpdateArray[$stockArrayCounter]['drug_id'] = $drug_price_master['drug_id'];
                                $StockUpdateArray[$stockArrayCounter]['batch_no'] = $pharmacy_stock['batch_no'];
                                $stockArrayCounter++;

                            }

                            //if the batch cannot carry it, iterate through it until we get enough
                            else {

                                $leftToDispense = $bill_item['qty'];

                                foreach ($pharmacy_all_active_batches as $batch) {

                                    if ($leftToDispense < 1) {
                                        break;
                                    }

                                    $currentDispenseQty = 0;

                                    if ($leftToDispense > $batch['qty_in_stock']) {

                                        $currentDispenseQty = $batch['qty_in_stock'];
                                        $leftToDispense = $leftToDispense - $batch['qty_in_stock'];

                                    } else {

                                        $currentDispenseQty = $leftToDispense;
                                        $leftToDispense = 0;

                                    }

                                    //populate stock array update
                                    $StockUpdateArray[$stockArrayCounter]['bill_id'] = $bill_item['id'];
                                    $StockUpdateArray[$stockArrayCounter]['dispense_info'] = "Dispense " . $currentDispenseQty . " " . $dispensePackageInfo['name'] . "(s) from batch " . $batch['batch_no'];

                                    $StockUpdateArray[$stockArrayCounter]['stock_id'] = $pharmacy_stock['stock_id'];
                                    $currentStock = $batch['qty_in_stock'] - $currentDispenseQty;
                                    $StockUpdateArray[$stockArrayCounter]['qty_to_reduce'] = $currentDispenseQty;
                                    $StockUpdateArray[$stockArrayCounter]['drug_id'] = $drug_price_master['drug_id'];
                                    $StockUpdateArray[$stockArrayCounter]['batch_no'] = $batch['batch_no'];
                                    $stockArrayCounter++;

                                }
                            }

                        }

                    } else {
                        //this fix may not work i think this happens when panadol
                        // is twice in a list will have to stop that from happening
                        if ($last_drug_id == $drug_price_master['drug_id']) {
                            $pharmacy_stock['qty_in_stock'] = $currentStock;
                            log_message("debug", "finished running drug fix ");
                        }

                        $last_drug_id == $drug_price_master['drug_id'];


                        log_message("debug", "getting stock rules ");
                        //not in the same package get stock rules and calculate
                        $rules = $this->medstation->drug_stock_rules_model->getDrugStockRule($drug_price_master['drug_id']);

                        log_message("debug", "validating stock");
                        foreach ($rules as $rule) {
                            if ($rule['multiplied_package_id'] == $package_id_to_dispense) {
                                $calculatedNumberInStock = $rule['multiplier'] * $total_number_in_stock;


                                if ($bill_item['qty'] > $calculatedNumberInStock) {
                                    $isInStock = false;
                                    $validationErrorMessage =  $bill_master['service_name'] . " is not in stock. ";
                                    break;
                                } else {
                                    //if the random selected can take it
                                    if (($bill_item['qty'] / $rule['multiplier']) <= $pharmacy_stock['qty_in_stock']) {
                                        $StockUpdateArray[$stockArrayCounter]['bill_id'] = $bill_item['id'];
                                        $StockUpdateArray[$stockArrayCounter]['dispense_info'] = "Dispense " . $bill_item['qty'] . " " . $dispensePackageInfo['name'] . "(s) from batch " . $pharmacy_stock['batch_no'];
                                        $StockUpdateArray[$stockArrayCounter]['stock_id'] = $pharmacy_stock['stock_id'];
                                        $currentStock = $pharmacy_stock['qty_in_stock'] - ($bill_item['qty'] / $rule['multiplier']);
                                        $StockUpdateArray[$stockArrayCounter]['qty_to_reduce'] = $bill_item['qty'] / $rule['multiplier'];
                                        $StockUpdateArray[$stockArrayCounter]['drug_id'] = $drug_price_master['drug_id'];
                                        $StockUpdateArray[$stockArrayCounter]['batch_no'] = $pharmacy_stock['batch_no'];
                                        $stockArrayCounter++;
                                    } //if it can not take it
                                    else {


                                        $leftToDispense = $bill_item['qty'] / $rule['multiplier'];

                                        foreach ($pharmacy_all_active_batches as $batch) {

                                            if ($leftToDispense < 1) {
                                                break;
                                            }
                                            $currentDispenseQty = 0;

                                            if ($leftToDispense > $batch['qty_in_stock']) {

                                                $currentDispenseQty = $batch['qty_in_stock'];
                                                $leftToDispense = $leftToDispense - $batch['qty_in_stock'];

                                            } else {

                                                $currentDispenseQty = $leftToDispense;
                                                $leftToDispense = 0;

                                            }

                                            $StockUpdateArray[$stockArrayCounter]['bill_id'] = $bill_item['id'];
                                            $StockUpdateArray[$stockArrayCounter]['dispense_info'] = "Dispense " . $bill_item['qty'] . " " . $dispensePackageInfo['name'] . "(s) from batch " . $batch['batch_no'];

                                            //populate stock array update
                                            $StockUpdateArray[$stockArrayCounter]['stock_id'] = $pharmacy_stock['stock_id'];
                                            $currentStock = $batch['qty_in_stock'] - $currentDispenseQty;
                                            $StockUpdateArray[$stockArrayCounter]['qty_to_reduce'] = $currentDispenseQty;
                                            $StockUpdateArray[$stockArrayCounter]['drug_id'] = $drug_price_master['drug_id'];
                                            $StockUpdateArray[$stockArrayCounter]['batch_no'] = $batch['batch_no'];
                                            $stockArrayCounter++;

                                        }

                                        //end of cannot take it


                                    }
                                }

                                break;
                            }
                        }

                    }
                }

                //if there is a custom price use it
                log_message("debug", "custom price adjustment ");
                if(isset($bill_item['selling_price']) && $bill_item['selling_price'] != ""){

                    $amount = $amount + $bill_item['selling_price'];
                    log_message("debug", "using custom price, as a custom price was specified");

                }else{

                    //use the normal price as required
                    $amount = $amount + ($bill_item['unit_price'] * $bill_item['qty']);

                }

            }


            //check if the drug is not in stock then send the corresponding error
            if (!$isInStock) {
                log_message("error", "drug failed validation : $validationErrorMessage");
                $result["description"] = $validationErrorMessage;
                return $result;
            }

            if ($patient_type_code != "H") {

                log_message("debug", "not a hmo patient, checking if need be to create first parital payment or post ");
                if ($partialPaymentFlag == "Y") {
                    //partial payment logic here
                    log_message("debug", "creating partial payment");

                    $this->medstation->bills_model->createPartialPayment($bills, $reference, $patient_number, $amount, $dispenseData, $partialAmount);
					
					
					

                } else {
                    log_message("debug", "posting bill");
                    $this->medstation->bills_model->postBills($bills, $reference, $patient_number, $amount, $dispenseData);
                    $result["description"] = "bill posted successfully";
                    $result["status"] = true;
                }


            } else {

                log_message("debug", "about adding bill to hmo");

                $hmoAmountDue = $amount;
                log_message("debug","initial amount due is $amount");
               // createPatientOffset($offsetAmount, $patientNumber , $reference,  $createdBy)
                if($hmoSplitFlag == "Y"){

                    $hmoAmountDue = $amount - $hmo_patient_split_amount;
                    
                    $this->medstation->patient_hmo_bill_offset_model->createPatientOffset($hmo_patient_split_amount, 
                        $patientNumber , $reference);
						
					$this->medstation->Payment_mode_model->set_posted_payment_mode($patientNumber,
                    $reference,
                    $hmo_patient_split_amount,
                    $amount,
					$paymentModeInvoice);

                    log_message("debug", "split flag was requested so will calculate difference an send a record of user payment");
					
					
					
                }

                if($hmoAmountDue > 0){

                    log_message("debug", "adding bill to hmo");

                    $this->medstation->bills_model->addBillToHmo($bills, $reference, $patient_number, $hmoAmountDue, $dispenseData);
                }else{

                    log_message("debug", "patient covered full bill, hmo not bothered at all");

                }

                $result["description"] = "Sucessfully Added To Provider Bill";
                $result["status"] = true;
            }


            //update stock info after the payment, as a manadatory stock order has been given
            if ($StockUpdateArray) {

                log_message("debug", "about to updating stock ");
                foreach ($StockUpdateArray as $update) {
                    $pharmacy_stock = $this->medstation->pharmacy_stock_model->getStockByBatchNumber($update['drug_id'], $update['batch_no']);
                    $data['qty_in_stock'] = $pharmacy_stock['qty_in_stock'] - $update['qty_to_reduce'];

                    if ($data['qty_in_stock'] < 1) {
                        $data['status'] = "I";
                    }
                    $this->medstation->general_update_model->update("pharmacy_stock", "stock_id", $update['stock_id'], $data);

                    //update the dispense info to guide in dispensing
                    $bill_item = $this->medstation->bills_model->getBill($update['bill_id']);
                    $bill_data["additional_info"] = $bill_item['additional_info'] . " " . $update["dispense_info"];
                    $this->medstation->general_update_model->update("bills", "id", $update['bill_id'], $bill_data);

                }

                log_message("debug", "finished updating stock ");
            }

            //clear the data array to prepare for new posting
            $data = array();


            //fix: using old reference for order
            $data["reference_id"] = $reference;


            log_message("debug", "updating fix for lab orders ");
            $this->medstation->general_update_model->update("laboratory_test_orders", "reference_id", $formalReference, $data);

            //if it is a non customer update the status to paid
            if ($patientNumber == NON_CUSTOMER_ID) {

                log_message("debug", "non customer add record in non customer orders fix for lab");
                $updateData['status'] = "P";

                $this->medstation->general_update_model->update("non_customer_orders",
                    "reference_id",
                    $formalReference,
                    $updateData);

            }


            //if amount was offset from the current deposit
            if($offsetFromDepositFlag == 'Y' ){

                log_message("debug", "offseting amount in the deposit model");
                $deposit = $this->medstation->patient_deposit_model->
                                    getLatestDepositByPatientNumber($patientNumber);

                $this->medstation->patient_deposit_model->updatePatientDepositRecord($deposit["patient_deposit_id"],
                    "D",$partialAmount,
                    $reference);
            }

            //if it is a security deposit // do the last leg update the security deposit of the patient
            if($isSecurityDeposit){

                log_message("debug", "finishing security deposit leg ");
                $deposit = $this->medstation->patient_deposit_model->getLatestDepositByPatientNumber($patientNumber);


                if(isset($deposit) && sizeof($deposit) > 1){

                    //deposit exists update
                    $this->medstation->patient_deposit_model->updatePatientDepositRecord($deposit["patient_deposit_id"],
                        "C",
                        $partialAmount,
                        $reference);
                    log_message("debug", "updated previous deposit ");
                }else{

                    log_message("debug", "creating a new deposit ");
                    //doesn't exist create new deposit
                    $this->medstation->patient_deposit_model->createPatientDepositRecord($patient_number,
                        $partialAmount
                        , $reference);

                }
            }

            log_message("debug", "posting complete return success ");
			
			//$hmo_patient_split_amount
			//$partialAmount
			
			if(($paymentModeInvoice)&&($patient_type_code != "H")){

                    log_message("debug", "adding payment method to posting");

                    $this->medstation->Payment_mode_model->set_posted_payment_mode($patientNumber,
                    $reference,
                    $partialAmount,
                    $amount,
					$paymentModeInvoice);
					
                }else{

                    log_message("debug", "patient payment method could not be added");

                }

            //update, redirect to the printing page instead of searching for bill again
            $result["description"] = "Bill successfully posted";
            $result["status"] = true;
            return $result;

        }

    }


    
    public function getPatientCurrentBills($patientNumber){

        $patientBill["referenceId"] = "";
        $patientBill["patientNumber"] = $patientNumber;
        $patientBill["billCount"] = 0;
        $patientBill["bills"] = array();

        if(isset($patientNumber)){

            $currentBillRef = $this->medstation->bills_model->get_current_bill($patientNumber);

            log_message("debug", "current patient ref ". json_encode($currentBillRef));

            if (sizeof($currentBillRef) == 1) {

                $patientBill["referenceId"] = $currentBillRef['reference_id'];
                $currentBills = $this->medstation->bills_model->getBillByReference($patientBill["referenceId"]);
                log_message("debug", "current bills ". json_encode($currentBills));

              //  $patientBill["bills"] = $currentBills;
                $patientBill["billCount"] = sizeof($currentBills);

                $counter = 0;

                foreach ($currentBills as $item){

                    $patientBill["bills"][$counter]["id"] = $item["id"];
                    $patientBill["bills"][$counter]["description"] = $item["description"];
                    $patientBill["bills"][$counter]["serviceName"] = $item["service_name"];
                    $patientBill["bills"][$counter]["billDate"] = $item["date_created"];
                    $patientBill["bills"][$counter]["qty"] = $item["qty"];
    $patientBill["bills"][$counter]["thumbnail"] = 'http://images-its.chemistdirect.co.uk/Paracetamol-500mg-caplets-10456.jpg?o=wrwi2k9dA2Xo58Fh8cBcF$swYG8j&V=xCFy';
                    
                    $price = $item["unit_price"] * $item["qty"];

                    if(isset($item["selling_price"])){

                        $price = $item["selling_price"];
                    }

                    $patientBill["bills"][$counter]["price"] = $price;


                    $counter++;
                }

                return $patientBill;

            }

        }else{

            log_message("error", "invalid patient number");
            return $patientBill;
        }

        return $patientBill;
    }

}