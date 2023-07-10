<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
define ('MODULE_NO', 12);
define ('VIEW_PHARMACY_HOME', 41);
define ('CREATE_NEW_DRUG', 42);
define ('VIEW_DRUG', 43);
define ('UPDATE_DRUG', 44);
define ('DISPENSE_DRUG', 45);
define ('UPDATE_DRUG_PRICE', 46);
define ('TITLE', 'Pharmacy');

class Pharmacy extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('passwordhash', array('iteration_count_log2' => 8, 'portable_hashes' => FALSE ));
		$this->load->model('ult');
		$this->load->model('staff_master_model');
		$this->load->model('staff_model');
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
		$this->load->model('drug_presentation_model');
		$this->load->model('drug_master_model');
		$this->load->model('pharmacy_stock_model');
		$this->load->model('currency_model');
		$this->load->model('drug_bill_form_model');
		$this->load->model('drug_price_master_model');
		$this->load->model('bill_master_model');
		$this->load->model('drug_stock_rules_model');
		$this->load->model('unit_model');
		$this->load->model('bills_model');
		$this->load->model('patient_model');
		$this->load->model('general_update_model');
		$this->load->model('stock_movement_model');
		$this->load->model('message_model');
		$this->load->model('non_customer_order_model');
		$this->utilities->loadUserLang();
	}
	
	
	
	private function confirmUrl()
	{
		if($this->session->userdata('base_url') != base_url())
		{
			redirect("/logout");
		}
			
	}
		
	private function moduleAccessCheck($accessLevel)
	{
	     $this->confirmUrl();
				
	     $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), $accessLevel);
				    
	     if(!isset($moduleAccess) || $moduleAccess['access'] != "W")
		{
			$array = array('notice' => ACCESS_ERROR);
			$this->session->set_userdata($array);
		        redirect('/home');
		}
	}
			
			
	
	public function search()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->confirmUrl();
			
			$this->moduleAccessCheck(VIEW_DRUG);
			
				
			if(isset($_POST['name']))
				{
					$data['drugs'] = $this->drug_master_model->getDrugLikeName($_POST['name']);
				}
				else
				{
					$data['drugs'] = $this->drug_master_model->getDrug();
				}
			
			
			
			
			//get all user module mappings by role
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			if(isset($_POST['return_base']))
			{
				$data['return_base'] = $_POST['return_base'];			
			}
			$data['title'] = "Medstation | Pharmacy Drug Search";
			$data['search_url']= "index.php/pharmacy/search";
			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			//get the role title
			$data['drug_presentations'] = $this->drug_presentation_model->getDrugPresentation();
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
			$this->load->view('templates/header', $data);
				$this->load->view('templates/mainheader', $data);
				$this->load->view('pharmacy/search', $data);
				$this->load->view('templates/footer');
				
		}
		else
		{
			 redirect('/login');
		}
		
	}
	
	
	
	public function findPaidNonPatientJob()
	{
		$this->utilities->aunthenticateAccess(DISPENSE_DRUG, "pharmacy");
		
		if(!$this->input->post("walk_in_name"))
		{
			$this->utilities->redirectWithNotice("pharmacy",$this->lang->line(INVALID_FUNC_CALL));
		}
		//get all patients in the patient order with names like
		$searchedOrders = $this->non_customer_order_model->getNonCustomerPaidDispenseOrdersLikeName($this->input->post("walk_in_name"));
		
		
		$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			
                //get the role title
                $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
                                
                $data['currentmodule']['number'] = MODULE_NO;
                $data['currentmodule']['title'] = TITLE;                                
                $data['departments'] = $this->department_model->getDepartments();				
		$data['bills'] = $searchedOrders;                                
                $data['title'] = "Medstation | Pharmacy";
                $data['content-description'] = "Dispense Management";
                                 
				
                                
                //$data['title']=$this->passwordhash->HashPassword("password");
		$page[0] = "pharmacy/pendingNonPayment";
		$this->page->loadPage($page,$data,TRUE);
	}
	
	
	public function findNonPatientJob()
	{
		$this->utilities->aunthenticateAccess(DISPENSE_WITHOUT_PAYMENT, "pharmacy");
		
		if(!$this->input->post("walk_in_name"))
		{
			$this->redirectWithNotice("laboratory",$this->lang->line(INVALID_FUNC_CALL));
		}
		//get all patients in the patient order with names like
		$searchedOrders = $this->non_customer_order_model->getNonCustomerUnPaidDispenseOrdersLikeName($this->input->post("walk_in_name"));
		
		
		$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			
                                //get the role title
                                $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
                                
                                $data['currentmodule']['number'] = MODULE_NO;
                                $data['currentmodule']['title'] = TITLE;                                
                                $data['departments'] = $this->department_model->getDepartments();				
				$data['bills'] = $searchedOrders;                                
                                $data['title'] = "Medstation | Pharmacy";
                                 $data['content-description'] = "Dispense Management";

				$page[0] = "pharmacy/pendingNonPayment";
				$this->page->loadPage($page,$data,TRUE);
	}
	
	//
	public function findAllPendingDispenseJobs(){

		$this->utilities->aunthenticateAccess(DISPENSE_WITHOUT_PAYMENT, "pharmacy");

		$references  = null;

		$references  = $this->bills_model->getAllBillsNeedDispenseNoPayment();


		if(!$references || $references == "")
		{
			$this->utilities->redirectWithNotice("pharmacy",$this->lang->line(NO_PENDING_ORDERS));
		}


		$session_data["pharmacy_return_url"] =  "pharmacy/findAllPendingDispenseJobs";
		$this->session->set_userdata($session_data);

		//get the proper reference data
		$counter = 0;

		foreach($references as $reference)
		{

			$patient_data = $this->patient_model->getPatient($reference['patient_number']);

			$reference['name'] = ucfirst($patient_data['first_name'])." ".ucfirst($patient_data['middle_name'])." ".ucfirst($patient_data['last_name']);
			$references[$counter]['name'] = $reference['name'];
			if($reference['status'] != "R")
			{
				$references[$counter]['date_posted'] = "N/A";
			}
			else
			{
				$references[$counter]['date_posted']  = $reference['date_paid'] ;
			}

			$references[$counter]['total_amount'] = "0";
			$counter ++;
		}


		$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

		//get the role title
		$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));

		$data['currentmodule']['number'] = MODULE_NO;
		$data['currentmodule']['title'] = TITLE;
		$data['departments'] = $this->department_model->getDepartments();
		$data['bills'] = $references;
		$data['title'] = "Medstation | Pharmacy";
		$data['content-description'] = "Dispense Management";



		$page[0] = "pharmacy/pending";
		$this->page->loadPage($page,$data,TRUE);



	}

	///gets all dispense jobs even if they have not paid
	public function findFullDispenseJob($patient_number)
	{
		$this->utilities->aunthenticateAccess(DISPENSE_WITHOUT_PAYMENT, "pharmacy");
		
		if(!$patient_number || $patient_number == "")
		 {
		    redirect("/pharmacy");
		 }
			
		$patient_data = $this->patient_model->getPatient($patient_number);
			
		
		
		if(!$patient_data || $patient_data == "")
			{
				
				$this->utilities->redirectWithNotice("pharmacy",$this->lang->line(INVALID_PATIENT));
			}
			
		$references  = null;
			
		$references  = $this->bills_model->getBillsNeedDispenseNoPayment($patient_data['patient_number']);
		
		//print_r($references);
		//return false;
			
		if(!$references || $references == "")
			{
				$this->utilities->redirectWithNotice("pharmacy",$this->lang->line(NO_PENDING_ORDERS));
			}
		
			//get the proper reference data
			
			$counter = 0;
			
			foreach($references as $reference)
			{
				$reference['name'] = ucfirst($patient_data['first_name'])." ".ucfirst($patient_data['middle_name'])." ".ucfirst($patient_data['last_name']);
				$references[$counter]['name'] = $reference['name'];
				if($reference['status'] != "R")
				{
					$references[$counter]['date_posted'] = "N/A";
				}
				else
				{
					$references[$counter]['date_posted']  = $reference['date_paid'] ;
				}
				
				$references[$counter]['total_amount'] = "0";
				$counter ++;
			}
			
			
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			
                                //get the role title
                                $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
                                
                                $data['currentmodule']['number'] = MODULE_NO;
                                $data['currentmodule']['title'] = TITLE;                                
                                $data['departments'] = $this->department_model->getDepartments();				
				$data['bills'] = $references;                                
                                $data['title'] = "Medstation | Pharmacy";
                                 $data['content-description'] = "Dispense Management";
                                 
				
                                
				$page[0] = "pharmacy/pending";
				$this->page->loadPage($page,$data,TRUE);
			
	}

	public function findAllPaidPendingDispenseJobs(){



		$this->utilities->aunthenticateAccess(DISPENSE_DRUG, "pharmacy");



		$references = $this->bills_model->getAllBillsNeedingDispense();


		if(!$references || $references == "")
		{
			$this->utilities->redirectWithNotice("pharmacy",$this->lang->line(NO_PENDING_ORDERS));
		}


		$counter = 0;

		$session_data["pharmacy_return_url"] =  "/pharmacy/findAllPaidPendingDispenseJobs";
		$this->session->set_userdata($session_data);




		foreach($references as $reference)
		{
			$reference['name'] = ucfirst($reference['first_name'])." ".ucfirst($reference['middle_name'])." ".ucfirst($reference['last_name']);
			$references[$counter]['name'] = $reference['name'];
			$references[$counter]['status'] ="P";
			$counter ++;
		}


		$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

		//get the role title
		$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));

		$data['currentmodule']['number'] = MODULE_NO;
		$data['currentmodule']['title'] = TITLE;
		$data['departments'] = $this->department_model->getDepartments();
		$data['bills'] = $references;
		$data['title'] = "Medstation | Pharmacy";
		$data['content-description'] = "Dispense Management";

		$page[0] = "pharmacy/pending";
		$this->page->loadPage($page,$data,TRUE);


	}

	//finds all paid dispense jobs
	public function findDispenseJob($patient_number)
	{
		
			$this->utilities->aunthenticateAccess(DISPENSE_DRUG, "pharmacy");
			
			if(!$patient_number || $patient_number == "")
			{
				redirect("/pharmacy");
			}
			
			$patient_data = $this->patient_model->getPatient($patient_number);
			
			
			
			if(!$patient_data || $patient_data == "")
			{
				
				$this->utilities->redirectWithNotice("pharmacy",$this->lang->line(INVALID_PATIENT));
			}
			
			$references  = null;
			
			if($patient_data['patient_type_code'] == 'H')
			{
				$references  = $this->bills_model->getBillReferencesNeedingDispenseHmo($patient_data['patient_number']);
			}
			else
			{
				$references  = $this->bills_model->getBillReferencesNeedingDispense($patient_data['patient_number']);
			}
			
			
			
			if(!$references || $references == "")
			{
				$this->utilities->redirectWithNotice("pharmacy",$this->lang->line(NO_PENDING_ORDERS));
			}
		
			//get the proper reference data
			
			$counter = 0;
			
			
			
			
			foreach($references as $reference)
			{
				$reference['name'] = ucfirst($patient_data['first_name'])." ".ucfirst($patient_data['middle_name'])." ".ucfirst($patient_data['last_name']);
				$references[$counter]['name'] = $reference['name'];
				$references[$counter]['status'] ="P";
				$references[$counter]['date_created'] =$reference['date_posted'];
				$counter ++;
			}
			
			
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			
                                //get the role title
                                $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
                                
                                $data['currentmodule']['number'] = MODULE_NO;
                                $data['currentmodule']['title'] = TITLE;                                
                                $data['departments'] = $this->department_model->getDepartments();				
				$data['bills'] = $references;                                
                                $data['title'] = "Medstation | Pharmacy";
                                 $data['content-description'] = "Dispense Management";
                                 
                                
                                //$data['title']=$this->passwordhash->HashPassword("password");
				$page[0] = "pharmacy/pending";
				$this->page->loadPage($page,$data,TRUE);
		
		
		
	}



	public function generateDispenseJob($reference_id)
	{
		if($this->session->userdata('logged_in'))
		{
			$this->confirmUrl();
			$this->moduleAccessCheck(DISPENSE_DRUG);
			
			$bills = $this->bills_model->getBillByReference(urldecode($reference_id));
			
			
			
			if(!$bills || $bills == "")
			{
				redirect("/pharmacy");
			}
			
			$isDispenseNeeded = false;
			
			$billsNeedingDispense = null;
			
			
			$counter = 0;
			foreach($bills as $bill)
			{
				if($bill['dispense_needed'] == "Y")
				{
					$isDispenseNeeded = true;
					$billsNeedingDispense[$counter] = $bill;
					$counter++;
				}				
				
			}
			
			
			
			if(!$isDispenseNeeded)
			{
				$array = array('notice' => "Dispense Job not found");
				$this->session->set_userdata($array);
				redirect("/pharmacy");
			}
			
			
			
			//get drugs and dependencies
			$dispenseJobs = null;
			$counter = 0;
			foreach($billsNeedingDispense as $bill)
			{
				$dispenseJobs[$counter]['qty'] = $bill['qty'];
				$dispenseJobs[$counter]['reference_id'] =  $bill['reference_id'];
				$dispenseJobs[$counter]['dispense_data'] =  $bill['additional_info'];
				//getbillmaster
				$billmaster = $this->bill_master_model->getBill($bill['bill_id']);
				$drug_price_master = $this->drug_price_master_model->getDrugPriceMaster($billmaster['drug_price_id']);
				
				$dispenseJobs[$counter]['drug_presentation'] =  $this->drug_presentation_model->getDrugPresentation($drug_price_master['drug_presentation_id']);
				$dispenseJobs[$counter]['drug_bill_form'] = $this->drug_bill_form_model->getDrugBillForms($drug_price_master['drug_bill_package_id']);
				$dispenseJobs[$counter]['drug'] =  $this->drug_master_model->getDrug($drug_price_master['drug_id']);
				
				$counter ++;
			}
			
			
			
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			
                                //get the role title
                                $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
                                
                                $data['currentmodule']['number'] = MODULE_NO;
                                $data['currentmodule']['title'] = TITLE;
                                
                                $data['departments'] = $this->department_model->getDepartments();
				$data['reference_id'] = $reference_id;
				
				$data['dispenseJobs'] = $dispenseJobs;
                                
                                $data['title'] = "Medstation | Pharmacy";
                                 $data['content-description'] = "Dispense Job";
                                 
                                
                                //$data['title']=$this->passwordhash->HashPassword("password");
				
				$this->load->view('templates/header', $data);
				$this->load->view('templates/mainheader', $data);
                                $this->load->view('pharmacy/dispenseJob');
                                $this->load->view('templates/footer');
				
				
		}
		else
		{
			redirect("/login");
		}
		
	}
	
	public function findDispenseJobByRef($ref)
	{
		echo $ref;
		
	}
	
	public function dispense()
	{

	$reference =  urldecode($this->input->post("reference_id"));
	$patient_number = "";

		if($this->session->userdata('logged_in'))
		{
			$this->confirmUrl();
			$this->moduleAccessCheck(DISPENSE_DRUG);
			
			if(!$reference)
			{
				redirect("/pharmacy");
			}
			
			$bills = $this->bills_model->getBillByReference($reference);
			
			$stockUpdateRequired = false;
			
			//stock validation run
			foreach($bills as $bill)
			{
				$patient_number = $bill["patient_number"];
				//if it has not been paid, please reduce stock as stock has not yet been reduced
				if($bill['status'] == "N")
				{
					$stockUpdateRequired = true;
				}
			}
			
			
			
			
			if($stockUpdateRequired)
			{

				$StockUpdateArray = null;
				$stockArrayCounter = 0;				
				$isInStock = true;
				$dispenseData = null;
				$last_drug_id = "";
				$currentStock = 0;
				
				
				foreach($bills as $bill)
				{
					$bill_master = $this->bill_master_model->getBill($bill['bill_id']);
					
					$dispenseData[$bill["id"]]['dispense_needed'] = null;
					
					$dispenseData[$bill["id"]]['dispense_needed'] = "Y";
						
						
						$drug_price_master = $this->drug_price_master_model->getDrugPriceMaster($bill_master['drug_price_id']);
						$pharmacy_stock = $this->pharmacy_stock_model->getStock($drug_price_master['drug_id']);
						
												
						//validate stock
						$package_id_to_dispense = $drug_price_master['drug_bill_package_id'];
						$default_package_id = $pharmacy_stock['drug_bill_package_id'];
						
						if($default_package_id == $package_id_to_dispense)
						{
						   if($last_drug_id == $drug_price_master['drug_id'])
						   {
							$pharmacy_stock['qty_in_stock'] = $currentStock;							
						   }
						   
						   $last_drug_id == $drug_price_master['drug_id'];
						   
						   
						   //since its in the same package confirm stock before bill posting							
						   if($bill['qty'] > $pharmacy_stock['qty_in_stock'])
						   {
							$isInStock = false;
							$array = array('notice' =>$bill_master['service_name']." is not in stock. ");
							$this->session->set_userdata($array);
							break;							
						   }
						   else
						   {
							//populate stock array update
							$StockUpdateArray[$stockArrayCounter]['stock_id']=  $pharmacy_stock['stock_id'];
							$currentStock =  $pharmacy_stock['qty_in_stock'] - $bill['qty'];
							$StockUpdateArray[$stockArrayCounter]['qty_to_reduce'] = $bill['qty'];
							$StockUpdateArray[$stockArrayCounter]['drug_id'] = $drug_price_master['drug_id'];
							$stockArrayCounter ++;
						   }
						   
						}
						else
						{
							 if($last_drug_id == $drug_price_master['drug_id'])
								{
								     $pharmacy_stock['qty_in_stock'] = $currentStock;							
								}
								
								$last_drug_id == $drug_price_master['drug_id'];
								
								
							//not in the same package get stock rules and calculate
							$rules = $this->drug_stock_rules_model->getDrugStockRule($drug_price_master['drug_id']);
							
							foreach($rules as $rule )
							{
								if($rule['multiplied_package_id'] == $package_id_to_dispense)
								{
								   $calculatedNumberInStock = $rule['multiplier'] * $pharmacy_stock['qty_in_stock'];
								   
								    if($bill['qty'] > $calculatedNumberInStock)
									{
									     $isInStock = false;
									     $array = array('notice' =>$bill_master['service_name']." is not in stock. ");
									     $this->session->set_userdata($array);
									     break;							
									}
									else
									{
										$StockUpdateArray[$stockArrayCounter]['stock_id']=  $pharmacy_stock['stock_id'];
										$currentStock =  $pharmacy_stock['qty_in_stock'] - ($bill['qty']/$rule['multiplier']);
										$StockUpdateArray[$stockArrayCounter]['qty_to_reduce'] = $bill['qty']/$rule['multiplier'];
										$StockUpdateArray[$stockArrayCounter]['drug_id'] = $drug_price_master['drug_id'];
										$stockArrayCounter ++;
									}

								   break;
								}
							}
							
						}
				}
				
				
				//if it is not in stock
			
			if(!$isInStock)
				{					
					
					 if($patient_number == NON_CUSTOMER_ID)
						{
							// $reference = $formalReference;
							redirect("/billing/nonCustomerBill/".$reference);
						}
						else
						{
							
							redirect('/billing/currentBill/'.$patient_number);
						}
					
				}
				
				
				
		
			 //update stock quatity
			if($StockUpdateArray)
			   {
			      foreach($StockUpdateArray as $update)
				 {
				     $pharmacy_stock = $this->pharmacy_stock_model->getStock($update['drug_id']);
				     $data['qty_in_stock'] = $pharmacy_stock['qty_in_stock'] - $update['qty_to_reduce'];
				     $this->general_update_model->update("pharmacy_stock","stock_id",$update['stock_id'], $data);					
				 
				 }
			    }
				
				
			}
			
			
			
			$data = null;
			
			foreach($bills as $bill)
			{
				
				if($bill['dispense_needed'])
				{
					$data['dispense_needed'] = "D";
				        $this->general_update_model->update("bills","reference_id",$reference, $data);
				}
			}
			
			
			
			
			//update posted bills and hmo_to_post_bills
			$data['dispense_needed'] = "D";
			$this->general_update_model->update("posted_bills","reference_id",$reference, $data);
			$this->general_update_model->update("hmo_bills_to_post","reference_id",$reference, $data);
			$this->general_update_model->update("non_customer_orders","reference_id",$reference, $data);
			
			//check
			
			$array = array('notice' => "Drug(s) Dispensed");
			$this->session->set_userdata($array);


			$returnUrl = $this->session->userdata("pharmacy_return_url");

			//go back to the calling page if it is not null
			if($returnUrl != null && $returnUrl != ""){
				$this->session->unset_userdata("pharmacy_return_url");
				redirect($returnUrl);

			}

			redirect("/pharmacy");
			
		}
		else
		{
			redirect("/login");
		}
	}
        
	public function add()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->confirmUrl();
			$this->moduleAccessCheck(CREATE_NEW_DRUG);
			
			$data['title'] = "Medstation | Pharmacy";
			$data['content-description'] = "Pharmacy";
		
			//get all user module mappings by role
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			//get all currencies
			$data['currencies'] = $this->currency_model->getCurrency();
			
			$data['drug_bill_forms'] = $this->drug_bill_form_model->getDrugBillForms();
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			$data['drug_presentations'] = $this->drug_presentation_model->getDrugPresentation();
			$data['units']  = $this->unit_model->getUnit();
			
			$config['upload_path'] = 'assets/drugs';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size']	= '2000';
		    
                    
    
                        $this->load->library('upload', $config);
		    
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			
    
                    
		    
		    
				
				  //form validations here
				 $this->form_validation->set_rules('name', 'Name', 'required');
				 $this->form_validation->set_rules('manufacturer', 'manufacturer', 'required');
				 $this->form_validation->set_rules('initial_stock', 'Initial Stock', 'required');
				// $this->form_validation->set_rules('batch_number', 'Batch Number', 'required');
				 //$this->form_validation->set_rules('manufacture_date', 'Manufacture Date', 'required');
				 //$this->form_validation->set_rules('expiry_date', 'Expiry Date', 'required');
		      
				 if( $this->input->post("name") )
				   {
				     $data["name"] = $this->input->post("name");
				   }
				   
				if( $this->input->post("supplier") )
				   {
				     $data["supplier"] = $this->input->post("supplier");
				   }
				   
				 if( $this->input->post("batch_number") )
				   {
				     $data["batch_number"] = $this->input->post("batch_number");
				   }
				   
				 if( $this->input->post("manufacture_date") )
				   {
				     $data["manufacture_date"] = $this->input->post("manufacture_date");
				   }
				   
				   
				 if( $this->input->post("expiry_date") )
				   {
				     $data["expiry_date"] = $this->input->post("expiry_date");
				   }
				   
				   
				if( $this->input->post("description") )
				   {
				     $data["description"] = $this->input->post("description");
				   }
				if( $this->input->post("intial_stock") )
				   {
				     $data["intial_stock"] = $this->input->post("intial_stock");
				   }
				   
				if( $this->input->post("manufacturer") )
				   {
				     $data["manufacturer"] = $this->input->post("manufacturer");
				   }
				  
				  if($this->upload->do_upload())
				  {
				     $pic = $this->upload->data();
				   
				  }
				
				   
				   
				   
				if ($this->form_validation->run() === FALSE)
				{ 
				       
						if($this->upload->do_upload())
						{
						   unlink("assets/drugs/".$pic['file_name']);
						}
						
					 $this->load->view('templates/header', $data);
					 $this->load->view('templates/mainheader', $data);
					 $this->load->view('pharmacy/create', $data);
					 $this->load->view('templates/footer');
				
				}
				else
				{
				
				
					$drug = $this->drug_master_model->getDrugByNameAndManufacturer($this->input->post("name"), $this->input->post("manufacturer"));
					
					
					$isBillingDataValPassed = true;
					$ruleValidationPassed = true;
					$foundDefault = false;
					$default_package_id = "";
					
					
				
					if(!$this->input->post("drug_bill_form"))
					{
						$isBillingDataValPassed = false;
					}
					else if(!$this->input->post("rule_count"))
					{
						$ruleValidationPassed = true;
					}
					else
					{
						$count = $this->input->post("rule_count");
						
						for($i = 0; $i < $count; $i++)
						{
							
							if(!$this->input->post("rule_".$i))
							{
								$ruleValidationPassed = false;
							}
														
						}
						
						$forms = $this->input->post("drug_bill_form");
						foreach($forms as $form)
						{
							if($this->input->post("def_".$form) == "yes")
							{
								$foundDefault = true;
								$default_package_id = $form;
							}						
						}
						
						
					}
					
					
				
					//validate picture upload if pic was selected, check if it is a valid format
					if($this->input->post('isPicSet') == "true" && ! $this->upload->do_upload())
					{
						$array = array('notice' => $this->upload->display_errors());
						$this->session->set_userdata($array);
						
						
						$this->load->view('templates/header', $data);
						$this->load->view('templates/mainheader', $data);
						$this->load->view('pharmacy/create', $data);
						$this->load->view('templates/footer');
					}
					else if(!$isBillingDataValPassed)
					{
						$array = array('notice' => "Must Select at least one billing form");
						
						$this->session->set_userdata($array);
						
						if($this->upload->do_upload())
						{
						   unlink("assets/drugs/".$pic['file_name']);
						}
						
			
						$this->load->view('templates/header', $data);
						$this->load->view('templates/mainheader', $data);
						$this->load->view('pharmacy/create', $data);
						$this->load->view('templates/footer');
					}
					else if(sizeof($drug) > 1)
					{
						$array = array('notice' => "Drug Already Exists");
						$this->session->set_userdata($array);
						
						if($this->upload->do_upload())
						{
						   unlink("assets/drugs/".$pic['file_name']);
						}
						
			
						$this->load->view('templates/header', $data);
						$this->load->view('templates/mainheader', $data);
						$this->load->view('pharmacy/create', $data);
						$this->load->view('templates/footer');
						
					}
					
					else if(!$ruleValidationPassed)
					{
						$array = array('notice' => "Invalid Rule Setup");
						$this->session->set_userdata($array);
						
						if($this->upload->do_upload())
						{
						   unlink("assets/drugs/".$pic['file_name']);
						}
						
			
						$this->load->view('templates/header', $data);
						$this->load->view('templates/mainheader', $data);
						$this->load->view('pharmacy/create', $data);
						$this->load->view('templates/footer');
					}
					else if(!$foundDefault)
					{
						$array = array('notice' => "Invalid Form Selection, Must Choose a default form");
						$this->session->set_userdata($array);
						
						if($this->upload->do_upload())
						{
						   unlink("assets/drugs/".$pic['file_name']);
						}
						
			
						$this->load->view('templates/header', $data);
						$this->load->view('templates/mainheader', $data);
						$this->load->view('pharmacy/create', $data);
						$this->load->view('templates/footer');
					}
					else if($this->input->post("initial_stock") > 0 && !$this->input->post("supplier")){
						
						$array = array('notice' => "Please Input the Supplier, Since Initial Stock is greater than 0");
						$this->session->set_userdata($array);
						
						
						$this->load->view('templates/header', $data);
						$this->load->view('templates/mainheader', $data);
						$this->load->view('pharmacy/create', $data);
						$this->load->view('templates/footer');
						
					}
					else if($this->input->post("initial_stock") > 0 && !$this->input->post("batch_number")){
						
						$array = array('notice' => "Please Input the Batch Number, Since Initial Stock is greater than 0");
						$this->session->set_userdata($array);
						
						
						$this->load->view('templates/header', $data);
						$this->load->view('templates/mainheader', $data);
						$this->load->view('pharmacy/create', $data);
						$this->load->view('templates/footer');
						
					}
					else if($this->input->post("initial_stock") > 0 && !$this->input->post("manufacture_date")){
						
						$array = array('notice' => "Please Input manufacture date of initial stock, Since Initial Stock is greater than 0");
						$this->session->set_userdata($array);
						
						
						$this->load->view('templates/header', $data);
						$this->load->view('templates/mainheader', $data);
						$this->load->view('pharmacy/create', $data);
						$this->load->view('templates/footer');
						
					}
					else if($this->input->post("initial_stock") > 0 && !$this->input->post("expiry_date")){
						
						$array = array('notice' => "Please Input the Expiry date of initial stock, Since Initial Stock is greater than 0");
						$this->session->set_userdata($array);
						
						
						$this->load->view('templates/header', $data);
						$this->load->view('templates/mainheader', $data);
						$this->load->view('pharmacy/create', $data);
						$this->load->view('templates/footer');
						
					}
					else
					{
						
						if(!$this->upload->do_upload())
						{
							$picture = "default.jpg";
						}
						else
						{
							$picture = $pic['file_name'];
						}
						
						$staff_no = $this->session->userdata('staff_no');
						
						
						//create drug
						$this->drug_master_model->set_drug($staff_no,$picture);
						
						//find created drug and create stock
						$drug = $this->drug_master_model->getDrugByNameAndManufacturer($this->input->post("name"),
													       $this->input->post("manufacturer"));
					
						//after uploading populate the stock
						
						//note if the stock is 0 just add a null dummy data
							
						$this->pharmacy_stock_model->set_Stock($staff_no,$drug['drug_id'],
										       $this->input->post("initial_stock"),
										       $default_package_id,
										       $this->input->post("batch_number"),
										       $this->input->post("manufacture_date"),
										       $this->input->post("expiry_date"));
						
						//create a new stock movement if stock is greater than 0
						
						if($this->input->post("initial_stock") > 0){
							$description = "Drug Creation : Initial Stock ";
							
							
							$this->stock_movement_model->set_stock_movement($this->input->post("supplier"),
										$description,
										$drug['drug_id'] ,
										$this->session->userdata("staff_no"),
										$this->input->post('initial_stock') ,
										$this->input->post('initial_stock') );
							
						}
						
						
						
						//populate drug bill master  information
						
						$packages = $this->input->post("drug_bill_form");
						
						foreach($packages as $package)
						{
							$weight_unit = null;
							$weight = null;
							
							if($this->input->post("value_".$package))
							{
								$weight = $this->input->post("value_".$package);
							}
							
							if($this->input->post("unit_".$package))
							{
								$weight = $this->input->post("unit_".$package);
							}
							
							
							
							$bill_package = $this->drug_bill_form_model->getDrugBillForms($package);

								$this->drug_price_master_model->set_drug_price_master(
													      $staff_no,
													      $this->input->post('drug_presentation_id'),
													      $package,
													      $this->input->post("currency_code"),
													      $this->input->post("price_".$package),
													      $drug['drug_id'],
													      $weight,
													      $weight_unit);
							
							$drug_price_master = $this->drug_price_master_model->getDrugPriceByPackage(
																   $drug['drug_id'],
																   $package);
							
							
							//add link to billing master
							$description = ucfirst($drug['name'])."( Sold by ".$bill_package['name']." )";
							if( $this->input->post('description'))
							{
								$description = $this->input->post('description');
							}
							
							$this->bill_master_model->set_drug_bill(
												$staff_no,
												$description,
												ucfirst($drug['name'])."( Sold by ".$bill_package['name']." )",
												$drug_price_master['unit_price'],
												$drug_price_master['drug_price_id']);
						
						}
						
						
						//create stock rules used to decrease stock accordingly
						
						$count = $this->input->post("rule_count");
						
						for($i = 0; $i < $count; $i++)
						{
							if($default_package_id == $this->input->post("rule_ref_".$i))
							{
								//skip the default package id
								continue;
							}
							
							$this->drug_stock_rules_model->setDrugStockRule($drug['drug_id'],
													$default_package_id,
													$this->input->post("rule_ref_".$i),
													$this->input->post("rule_".$i),
													$staff_no);					
						}
						
						
						
						$array = array('notice' => "Drug Created Successfully");
						$this->session->set_userdata($array);
						
						redirect("/pharmacy");
					
					}
					
					    
					   
		    
					
				}
			
		}
		else
		{
			redirect('/login');
		}
	}
	
	public function updateStock()
	{
		if($this->session->userdata('logged_in'))		
		{
			$this->confirmUrl();			
			$this->moduleAccessCheck(UPDATE_DRUG);
			
			$return_url = "/pharmacy";
			
			if($this->input->post("drug_id"))
			{
				$return_url = $return_url."/view/".$this->input->post("drug_id");
				
			}
			
			if(!$this->input->post("qty") || !$this->input->post("drug_id") )
			{
				$array = array('notice' => "Not Permitted" );
				$this->session->set_userdata($array);
				redirect($return_url);
				
			}
			
			
			
			$drug = $this->drug_master_model->getDrug($this->input->post("drug_id"));
			
			if(!$drug)
			{
				$array = array('notice' => "Invalid Drug" );
				$this->session->set_userdata($array);
				redirect($return_url);
			}
			//get the current stock in the pharmacy
		
			$stock = $this->pharmacy_stock_model->getStockByBatchNumber($this->input->post("drug_id"),
										    $this->input->post("batch_number"));
			
			
			
			if($stock){
				$newStock = $stock["qty_in_stock"] + $this->input->post("qty");
				
				if($newStock < 0)
				{
					$array = array('notice' => "Stock Quantity Cannot fall below 0" );
					$this->session->set_userdata($array);
					redirect($return_url);
				}
				
				//update stock new quantity in the database
				$data['qty_in_stock'] = $newStock;
				
				$this->general_update_model->update("pharmacy_stock","drug_id",$this->input->post("drug_id"), $data);
				
			
			//update reference in database for logging purposes
			$supplier = NULL;
			$description = NULL;
			
			if($this->input->post("sup_name"))
			{
				$supplier = $this->input->post("sup_name");
			}
			
			if($this->input->post("details"))
			{
				$description = $this->input->post("details");
			}
			
			
			
			$this->stock_movement_model->set_stock_movement($supplier,
									$description,
									$this->input->post('drug_id') ,
									$this->session->userdata("staff_no"),
									$this->input->post('qty') ,
									$newStock);
			
			
			
			
			
			
			
			$array = array('notice' => "Stock Updated Successfully" );
				$this->session->set_userdata($array);
				redirect($return_url);
			}
			//create a new batch record here
			else{
				
				
			
				$stock = $this->pharmacy_stock_model->getStock($this->input->post("drug_id"));
						
				
				$batch_no = $this->input->post("batch_number");
				$manufacture_date = $this->input->post("manufacture_date");
				$expiry_date = $this->input->post("expiry_date");
				$staff_no = $this->session->userdata("staff_no");
				$no_in_stock = $this->input->post("qty");
				$drug_bill_package_id = $stock[0]["drug_bill_package_id"];
				
				
				$drug_id = $this->input->post("drug_id");
				 
				$this->pharmacy_stock_model->
				set_Stock($staff_no,$drug_id, $no_in_stock,$drug_bill_package_id,$batch_no,
					  $manufacture_date,$expiry_date);
				
				$supplier = NULL;
				$description = NULL;
				
			
				if($this->input->post("sup_name"))
				{
					$supplier = $this->input->post("sup_name");
				}
				
				if($this->input->post("details"))
				{
					$description = $this->input->post("details");
				}
				
				$description = "New Stock with batch number :  "+$batch_no." Other details : ".$description;
				
				$this->stock_movement_model->set_stock_movement($supplier,
										$description,
										$this->input->post('drug_id') ,
										$this->session->userdata("staff_no"),
										$this->input->post('qty') ,
										$no_in_stock);
				
				$array = array('notice' => "Stock Updated Successfully" );
				$this->session->set_userdata($array);
				redirect($return_url);
				
			}
			
			
			
			
			
		}
		else{
			
			redirect("/login");
		}
	}
	
	public function updateDrugBill()
	{
		if($this->session->userdata('logged_in'))		
		{
			$this->confirmUrl();
			$this->moduleAccessCheck(UPDATE_DRUG_PRICE);
			
			$return_url = "/pharmacy";
			
			if($this->input->post("drug_id"))
			{
				$return_url = $return_url."/view/".$this->input->post("drug_id");
				
			}
			
			if(!$this->input->post("drug_id"))
			{
				$array = array('notice' => "Not Permitted" );
				$this->session->set_userdata($array);
				redirect($return_url);
				
			}
			
			$drug = $this->drug_master_model->getDrug($this->input->post("drug_id"));
			
			if(!$drug)
			{
				$array = array('notice' => "Invalid Drug" );
				$this->session->set_userdata($array);
				redirect($return_url);
			}
			
			
			
			$drug_package_prices = $this->drug_price_master_model->getDrugPriceMasterByDrug($this->input->post("drug_id"));
			
			$isValidationPassed = true;
			$pricesToUpdate = NULL;
			
			$counter = 0;
			foreach($drug_package_prices as $price)
			{
				if(!$this->input->post('price_'.$price['drug_price_id']))
				{
					$isValidationPassed = false;
					$array = array('notice' => "Not Permitted" );
					$this->session->set_userdata($array);
				}
				else if(!is_numeric($this->input->post('price_'.$price['drug_price_id'])))
				{
					$isValidationPassed = false;
					$array = array('notice' => "Invalid Update Amount" );
					$this->session->set_userdata($array);
					
				}
				else if($this->input->post('price_'.$price['drug_price_id']) != $price['unit_price'])
				{
					$pricesToUpdate[$counter]['drug_id'] = $this->input->post("drug_id");
					$pricesToUpdate[$counter]['old_price'] = $price['unit_price'];
					$pricesToUpdate[$counter]['new_price'] = $this->input->post('price_'.$price['drug_price_id']);
					$pricesToUpdate[$counter]['drug_price_id'] = $price['drug_price_id'];
					$pricesToUpdate[$counter]['bill_package_info'] = $this->drug_bill_form_model->getDrugBillForms($price['drug_bill_package_id']);
					
					
					$counter++;
				}
				
			}
			
			if(!$isValidationPassed)
			{
				redirect($return_url);
			}
			
			if(!$pricesToUpdate)
			{
				redirect($return_url);
			}
			
			$message = "";
			//update the all the prices
			foreach($pricesToUpdate as $update)
			{
				
				$data['unit_price'] = $update["new_price"];
				
				$message = $drug['name']." sold in ".$update["bill_package_info"]["name"]."'s price updated from #".$update["old_price"]." to #".$update["new_price"]."<br/>";
				//update drug price master
			        $this->general_update_model->update("drug_price_master","drug_price_id",$update["drug_price_id"], $data);
				
				//update bill master
				 $this->general_update_model->update("bill_master","drug_price_id",$update["drug_price_id"], $data);
				
				
			}
			
			//send a message to all users who have access to the pharmacy module with the change in prices	
		
			$title = "Pharmacy update. Drug : ".$drug['name']." Price Udpate";			
			$this->message->sendChangeAlert(MODULE_NO, $title, $message, "2005/10/01");
			
			
			
			//add an entry in the system log to show change
			
			$array = array('notice' => "Drug Price Successfully updated " );
			$this->session->set_userdata($array);
			redirect($return_url);
		}
		else
		{
			redirect("/login");
		}
	}
	
	public function view($drug_id = FALSE)
	{
		if($this->session->userdata('logged_in'))		
		{
			$this->confirmUrl();
			
			$this->moduleAccessCheck(VIEW_DRUG);
			
			if($drug_id === FALSE)
			{
				redirect('/pharmacy');
			}
			
			//confirm if drug exists
			
			$drug = $this->drug_master_model->getDrug($drug_id);
			
			if(!$drug)
			{
				redirect('/pharmacy');
			}
			
			$data['currencies'] = $this->currency_model->getCurrency();
			
			$data['drug_bill_forms'] = $this->drug_bill_form_model->getDrugBillForms();
			
			$data['drug_presentations'] = $this->drug_presentation_model->getDrugPresentation();
			
			$data['billing_points'] = $this->drug_price_master_model->getDrugPriceMasterByDrug($drug_id);
			
			$counter = 0;
			foreach($data['billing_points'] as $point)
			{
				$data['billing_points'][$counter]['bill_package_info'] =  $this->drug_bill_form_model->getDrugBillForms($point['drug_bill_package_id']);
				
				$counter++;
			}
			
		
			//get all drug stock
			$drug['stock'] = $this->pharmacy_stock_model->getActiveStock($drug_id);
			
			$totalInStock = 0;
			foreach($drug['stock']  as $stock){
				$totalInStock = $totalInStock + $stock['qty_in_stock'];
			}
			
		
			
			$data['qty_in_stock'] = $totalInStock;
			
			if(sizeof($drug['stock']) > 0){
				
				$data['drug_bill_form'] = $this->drug_bill_form_model->getDrugBillForms($drug['stock'][0]['drug_bill_package_id']);

			}else{
				
				$inactiveStock = $this->pharmacy_stock_model->getStock($drug_id);
				$data['drug_bill_form'] = $this->drug_bill_form_model->getDrugBillForms($inactiveStock[0]['drug_bill_package_id']);

			}
			
			$data['rules'] = $this->drug_stock_rules_model->getDrugStockRule($drug_id);
			
			$counter = 0;
			foreach($data['rules']  as $rule){
				
				$form = $this->drug_bill_form_model->getDrugBillForms($rule['multiplied_package_id']);
				$data['rules'][$counter]['rule_desc'] = $rule["multiplier"]." ".$form["name"]."(s) is/are contained in 1 ".$data['drug_bill_form']["name"] ."(s)";
				$counter++;
			}
			
		
		
			$drug['price_data'] = $this->drug_price_master_model->getDrugPriceMasterByDrug($drug_id);
			
			$data['title'] = "Medstation | Pharmacy";
			$data['content-description'] = "Pharmacy";
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));			
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			$data['drug'] = $drug;
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/mainheader', $data);
			$this->load->view('pharmacy/view');
			$this->load->view('templates/footer');
 			
			
		}
		else
		{
			redirect('/login');
		}
	}
        public function index()
        {
            	if($this->session->userdata('logged_in'))
		
			{
				
			$this->confirmUrl();
			$this->moduleAccessCheck(VIEW_PHARMACY_HOME);
			
			$data['title'] = "Medstation | Pharmacy";
			 $data['content-description'] = "Pharmacy";
		
			//get all user module mappings by role
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			
			$data['dispense_without_payment'] = false;
			
			if($this->utilities->userHasAccess(DISPENSE_WITHOUT_PAYMENT))
			{
				$data['dispense_without_payment'] = true;
				
			}
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/mainheader', $data);
			$this->load->view('pharmacy/home');
			$this->load->view('templates/footer');
			
			
				
			
			
		}
		else{
			redirect('/login');
		}
        }

	
  
}