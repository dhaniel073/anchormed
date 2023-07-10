<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
define ('MODULE_NO', 11);

define ('TITLE', 'Laboratory');

class Laboratory extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('passwordhash', array('iteration_count_log2' => 8, 'portable_hashes' => FALSE ));
		$this->load->model('ult');
		$this->load->model('staff_master_model');
		$this->load->model('profile_pics_model');
		$this->load->model('module_map_model');
		$this->load->model('role_model');
		$this->load->model('hmo_model');
		$this->load->model('department_model');
		$this->load->model('appointment_model');
		$this->load->model('daily_schedule_model');
		$this->load->model('patient_model');
		$this->load->model('omt_model');
		$this->load->model('sub_module_map_model');
		$this->load->model('laboratory_model');
		$this->load->model('laboratory_price_model');
		$this->load->model('bill_master_model');
		$this->load->model('patient_model');
		$this->load->model('lab_orders_model');
		$this->load->model('bills_model');
		$this->load->model('lab_results_model');
		$this->load->model('sample_type_model');
		$this->load->model('sample_model');
		$this->load->model('non_customer_order_model');
		$this->utilities->loadUserLang();
		
		
	}
	
	public function result($result_id)
	{
		$this->utilities->aunthenticateAccess(VIEW_PATIENT_LAB_RESULTS, "laboratory");
		
		if(!$result_id)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		
		$lab_result = $this->lab_results_model->getLabResult($result_id);
		
		if(!$lab_result)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$order = $this->lab_orders_model->getOrder($lab_result["order_id"]);
		
		if($lab_result["patient_number"] != NON_CUSTOMER_ID)
		{
			$patient  = $this->patient_model->getPatient($lab_result["patient_number"]);
		}
		else
		{
			$lab_order = $this->lab_orders_model->getOrder($lab_result['order_id']);
			$non_customer_order = $this->non_customer_order_model->getNonCustomerOrderByReference($lab_order["reference_id"]);
			
			$patient["patient_number"] = NON_CUSTOMER_ID;
			$patient["first_name"] = $non_customer_order["name"];
			$patient["last_name"] = "";
			$patient["middle_name"] = "";
		}
		$lab_result["test_info"] = $this->laboratory_model->getLab($order["lab_id"]);
			
		
		
		$data['lab_result'] = $lab_result;
		$data['patient'] = $patient;
		$data['title'] = "Medstation | Laboratory";
		$data['content-description'] = "View Result";
		//get all user module mappings by role
		$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
		$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
		
		$data['currentmodule']['number'] = MODULE_NO;
		$data['currentmodule']['title'] = TITLE;
		
		$page[0] = "laboratory/result";		
		$this->page->loadPage($page, $data, TRUE);
		
		
	}
	
	public function deleteSampleType()
	{
		
		$this->utilities->aunthenticateAccess(DELETE_SAMPLE_TYPE, "laboratory");
		
		if(!$this->input->post("sampletype"))
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		
		$sampletype = $this->sample_type_model->getSampleType($this->input->post("sampletype"));
		
		if(!$sampletype)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$data['status'] = "D";
		$this->general_update_model->update("sample_type_master",
						    "sample_type_id",
						    $this->input->post("sampletype"),
						    $data);
		
		$this->utilities->redirectWithNotice("laboratory", $this->lang->line(DELETE_SAMPLE_TYPE_SUCCESS));
	}
	
	public function updateTest()
	{
		$this->utilities->aunthenticateAccess(UPDATE_TEST_TYPE, "laboratory");
		
		
		if(!$this->input->post("lab") || !$this->input->post("description"))
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$labtest = $this->laboratory_model->getLab($this->input->post("lab"));
		
		if(!$labtest)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$data['description'] = $this->input->post("description");
		$this->general_update_model->update("lab_master",
						    "lab_id",
						    $this->input->post("lab"),
						    $data);
		
		$this->utilities->redirectWithNotice("laboratory", $this->lang->line(UPDATE_TEST_TYPE_SUCCESS));
		
	}
	public function updateSample()
	{
		$this->utilities->aunthenticateAccess(UPDATE_SAMPLE_TYPE, "laboratory");
		
		if(!$this->input->post("sampletype") || !$this->input->post("description"))
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$sampleType = $this->sample_type_model->getSampleType($this->input->post("sampletype"));
		
		if(!$sampleType)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		
		$data['description'] = $this->input->post("description");
		$this->general_update_model->update("sample_type_master",
						    "sample_type_id",
						    $this->input->post("sampletype"),
						    $data);
		
		$this->utilities->redirectWithNotice("laboratory", $this->lang->line(UPDATE_SAMPLE_TYPE_SUCCESS));
	}
	
	public function deleteTestType()
	{
		$this->utilities->aunthenticateAccess(DELETE_TEST, "laboratory");
		
		if(!$this->input->post("lab"))
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$labtest = $this->laboratory_model->getLab($this->input->post("lab"));
		
		if(!$labtest)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}

		
		$data['status'] = "D";
		$this->general_update_model->update("lab_master",
						    "lab_id",
						    $this->input->post("lab"),
						    $data);
		
		//get laboratory price
		$labprice = $this->laboratory_price_model->getPriceOfLabTest($this->input->post("lab"));
		if($labprice)
		{
			$this->general_update_model->update("lab_pricie_master",
						    "lab_price_id",
						    $labprice["lab_price_id"],
						    $data);
			
			
			//get bill master
		
				$this->general_update_model->update("bill_master",
						    "lab_price_id",
						    $labprice["lab_price_id"],
						    $data);
			
		}
		
		
		
		$this->utilities->redirectWithNotice("laboratory", $this->lang->line(DELETE_LAB_TYPE_SUCCESS));
		
	}
	
	public function getNonPatientCollectedSample($reference_id)
	{
		$this->utilities->aunthenticateAccess(RECORD_RESULTS, "laboratory");

		$non_customer_order = $this->non_customer_order_model->getNonCustomerOrderByReference(urldecode($reference_id));
		
		if(!$non_customer_order)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$orders = $this->lab_orders_model->getOrdersWithoutResultByReference($non_customer_order["reference_id"]);
		
		if(!$orders)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(NO_TESTS_NEED_PUBLISH_RESULT));
		}
		
		
		//get the samples for each orders found
		
		$counter = 0;
		foreach($orders as $order)
		{
			$orders[$counter]["sample"] = $this->sample_model->getSamplesByOrderId($order["order_id"]);
			$orders[$counter]["bill_info"]  = $this->bills_model->getBillByReference($order['reference_id']);
			$orders[$counter]["test_info"] = $this->laboratory_model->getLab($order["lab_id"]);
			$orders[$counter]["sample_type"] = $this->sample_type_model->getSampleType($orders[$counter]["test_info"]["required_sample_type"]);
			
			$counter ++;
		}
		
		$data["orders"] = $orders;
		//load the pages
		$data["patient"]["first_name"] = $non_customer_order["name"];
		$data["patient"]["last_name"] = "";
		$data["patient"]["middle_name"] = "";
		$data["patient"]["patient_number"] = NON_CUSTOMER_ID;
		
		
		$data['title'] = "Medstation | Laboratory";
		$data['content-description'] = "Publish Laboratory test result";
		//get all user module mappings by role
		$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
		$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
		
		$data['currentmodule']['number'] = MODULE_NO;
		$data['currentmodule']['title'] = TITLE;
		
		
	        
		$pages[0] = "laboratory/pendingtests";
		$this->page->loadPage($pages,$data,TRUE);
	}

	public function getCollectedSamplesNeedingResult($patient_number)
	{
		$this->utilities->aunthenticateAccess(RECORD_RESULTS, "laboratory");
		
		$patient = $this->patient_model->getPatient($patient_number);
		
		if(!$patient)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$orders = $this->lab_orders_model->getOrdersWithoutResult($patient_number);
		
		if(!$orders)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(NO_TESTS_NEED_PUBLISH_RESULT));
		}
		
		//get the samples for each orders found
		
		$counter = 0;
		foreach($orders as $order)
		{
			$orders[$counter]["sample"] = $this->sample_model->getSamplesByOrderId($order["order_id"]);
			$orders[$counter]["bill_info"]  = $this->bills_model->getBillByReference($order['reference_id']);
			$orders[$counter]["test_info"] = $this->laboratory_model->getLab($order["lab_id"]);
			$orders[$counter]["sample_type"] = $this->sample_type_model->getSampleType($orders[$counter]["test_info"]["required_sample_type"]);
			
			$counter ++;
		}
		
		$data["orders"] = $orders;
		//load the pages
		$data["patient"] = $patient;
		$data['title'] = "Medstation | Laboratory";
		$data['content-description'] = "Publish Laboratory test result";
		//get all user module mappings by role
		$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
		$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
		
		$data['currentmodule']['number'] = MODULE_NO;
		$data['currentmodule']['title'] = TITLE;
		
		
	        
		$pages[0] = "laboratory/pendingtests";
		$this->page->loadPage($pages,$data,TRUE);
		
		
	}
	
	public function viewNonPatientTests()
	{
		$this->utilities->aunthenticateAccess(VIEW_PATIENT_LAB_RESULTS, "laboratory");
		
		if(!$this->input->post("name"))
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$searchName = $this->input->post("name");
		
		//check if there are any patients that names are like that with an order
		$ordersLikeName = $this->non_customer_order_model->getNonCustomerOrdersLikeName(urldecode($searchName));
		
		//if no order matches return no order found with that name
		
		if(!$ordersLikeName){
			$this->utilities->redirectWithNotice("laboratory", "No Order found in Name ".$searchName);
		}
		
		//find lab orders that have a result and are in the reference list
		
		$finishedLabOrders = $this->lab_orders_model->getLabOrdersThatHaveResultInReferences($ordersLikeName);
		
		if(!$finishedLabOrders)
		{
			$this->utilities->redirectWithNotice("laboratory", "Results Not yet published");

		}
		
		//get the results
		$orderIds;
		$counter = 0;
		$lab_results;
		
		foreach($finishedLabOrders as $labOrders)
		{
			$lab_results[$counter] = $this->lab_results_model->getResultByOrderId($labOrders['order_id']);
			$lab_results[$counter]["order_details"] = $this->non_customer_order_model->getNonCustomerOrderByReference($labOrders["reference_id"]); 
			$lab_results[$counter]["test_info"] = $this->laboratory_model->getLab($labOrders["lab_id"]);
			
			$counter++;
		}
		
		//print_r($finishedLabOrders);
		
		//$lab_results = $this->lab_results_model->getResultsByOrderId($orderIds);
		
		
		$data['lab_results'] = $lab_results;
		$data['patient']['patient_number'] = NON_CUSTOMER_ID;
		$data['patient']['first_name'] = "Non Customer";
		$data['patient']['middle_name'] = "";
		$data['patient']['last_name'] = "";
		
		$data['title'] = "Medstation | Laboratory";
		$data['content-description'] = "View Laboratory Test Results";
		//get all user module mappings by role
		$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
		$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
		
		$data['currentmodule']['number'] = MODULE_NO;
		$data['currentmodule']['title'] = TITLE;
			
		 $this->load->view('templates/header', $data);
		 $this->load->view('templates/mainheader', $data);
		 $this->load->view('laboratory/non_patient_tests', $data);
		 $this->load->view('templates/footer');
		

	}
	
	
	public function viewPatientTests($patient_number)
	{
		
		$this->utilities->aunthenticateAccess(VIEW_PATIENT_LAB_RESULTS, "laboratory");
		
		$patient = $this->patient_model->getPatient($patient_number);
		
		if(!$patient)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$lab_results = $this->lab_results_model->getResultByPatient($patient["patient_number"]);
		
		if(!$lab_results)
		{
			$this->utilities->redirectWithNotice("patient/number/".$patient_number, $this->lang->line(NO_TEST_RESULTS));
		}
		
		//get lab order from database to get the lab data
		
		$counter = 0;
		foreach($lab_results as $result)
		{
			$order = $this->lab_orders_model->getOrder($result["order_id"]);
			$lab_results[$counter]["test_info"] = $this->laboratory_model->getLab($order["lab_id"]);
			$counter ++;
		}
		
		
		
		$data['lab_results'] = $lab_results;
		$data['patient'] = $patient;
		$data['title'] = "Medstation | Laboratory";
		$data['content-description'] = "View Laboratory Test Results";
		//get all user module mappings by role
		$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
		$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
		
		$data['currentmodule']['number'] = MODULE_NO;
		$data['currentmodule']['title'] = TITLE;
			
		 $this->load->view('templates/header', $data);
		 $this->load->view('templates/mainheader', $data);
		 $this->load->view('laboratory/patient_tests', $data);
		 $this->load->view('templates/footer');
		
		
	}
	public function performTest()
	{
		$this->utilities->aunthenticateAccess(PERFORM_LAB_TEST, "laboratory");
		
		
		if(!$this->input->post("patient_number") || !$this->input->post("order_id"))
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$patient = $this->patient_model->getPatient($this->input->post("patient_number"));
		
		if(!$patient)
		{
			if($this->input->post("patient_number") != NON_CUSTOMER_ID)
			{
				$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		
			}
		}
		
		
		if(!$this->input->post("test_results"))
		{
			$this->utilities->redirectWithNotice("laboratory/getLabJobs/".$this->input->post("patient_number")
							     , $this->lang->line(RECORD_TEST_RESULTS_FIRST));
		}
		
		//post test result in the database
		$this->lab_results_model->set_Result($this->input->post("patient_number"),
						     $this->input->post("test_results"),
						     $this->input->post("order_id"),
						     $this->session->userdata("staff_no"));
		
		//update the order to post
		
		$data['status'] = "P";
		$this->general_update_model->update("laboratory_test_orders",
						    "order_id",
						    $this->input->post("order_id"),
						    $data);
		
		
		//get the reference from orders
		if($this->input->post("patient_number") == NON_CUSTOMER_ID)
		{
			$updateData['lab_operation_needed'] = "P";
		
		
			$orders = $this->lab_orders_model->getOrder($this->input->post("order_id"));
			$this->general_update_model->update("non_customer_orders",
						    "reference_id",
						    $orders["reference_id"],
						    $updateData);
			
		}
		
		$this->utilities->redirectWithNotice("laboratory", $this->lang->line(SUCCESS_RECORD_TEST_RESULTS));
		
	}
	
	
	
	
	public function findNonPatientJob()
	{
		$this->utilities->aunthenticateAccess(PERFORM_LAB_TEST, "laboratory");
		
		
	
	if(isset($_POST['return_base']))
	{
		$searchedOrders = $this->lab_orders_model->getPendingResultsForNonPatientNameLike($this->input->post("name"));
		
	}
	else
	{
		$searchedOrders = $this->lab_orders_model->getPendingOrdersForNonPatientNameLike($this->input->post("name"));

	}
		
		//print_r($searchedOrders);
		
		$data["walk_in_patients"] = $searchedOrders;
		//get all user module mappings by role
		$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			
		if(isset($_POST['return_base']))
		{
			$data['return_base'] = $_POST['return_base'];			
		}
			
		$data['title'] = "Medstation | Laboratory Search Unregistered Patients";
		$data['search_url']= "index.php/laboratory/findNonPatientJob";
			
		$data['currentmodule']['number'] = MODULE_NO;
		$data['currentmodule']['title'] = TITLE;
		//get the role title
		$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
		$pages[0] = "laboratory/searchNonPatient";
			
		$this->page->loadPage($pages, $data, TRUE);
	}
	
	public function getWalkInLabJob($reference)
	{
		$this->utilities->aunthenticateAccess(PERFORM_LAB_TEST, "laboratory");
		
		//get pending reference from un registered orders	
		
		if(!$reference)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
	
		}
		
		$nonOrders = $this->non_customer_order_model->getNonCustomerOrderByReference(urldecode($reference));
		
		
		
		if($nonOrders["lab_operation_needed"] != 'Y')
		{
           		$this->utilities->redirectWithNotice("laboratory", $this->lang->line(NO_NON_PATIENT_LAB_ORDER_FOUND));

		}
		
		$labOrders = $this->lab_orders_model->getPendingOrderByReference($nonOrders['reference_id']);
		//print_r($nonOrders);
		
		//if no orders available for patient display appropriate error message
		if(!$labOrders)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(NO_AVAILABLE_LAB_ORDER));
		}
		
		$counter = 0;
		//get bill status ea$data["patient"]ch of the orders concerned also get the lab order name
		foreach($labOrders as $order)
		{
			$labOrders[$counter]["bill_info"]  = $this->bills_model->getBillByReference($order['reference_id']);
			$labOrders[$counter]["test_info"] = $this->laboratory_model->getLab($order["lab_id"]);
			$labOrders[$counter]["sample_type"] = $this->sample_type_model->getSampleType($labOrders[$counter]["test_info"]["required_sample_type"]);
			$counter ++;
		}
		
		$data["orders"] = $labOrders;
		//load the pages
		$data["patient"]['first_name'] = $nonOrders['name'];
		$data["patient"]['last_name'] = NULL;
		$data["patient"]['middle_name'] = NULL;
		$data["non_patient"] = true;
		$data['title'] = "Medstation | Laboratory";
		$data['content-description'] = "Create Laboratory test";
		//get all user module mappings by role
		$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
		$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
		
		$data['currentmodule']['number'] = MODULE_NO;
		$data['currentmodule']['title'] = TITLE;
		
		
	        
		$pages[0] = "laboratory/orders";
		$this->page->loadPage($pages,$data,TRUE);
		
	}
	
	public function getLabJobs($patient_number)
	{
		
		$this->utilities->aunthenticateAccess(PERFORM_LAB_TEST, "laboratory");
		
		//check if patient exists
		
		if(!$patient_number)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$patient = $this->patient_model->getPatient($patient_number);
		
		if(!$patient)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		//since the patient exists lets try to look for all lab tests that belong to the patient and also the corresponding lab bills
		
		$labOrders = $this->lab_orders_model->getPendingOrdersByPatient($patient["patient_number"]);
		
		//if no orders available for patient display appropriate error message
		if(!$labOrders)
		{
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(NO_AVAILABLE_LAB_ORDER));
		}
		
		$counter = 0;
		//get bill status each of the orders concerned also get the lab order name
		foreach($labOrders as $order)
		{
			$labOrders[$counter]["bill_info"]  = $this->bills_model->getBillByReference($order['reference_id']);
			$labOrders[$counter]["test_info"] = $this->laboratory_model->getLab($order["lab_id"]);
			$labOrders[$counter]["sample_type"] = $this->sample_type_model->getSampleType($labOrders[$counter]["test_info"]["required_sample_type"]);
			$counter ++;
		}
		
		$data["orders"] = $labOrders;
		//load the pages
		$data["patient"] = $patient;
		$data['title'] = "Medstation | Laboratory";
		$data['content-description'] = "Create Laboratory test";
		//get all user module mappings by role
		$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
		$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
		
		$data['currentmodule']['number'] = MODULE_NO;
		$data['currentmodule']['title'] = TITLE;
		
		
	        
		$pages[0] = "laboratory/orders";
		$this->page->loadPage($pages,$data,TRUE);		
			
			
	}
	
	
	public function recordSample()
	{
		$this->utilities->aunthenticateAccess(RECORD_SAMPLES, "laboratory");
		$description = NULL;
		
		
	

		if(!$this->input->post("sample_reference") || !$this->input->post("patient_number") || !$this->input->post("order_id") )
		{
			$this->utilities->redirectWithNotice("laboratory",$this->lang->line(INVALID_FUNC_CALL));
		}
		//record sample
		//check if reference already exists
		$sample = $this->sample_model->getSampleByRef($this->input->post("sample_reference"));
		
		
		
		if($sample)
		{
			$this->utilities->redirectWithNotice("laboratory/getLabJobs/".$this->input->post("patient_number"), $this->lang->line(EXISTING_SAMPLE_REF));
		}
		
		if($this->input->post("sample_description"))
		{
			$description = $this->input->post("sample_description");
		}
		//create sample ref
		
		
		$this->sample_model->set_Sample($this->input->post("sample_reference"),
						$description,
						$this->session->userdata("staff_no"),
						$this->input->post("sample_type"),
						$this->input->post("patient_number"),
						$this->input->post("order_id"));
		
		$data['status'] = "R";
		$this->general_update_model->update("laboratory_test_orders",
						    "order_id",
						    $this->input->post("order_id"),
						    $data);
		
		
		//check if walk in patient update the order to processed 
		
		//get the reference from orders
		if($this->input->post("patient_number") == NON_CUSTOMER_ID)
		{
			
			$updateData['lab_operation_needed'] = "R";
		
		
			$orders = $this->lab_orders_model->getOrder($this->input->post("order_id"));
			$this->general_update_model->update("non_customer_orders",
						    "reference_id",
						    $orders["reference_id"],
						    $updateData);
			
		}
		
		
		
		$this->utilities->redirectWithNotice("", $this->lang->line(TEST_SAMPLE_RECORDED));
	}
	
	public function view($lab_id)
	{
			$this->utilities->aunthenticateAccess(VIEW_LAB_TEST, "laboratory");
			
			if(!$lab_id)
			{
				redirect("/laboratory");
			}
			
			$data['lab'] = $this->laboratory_model->getLab($lab_id);
			
			if(!$data['lab'])
			{
				redirect("/laboratory");
			}
			
			$data['lab_price'] = $this->laboratory_price_model->getPriceOfLabTest($data['lab']['lab_id']);
			
			//get lab price details
			
			$data['title'] = "Medstation | Laboratory";
			$data['content-description'] = "Laboratory";
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));			
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			
			
			$pages[0] = "laboratory/view";
			
			$this->page->loadPage($pages,$data, TRUE);
			
				
		
	}
	
	
	
	public function viewSampleType($id)
	{
		$this->utilities->aunthenticateAccess(VIEW_SAMPLE_TYPE, "laboratory");
		
		if(!$id)
		{
		   redirect("/laboratory");
		}
		
		$data['sampletype'] = $this->sample_type_model->getSampleType($id);
		
		if(!$data['sampletype'])
		{
			redirect("/laboratory");
		}
		
		//get lab price details
			
			$data['title'] = "Medstation | Laboratory";
			$data['content-description'] = "Laboratory";
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));			
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			
			
			$pages[0] = "laboratory/viewSampleType";
			
			$this->page->loadPage($pages,$data, TRUE);
	}
	
	public function searchSampleType()
	{
		$this->utilities->aunthenticateAccess(VIEW_SAMPLE_TYPE, "laboratory");
		
		if(!$this->input->post("name"))
		{
			$sampletypes = $this->sample_type_model->getSampleType();
		}
		else
		{
			$sampletypes = $this->sample_type_model->getSampleTypeLike($this->input->post("name"));
		}
		
		$data["sampletypes"] = $sampletypes;
		//get all user module mappings by role
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			if(isset($_POST['return_base']))
			{
				$data['return_base'] = $_POST['return_base'];			
			}
			
			
			$data['title'] = "Medstation | Laboratory Sample Type Search";
			$data['search_url']= "index.php/laboratory/searchSampleType";
			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
			$pages[0] = "laboratory/searchsample";
			
			$this->page->loadPage($pages, $data, TRUE);
			
			
			
	}
	
	public function updateLabBill()
	{
		$this->utilities->aunthenticateAccess(UPDATE_LAB_PRICE, "laboratory");
		
		if(!$this->input->post("lab_price") || !$this->input->post("lab_price_id"))
		{
			$this->utilities->redirectWithNotice("laboratory",$this->lang->line(INVALID_FUNC_CALL));
		}
		else
		{
			if(!is_numeric($this->input->post("lab_price")))
			{
				$this->utilities->redirectWithNotice("laboratory",$this->lang->line(ERROR_INVALID_AMOUNT));
			}
			
			$lab_price = $this->laboratory_price_model->getLabTestPrice($this->input->post("lab_price_id"));
			
			
			if(!$lab_price)
			{
				$this->utilities->redirectWithNotice("laboratory",$this->lang->line(INVALID_FUNC_CALL));
			}
			
			$lab = $this->laboratory_model->getLab($lab_price['lab_id']);
			
			$data['lab_price'] = $this->input->post("lab_price");
			$this->general_update_model->update("lab_pricie_master","lab_price_id",$this->input->post("lab_price_id"), $data);
			
			$data= array();
			$data['unit_price'] = $this->input->post("lab_price");
			$this->general_update_model->update("bill_master","lab_price_id",$this->input->post("lab_price_id"), $data);
			
			
			
			$title = "Laboratory update. Laboratory Test : ".$lab['name']." Price Udpate";
			$message = "Price change from ".$lab_price['lab_price']." to ".$this->input->post("lab_price")."";
			
			$this->message->sendChangeAlert(MODULE_NO, $title, $message, "2005/10/01");
			
			
			$this->utilities->redirectWithNotice("laboratory",$this->lang->line(LAB_BILL_CREATE_SUCCESS));
		}
		
				
		
	}
	
	public function search()
	{
		
		$this->utilities->aunthenticateAccess(VIEW_LAB_TEST, "laboratory");
			
				
			if(isset($_POST['name']))
				{
					$data['labs'] = $this->laboratory_model->getLabLikeName($_POST['name']);
					
				}
				else
				{
					$data['labs'] = $this->laboratory_model->getLab();
					
				}
			
			
			
			
			//get all user module mappings by role
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			if(isset($_POST['return_base']))
			{
				$data['return_base'] = $_POST['return_base'];			
			}
			$data['title'] = "Medstation | Laboratory Test Search";
			$data['search_url']= "index.php/laboratory/search";
			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
			$pages[0] = "laboratory/search";
			
			$this->page->loadPage($pages, $data, TRUE);
							
	
		
	}
	
	
	
	
	
	public function createSampleType()
	{
		$this->utilities->aunthenticateAccess(DEFINE_SAMPLE_TYPE, "laboratory");
		
		$data['title'] = "Medstation | Laboratory";
		$data['content-description'] = "Create Sample Type";
			//get all user module mappings by role
		$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
		$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
		$data['currentmodule']['number'] = MODULE_NO;
		$data['currentmodule']['title'] = TITLE;
			
		$data['sample_types'] = $this->sample_type_model->getSampleType();
		
		$this->load->helper('form');
		$this->load->library('form_validation');
			
		$this->form_validation->set_rules('name', 'Sample Name', 'required');
			
		$this->form_validation->set_rules('description', 'Description', 'required');
		
		if( $this->input->post("name") )
		   {
			$data["name"] = $this->input->post("name");
		   }
			  
	        if( $this->input->post("description") )
		  {
		        $data["description"] = $this->input->post("description");
		  }
		
		$validationError = FALSE;
		
		//check if the sample type already exists
		
		if($this->input->post("name"))
		{
			$sampletype = $this->sample_type_model->getSampleTypeByName($this->input->post("name"));
			
			if($sampletype)
			{
				
				$validationError = TRUE;
				$this->utilities->setNotice($this->lang->line(SAMPLE_TYPE_ALREADY_EXITS));
			}
		}
		
		
		 if ($this->form_validation->run() === FALSE || $validationError)
		  {
		       $pages[0] = "laboratory/createsampletype";
		       $this->page->loadPage($pages,$data,TRUE);		       
			
		  }
		  else
		  {
			$this->sample_type_model->set_SampleType($this->input->post("name"), $this->input->post("description"), $this->session->userdata("staff_no"));
			$this->utilities->redirectWithNotice("laboratory", $this->lang->line(SAMPLE_TYPE_CREATED));
		  }
		
	}
	public function add()
	{
		
		$this->utilities->aunthenticateAccess(CREATE_LAB_TEST, "laboratory");
			
			$data['title'] = "Medstation | Laboratory";
			$data['content-description'] = "Create Laboratory test";
			//get all user module mappings by role
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			
			$data['sample_types'] = $this->sample_type_model->getSampleType();
			
			if(!$data['sample_types'])
			{
				$this->utilities->redirectWithNotice("laboratory", $this->lang->line(NO_SAMPLE_TYPE_DEFINED));
			}
		
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('name', 'Name', 'required');
			
			$this->form_validation->set_rules('description', 'Description', 'required');
			
			$this->form_validation->set_rules('price', 'Price', 'required');
			
			
		        if( $this->input->post("name") )
		          {
			     $data["name"] = $this->input->post("name");
			  }
			  
			  if( $this->input->post("description") )
		          {
			     $data["description"] = $this->input->post("description");
			  }
			  
			  
			if( $this->input->post("price") )
		          {
			     $data["price"] = $this->input->post("price");
			  }
			  
			  $validationError = FALSE;
			  
			    if($this->input->post("price"))
			    {
				 if(!is_numeric($this->input->post("price")))
					{
					      $validationError = TRUE;
					      $array = array('notice' => "Invalid Price");
					      $this->session->set_userdata($array);
					      
					}
			    }
			 
			  
			  if($this->input->post("name"))
			  {
				 $lab_master = $this->laboratory_model->getLabByName($this->input->post("name"));
					
					if($lab_master)
					{
						$validationError = TRUE;
						$array = array('notice' => "Lab test already exists");
						$this->session->set_userdata($array);
					}
			  }
			 
					
					
			 
			 if ($this->form_validation->run() === FALSE || $validationError)
				{
					
				        $this->load->view('templates/header', $data);
					$this->load->view('templates/mainheader', $data);
					$this->load->view('laboratory/create', $data);
					$this->load->view('templates/footer');
				
				}
				else
				{
					//create lab master and create lab master price
					$this->laboratory_model->setLabTest($this->input->post("name"),
									    $this->input->post("description"),
									    $this->session->userdata("staff_no"),
									    $this->input->post("required_sample_type"));
					
					
					//find the newly created laboratory record					
					$lab_master = $this->laboratory_model->getLabByName($this->input->post("name"));
					
					if($lab_master)
					{
						$this->laboratory_price_model->setLabTestPrice($lab_master["lab_id"],
										       $this->input->post("price"),
										       "NGN",
										        $this->session->userdata("staff_no"));
						
						
						$lab_price = $this->laboratory_price_model->getPriceOfLabTest($lab_master["lab_id"]);
						
						$this->bill_master_model->set_new_bill($this->input->post("description"),
										       "Laboratory test (".$this->input->post("name").")",
										       $this->input->post("price"),
										        $this->session->userdata("staff_no"),
											NULL,
											$lab_price['lab_price_id']);
					}
					
					
					$this->utilities->redirectWithNotice("laboratory", $this->lang->line(NOTICE_LAB_TEST_CREATE_SUCCESS));
					
					
				}
	
		
			
	}
	
	
        public function index()
        {
		
            	$this->utilities->loginCheck();
			
			
			$data['title'] = "Medstation | Laboratory";
			 $data['content-description'] = "Laboratory";
		
			//get all user module mappings by role
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			
			$pages[0]= "laboratory/home";
			
			$this->page->loadPage($pages,$data,TRUE);
			
			
		
        }

	
  
}