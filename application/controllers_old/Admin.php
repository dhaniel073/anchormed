<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

define ('MODULE_NO', 6);
define ('TITLE', 'Hospital Admin');
define ('SUB_MODULE_NO',3);
define ('ADMIN',3);
define ('DEFINE_SHIFT', 14);
define ('DELETE_SHIFT', 15);
define ('UPDATE_SHIFT', 16);
define ('CHANGE_LOGO', 18);
define ('DEFINE_BILLABLE_ITEM', 19);
define ('EIDT_BASE_DATA', 20);
define ('CREATE_DEPARTMENT', 26);
define ('UPDATE_ROLE', 29);
define ('UPDATE_DEPARTMENT', 30);
define ('CHANGE_USER_GROUP', 32);
define ('CREATE_WARD', 33);
define ('EDIT_WARD', 34);
define ('DELETE_WARD', 35);
define('INVALID_FUNCTION_CALL', 'Action not permitted');

class Admin extends CI_Controller {

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
		$this->load->model('sub_module_map_model');
		$this->load->model('user_groups_model');
		$this->load->model('shift_model');
		$this->load->model('general_update_model');
		$this->load->model('bill_master_model');
		$this->load->model('bloodgrp_model');
		$this->load->model('phenotype_model');
		$this->load->model('marital_model');
		$this->load->model('country_model');
		$this->load->model('lga_model');
		$this->load->model('state_model');
		$this->load->model('ward_model');
		$this->load->model('bed_model');
		$this->load->model('patient_admission_model');
		$this->load->model('drug_presentation_model');
		$this->load->model('drug_bill_form_model');
		$this->load->model('unit_model');
		$this->load->model('free_code_model');
		$this->load->model('free_code_2_model');
		$this->load->model('tasks_model');
		$this->load->model('intake_type_model');
		$this->load->model('output_type_model');
		$this->load->model('delivery_type_model');
		$this->utilities->loadUserLang();
		
		
		
	}

	
	public function deleteDrugBillForm()
		{
			$this->utilities->aunthenticateAccess(DELETE_DRUG_BILL_FORM, "admin");
			
			if(!$this->input->post("drug_bill_package_id"))
			{
				$this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
			}
			
			$formExists = $this->drug_bill_form_model->getDrugBillForms($this->input->post("drug_bill_package_id"));
			
			if(!$formExists)
			{
				$this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
			}
			
			$data["status"] = "D";
		       
		    
		       $this->general_update_model->update("drug_bill_package_type","drug_bill_package_id",$this->input->post("drug_bill_package_id"),
							   $data);
		       
		       
		       $this->utilities->redirectWithNotice("admin",$this->lang->line(DELETE_DRUG_BILL_FORM_SUCCESS));
		}
	public function deleteDosageForm()
		{
			
			$this->utilities->aunthenticateAccess(DELETE_DOSAGE_FORM, "admin");
			
			
			if(!$this->input->post("dosage_form_id"))
			{
				$this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
			}
			
			$formExists = $this->drug_presentation_model->getDrugPresentation($this->input->post("dosage_form_id"));
			
			if(!$formExists)
			{
				$this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
			}
			
			
		       //update form with new description
		       $data["status"] = "D";
		       
		    
		       $this->general_update_model->update("drug_presentation_master_","drug_presentation_id",$this->input->post("dosage_form_id"),
							   $data);
		       
		       
		       $this->utilities->redirectWithNotice("admin",$this->lang->line(DELETE_DOSAGE_FORM_SUCCESS));
		}
	public function deleteBasedata()
	{
		$this->utilities->aunthenticateAccess(DELETE_BASEDATA, "admin");
		
		if(!$this->input->post("basedata_type"))
		{
			$this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
		}
		
		$data["status"] = "D";
		
		if($this->input->post("basedata_type") == "bloodgroup")
		{			
		      if(!$this->input->post("blood_group_id"))
		      {
			$this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
		      }
		  
		       $this->general_update_model->update("blood_group","blood_group_id",$this->input->post("blood_group_id"),
							   $data);
		       
		       $this->utilities->redirectWithNotice("home",$this->lang->line(DELETE_BASEDATA_SUCCESS));
		
		}
		else if($this->input->post("basedata_type") == "genotype")
		{
			if(!$this->input->post("phenotype_id"))
			{
			  $this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
			}
		  
		       $this->general_update_model->update("phenotype","phenotype_id",$this->input->post("phenotype_id"),
							   $data);
		       
		       $this->utilities->redirectWithNotice("home",$this->lang->line(DELETE_BASEDATA_SUCCESS));
		}
		else if($this->input->post("basedata_type") == "marital_status")
		{
			if(!$this->input->post("marital_status"))
			{
			  $this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
			}
		  
		       $this->general_update_model->update("marital_stats","id",$this->input->post("marital_status"),
							   $data);
		       
		       $this->utilities->redirectWithNotice("home",$this->lang->line(DELETE_BASEDATA_SUCCESS));
		}
		
		else if($this->input->post("basedata_type") == "country")
		{
			if(!$this->input->post("country_code"))
			{
			  $this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
			}
		  
		       $this->general_update_model->update("country","country_code",$this->input->post("country_code"),
							   $data);
		       
		       $this->utilities->redirectWithNotice("home",$this->lang->line(DELETE_BASEDATA_SUCCESS));
		}
		
		else if($this->input->post("basedata_type") == "state")
		{
			if(!$this->input->post("state_code"))
			{
			  $this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
			}
		  
		       $this->general_update_model->update("state","state_code",$this->input->post("state_code"),
							   $data);
		       
		       $this->utilities->redirectWithNotice("home",$this->lang->line(DELETE_BASEDATA_SUCCESS));
		}
		
		else if($this->input->post("basedata_type") == "lga")
		{
			if(!$this->input->post("lga_id"))
			{
			  $this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
			}
		  
		       $this->general_update_model->update("lga","lga_id",$this->input->post("lga_id"),
							   $data);
		       
		       $this->utilities->redirectWithNotice("home",$this->lang->line(DELETE_BASEDATA_SUCCESS));
		}
		
		else if($this->input->post("basedata_type") == "unit")
		{
			if(!$this->input->post("unit"))
			{
			  $this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
			}
		  
		       $this->general_update_model->update("unit_of_measure","id",$this->input->post("unit"),
							   $data);
		       
		       $this->utilities->redirectWithNotice("home",$this->lang->line(DELETE_BASEDATA_SUCCESS));
		}
		
		$this->utilities->redirectWithNotice("home",$this->lang->line(UNKNOWN_BASEDATA));
	}
	public function updateDosageForm()
	{
		
		$this->utilities->aunthenticateAccess(UPDATE_DOSAGE_FORM, "admin");
		
		
		if(!$this->input->post("dosage_form_id"))
		{
			$this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
		}
		
		$formExists = $this->drug_presentation_model->getDrugPresentation($this->input->post("dosage_form_id"));
		
		if(!$formExists)
		{
			$this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
		}
		
		
	       //update form with new description
	       $data["description"] = $this->input->post("description");
	       
	    
	       $this->general_update_model->update("drug_presentation_master_","drug_presentation_id",$this->input->post("dosage_form_id"),
						   $data);
	       
	       
	       $this->utilities->redirectWithNotice("admin",$this->lang->line(UPDATE_DOSAGE_FORM_SUCCESS));
	}
	public function createDrugBillForm()
	{
		
		$this->utilities->aunthenticateAccess(CREATE_DRUG_BILL_FORM, "admin");
		
		if(!$this->input->post("name"))
		{
			$this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
		}
		
		
		$isBillFormExist = $this->drug_bill_form_model->getDrugBillByName($this->input->post("name"));
		
		if($isBillFormExist)
		{
			$this->utilities->redirectWithNotice("admin",$this->lang->line(DRUG_BILL_FORM_ALREADY_EXIST));
		}
		
		$this->drug_bill_form_model->set_drug_bill_form($this->session->userdata("staff_no"),
								$this->input->post("name"));
		
		$this->utilities->redirectWithNotice("admin",$this->lang->line(CREATE_DRUG_BILL_FORM_SUCCESS));
	}
	public function addUnit()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "admin");
		
		if(!$this->input->post("unit_name") || !$this->input->post("symbol"))
		{
			$this->utilities->redirectWithNotice("admin",$this->lang->line(INVALID_FUNC_CALL));
		}
		
		$isUnitExist = $this->unit_model->getUnitByName($this->input->post("unit_name"));
		if($isUnitExist)
		{
			$this->utilities->redirectWithNotice("admin",$this->lang->line(UNIT_NAME_ALREADY_EXIST));
		}
		
		$isUnitExist = $this->unit_model->getUnitBySymbol($this->input->post("symbol"));
		
		
		if($isUnitExist)
		{
			$this->utilities->redirectWithNotice("admin",$this->lang->line(UNIT_SYMBOL_ALREADY_EXIST));
		}
		
		
		$this->unit_model->set_unit($this->input->post("unit_name"), $this->input->post("symbol"),
					    $this->session->userdata("staff_no"));
		
		$this->utilities->redirectWithNotice("admin",$this->lang->line(UNIT_CREATE_SUCCESS));
		
		
	}
	public function createDosageForm()
	{
		$this->utilities->aunthenticateAccess(CREATE_DOSAGE_FORM, "admin");
		
		if(!$this->input->post("name"))
		{
			$this->utilities->redirectWithNotice("home",$this->lang->line(INVALID_FUNC_CALL));
		}
		
		//confirm dosage has not been created before
		$formExists = $this->drug_presentation_model->getDrugPresentationByName($this->input->post("name"));
		
		if($formExists)
		{
			$this->utilities->redirectWithNotice("admin",$this->lang->line(DOSAGE_FORM_ALREADY_EXIST));
		}
		
		$description = NULL;
		
		if($this->input->post("description"))
		{
			$description = 	$this->input->post("description");		
		}
		$this->drug_presentation_model->set_drug_presentation($this->session->userdata("staff_no"),
								      $this->input->post("name"),
								      $description);
		
		
		$this->utilities->redirectWithNotice("admin",$this->lang->line(CREATE_DOSAGE_FORM_SUCCESS));
	}
	public function updateBillDef()
	{
		$this->utilities->aunthenticateAccess(DEFINE_BILLABLE_ITEM, "home");
		
			if($this->input->post('bill_id'))
			{
				$date = new DateTime();
				date_timezone_set($date, timezone_open('Africa/Lagos'));
				$todaysDate =  date_format($date, 'Y-m-d H:i:s');
				
				$table_name = "bill_master";
				$id = "bill_id";
				$id_value = $this->input->post('bill_id');
				$modified_by = $this->session->userdata('staff_no');
				
				$service_name = $this->input->post('service_name') ;
				$description = $this->input->post('description') ;
				$unit_price = $this->input->post('unit_price') ;
			
                //check if bill is a pharmacy bill
                $bill = $this->bill_master_model->getBill($id_value);

                //check if the bill is equal to deposit then return system
                if(strtolower($bill['service_name']) == "deposit"){

                    $array = array('notice' =>"Cannot modify system bill, 'Deposit'");
                    $this->session->set_userdata($array);
                    redirect('/admin');

                }
			
			if($bill['drug_price_id'] != "" || $bill['drug_price_id'] != null)
			{
				$array = array('notice' =>"Bill is attached to a drug, please update from Pharmacy Module");
				$this->session->set_userdata($array);
				redirect('/admin');
			}
			 
			      $data = array(
					'modified_by' => $modified_by,					
					'date_modified' => $todaysDate
				);
			      
			      if($service_name)
			      {
				$data['service_name'] = $service_name;
			      }
			      
			       if($description)
				{
				  $data['description'] = $description;
				}
			      
			       if($this->input->post('unit_price'))
				{
				  $data['unit_price'] = $unit_price;
				}
			
			$this->general_update_model->update($table_name,$id,$id_value, $data);
				
				
				$array = array('notice' =>"Bill Updated");
				$this->session->set_userdata($array);
				redirect('/home');
				
			}
			else
			{
				$array = array('notice' =>"Invalid Request");
				$this->session->set_userdata($array);
				redirect('/home');
				
			}
		}
	public function deleteBillDef()
	{
		$this->utilities->aunthenticateAccess(DEFINE_BILLABLE_ITEM, "home");
			
			if($this->input->post('bill_id'))
			{
				$date = new DateTime();
				date_timezone_set($date, timezone_open('Africa/Lagos'));
				$todaysDate =  date_format($date, 'Y-m-d H:i:s');
				
				$table_name = "bill_master";
				$id = "bill_id";
				$id_value = $this->input->post('bill_id');
				
				
				
				$bill = $this->bill_master_model->getBill($id_value);

                //check if the bill is equal to deposit then return system
                if(strtolower($bill['service_name']) == "deposit"){

                    $array = array('notice' =>"Cannot modify system bill, 'Deposit'");
                    $this->session->set_userdata($array);
                    redirect('/admin');

                }


				if($bill['drug_price_id'] != "" || $bill['drug_price_id'] != null)
				{
					$array = array('notice' =>"Bill is attached to a drug, please update from Pharmacy Module");
					$this->session->set_userdata($array);
					redirect('/admin');
				}

				  $data = array(
					'status' => 'D',
					'modified_by' => $this->session->userdata('staff_no'),					
					'date_modified' => $todaysDate
				);
				
				$this->general_update_model->update($table_name,$id,$id_value, $data);
				
			}
			else
			{
				$array = array('notice' =>"Invalid Request");
				$this->session->set_userdata($array);
				redirect('/home');
			}
			
			
		}
	public function createWard()
	{
		
		$this->utilities->aunthenticateAccess(CREATE_WARD, "home");
		
			
			if($this->input->post('ward_name') && $this->input->post('ward_bed_limit'))
			{
				//check if ward name already exists in the system
				$ward = $this->ward_model->getWardByName($this->input->post('ward_name'));
				
				if($ward)
				{
					$array = array('notice' =>"Ward Already exists");
					$this->session->set_userdata($array);
					redirect('/admin');
					
				}
				else if($this->input->post('ward_bed_limit') < 1)
				{
					$array = array('notice' =>"Invalid Ward Bed Limit");
					$this->session->set_userdata($array);
					redirect('/admin');
				}
				else
				{					
					$return = $this->ward_model->set_Ward();
					if($return)
					{
						$array = array('notice' =>"Ward Sucessfully created");
					}
					else
					{
						$array = array('notice' =>"Ward not created");
					}
					
					$this->session->set_userdata($array);
					redirect('/admin');
				}
			}
			else{
				
				$array = array('notice' =>"Invalid Request");
					$this->session->set_userdata($array);
				redirect('/home');
			}
		
	}
	public function defineNewTask()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
		if(!$this->input->post('task_name'))
		{
			$this->utilities->redirectWithNotice('home', $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$task = $this->tasks_model->getTaskByName($this->input->post("task_name"));
		
		if($task)
		{
			$this->utilities->redirectWithNotice('home', $this->lang->line(TASK_ALREADY_EXIST));
		}
		
		
		$this->tasks_model->set_Task($this->input->post("task_name"), $this->input->post("task_description"));
		
		
		$this->utilities->redirectWithNotice('admin', $this->lang->line(TASK_CREATED));
	}
	public function delTask()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
		if(!$this->input->post('task_id'))
			{
				$this->utilities->redirectWithNotice('home', $this->lang->line(INVALID_FUNC_CALL));
			}
			
		$data["status"] = "D";
                $this->general_update_model->update("in_patient_tasks_master","task_id",$this->input->post("task_id"), $data);
			
		$this->utilities->redirectWithNotice('admin', $this->lang->line(TASK_DELETED));
		
	}
	public function delFreeCode()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
		if(!$this->input->post('free_code_id'))
			{
				$this->utilities->redirectWithNotice('home', $this->lang->line(INVALID_FUNC_CALL));
			}
			
			
		$data["status"] = "D";
                $this->general_update_model->update("free_code","id",$this->input->post("free_code_id"), $data);
			
		$this->utilities->redirectWithNotice('admin', $this->lang->line(FREE_CODE_DELETED));
	}
	public function delFreeCode2()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
		if(!$this->input->post('free_code_id'))
			{
				$this->utilities->redirectWithNotice('home', $this->lang->line(INVALID_FUNC_CALL));
			}
			
			
		$data["status"] = "D";
                $this->general_update_model->update("free_code_2","id",$this->input->post("free_code_id"), $data);
			
		$this->utilities->redirectWithNotice('admin', $this->lang->line(FREE_CODE_DELETED));
	}
	public function addFreeCode2()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
		if(!$this->input->post('name'))
		{
			$this->utilities->redirectWithNotice('home', $this->lang->line(INVALID_FUNC_CALL));
		}
		
		//check if free code already exist
		
		$freeCode = $this->free_code_2_model->getFreeCodeByName($this->input->post("name"));
		
		if($freeCode)
		{
			$this->utilities->redirectWithNotice('home', $this->lang->line(FREE_CODE_ALREADY_EXIST));
		}
		
		
		$this->free_code_2_model->set_FreeCode($this->input->post("name"));
		
		
		$this->utilities->redirectWithNotice('admin', $this->lang->line(FREE_CODE_CREATED));
		
	}
	public function addFreeCode()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
		if(!$this->input->post('name'))
		{
			$this->utilities->redirectWithNotice('home', $this->lang->line(INVALID_FUNC_CALL));
		}
		
		//check if free code already exist
		
		$freeCode = $this->free_code_model->getFreeCodeByName($this->input->post("name"));
		
		if($freeCode)
		{
			$this->utilities->redirectWithNotice('home', $this->lang->line(FREE_CODE_ALREADY_EXIST));
		}
		
		
		$this->free_code_model->set_FreeCode($this->input->post("name"));
		
		
		$this->utilities->redirectWithNotice('admin', $this->lang->line(FREE_CODE_CREATED));
		
	}
	public function addGenotype()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
			if($this->input->post('phenotype_code'))
			{
				//check if blood grp already exists in the system
				$genotype = $this->phenotype_model->getPhenotypeByCode($this->input->post('phenotype_code'));
				
				if($genotype)
				{
					$array = array('notice' =>"Genotype Already exists");
					$this->session->set_userdata($array);
					redirect('/admin');
					
				}
				
				else
				{
					
					$this->phenotype_model->set_Phenotype();
					
					$array = array('notice' =>"Genotype Sucessfully created");
					$this->session->set_userdata($array);
					redirect('/admin');
				}
			}
			else{
				
				$array = array('notice' =>"Invalid Request");
					$this->session->set_userdata($array);
				redirect('/home');
			}
			
		
	}
	public function addLga()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
			if($this->input->post('lga_name'))
			{
				//check if blood grp already exists in the system
				$lga = $this->lga_model->getLgaByName($this->input->post('lga_name'));
				
				$error = FALSE;
				if($lga)
				{
					$state_code = $this->input->post('state_code');
					
					if($state_code == $lga['state_code'])
					{
						$error = TRUE;
						
						$array = array('notice' =>"LGA  Already assigned to state");
						$this->session->set_userdata($array);
						redirect('/admin');
					}
					
					
					
				}
				
				if(!$error)
				{
						$this->lga_model->set_lga();
					
						$array = array('notice' =>"Lga Sucessfully created");
						$this->session->set_userdata($array);
						redirect('/admin');
					
					
				}
			}
			else{
				
				$array = array('notice' =>"Invalid Request");
					$this->session->set_userdata($array);
				redirect('/home');
			}
			
		
	}
	public function addState()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
			if($this->input->post('state_code'))
			{
				//check if blood grp already exists in the system
				$state = $this->state_model->getState($this->input->post('state_code'));
				
				if($state)
				{
					$array = array('notice' =>"State Already exists");
					$this->session->set_userdata($array);
					redirect('/admin');
					
				}
				
				else
				{
						$this->state_model->set_State();
					
						$array = array('notice' =>"State Sucessfully created");
						$this->session->set_userdata($array);
						redirect('/admin');
					
					
				}
			}
			else{
				
				$array = array('notice' =>"Invalid Request");
					$this->session->set_userdata($array);
				redirect('/home');
			}
			
	
	}
	public function addCountry()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
			if($this->input->post('country_code'))
			{
				//check if blood grp already exists in the system
				$country = $this->country_model->getCountries($this->input->post('country_code'));
				
				if($country)
				{
					$array = array('notice' =>"Country Already exists");
					$this->session->set_userdata($array);
					redirect('/admin');
					
				}
				
				else
				{
					$country = null;
					$country = $this->country_model->getCountryByName($this->input->post('country_name'));
					
					if($country)
					{
						$array = array('notice' =>"Country Already exists");
						$this->session->set_userdata($array);
						redirect('/admin');
					}
					else{
						
						$this->country_model->set_Country();
					
						$array = array('notice' =>"Country Sucessfully created");
						$this->session->set_userdata($array);
						redirect('/admin');
						
					}
					
					
				}
			}
			else{
				
				$array = array('notice' =>"Invalid Request");
					$this->session->set_userdata($array);
				redirect('/home');
			}
			
		
	}
	public function addBloodGroup()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
			if($this->input->post('blood_group_code'))
			{
				//check if blood grp already exists in the system
				$bloodgrp = $this->bloodgrp_model->getBloodgrpByCode($this->input->post('blood_group_code'));
				
				if($bloodgrp)
				{
					$array = array('notice' =>"Blood Group Already exists");
					$this->session->set_userdata($array);
					redirect('/admin');
					
				}
				
				else
				{
					
					$this->bloodgrp_model->set_Bloodgrp();
					
					$array = array('notice' =>"Blood Group Sucessfully created");
					$this->session->set_userdata($array);
					redirect('/admin');
				}
			}
			else{
				
				$array = array('notice' =>"Invalid Request");
					$this->session->set_userdata($array);
				redirect('/home');
			}
			
		
	}
	public function deleteShift()
	{
		
		$this->utilities->aunthenticateAccess(DELETE_SHIFT, "home");
			if(!$this->input->post('shift_id'))
			{
				$array = array('notice' => INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/home');
			}
			
			$this->shift_model->deleteShift($this->input->post('shift_id'));
			
			$array = array('notice' => "Shift Sucessfully Deleted");
				$this->session->set_userdata($array);
				redirect('/admin');
		
		
		
		
	}
	public function deleteUserGroup()
	{
		$this->utilities->aunthenticateAccess(DELETE_USER_GROUP, "admin");
		
		if(!$this->input->post("user_group_id"))
		{
			$this->utilities->redirectWithNotice("admin", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		
		$user_group = $this->user_groups_model->getUserGroups($this->input->post("user_group_id"));
		
		if(!$user_group)
		{
			$this->utilities->redirectWithNotice("admin", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		//check if any user belongs to group before deleting
		$membersOfGroups = $this->user_groups_model->getUserGroupMembers($this->input->post("user_group_id"));
		
		if($membersOfGroups)
		{
			$this->utilities->redirectWithNotice("admin", $this->lang->line(REMOVE_USERS_FROM_GROUP));
		}
		
		      $data["status"] = "D";
                      $this->general_update_model->update("user_group","user_group_id",$this->input->post("user_group_id"), $data);
		      
		      
		      $this->utilities->redirectWithNotice("admin", $this->lang->line(GROUP_DELETED));
		
	}
	public function updateRole()
	{
		$this->utilities->aunthenticateAccess(UPDATE_ROLE, "admin");
		
			
			if($this->input->post('role_id') && $this->input->post('staff_no'))
			{
				$date = new DateTime();
				date_timezone_set($date, timezone_open('Africa/Lagos'));
				$todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
				
				$table_name = "staff_master";
				$id = "staff_no";
				$id_value = $this->input->post('staff_no');
			
			
			    
			    
			      $data = array(
					'role_id' => $this->input->post('role_id'),					
					'date_modified' => $todaysDate
				);
			
				$this->general_update_model->update($table_name,$id,$id_value, $data);
				
				$array = array('notice' => "Role sucessfully updated");
						$this->session->set_userdata($array);
						      redirect('/staff/number/'.$this->input->post('staff_no'));
			}
			else
			{
				$array = array('notice' => INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/admin');
			}
		
		
	}
	public function updateGroup()
	{
		$this->utilities->aunthenticateAccess(CHANGE_USER_GROUP, "admin");
		
			
			if($this->input->post('group_id') && $this->input->post('staff_no'))
			{
				$date = new DateTime();
				date_timezone_set($date, timezone_open('Africa/Lagos'));
				$todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
				
				$table_name = "staff_master";
				$id = "staff_no";
				$id_value = $this->input->post('staff_no');
			
			
			    
			    
			      $data = array(
					'group_id' => $this->input->post('group_id'),					
					'date_modified' => $todaysDate
				);
			
				$this->general_update_model->update($table_name,$id,$id_value, $data);
				
				$array = array('notice' => "User Group sucessfully updated");
						$this->session->set_userdata($array);
						      redirect('/staff/number/'.$this->input->post('staff_no'));
			}
			else
			{
				$array = array('notice' => INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/admin');
			}
		
		
	}
	public function removeBedFromWard()
	{
		
		$this->utilities->aunthenticateAccess(EDIT_WARD, "admin");
		
			if($this->input->post('ward_to_add_bed'))
			{
				$ward = $this->ward_model->getWard($this->input->post('ward_to_add_bed'));
				$admitted_patients = $this->patient_admission_model->getPatientByWard($this->input->post('ward_to_add_bed'));
				$beds = $this->bed_model->getBedByWard($this->input->post('ward_to_add_bed'));
				$number_of_beds = ceil($this->input->post('num_beds'));
				
				if(sizeof($admitted_patients) > 0)
				{
					$array = array('notice' => "Reallocate Patients in Ward First");
					$this->session->set_userdata($array);
					redirect('/admin');
				}
				else if((sizeof($beds) - $number_of_beds) < 0)
				{
					$array = array('notice' => "Number of beds to be deleted cannot be greater than number of beds in ward");
					$this->session->set_userdata($array);
					redirect('/admin');
				}
				else
				{
					for($i = sizeof($beds); $i > 0; $i--)
					{
						if($number_of_beds < 1)
						{
							break;
						}
						$this->bed_model->remove_bed($beds[$i-1]['bed_id']);
						$number_of_beds--;						
					}
					
					$array = array('notice' => "All Beds sucessfully deleted");
					$this->session->set_userdata($array);
					redirect('/admin');
				}
				
			}
			else
			{
				redirect('/login');
			}
		
	}
	public function addBedToWard()
	{
		
		$this->utilities->aunthenticateAccess(EDIT_WARD, "admin");
		
			if($this->input->post('ward_to_add_bed'))
			{
				$ward = $this->ward_model->getWard($this->input->post('ward_to_add_bed'));
				$beds = $this->bed_model->getBedByWard($this->input->post('ward_to_add_bed'));
				
				if(($this->input->post('num_beds') + sizeof($beds)) > $ward['ward_bed_limit'])
				{
					$array = array('notice' => "Maximum Bed Limit Exceeded");
					$this->session->set_userdata($array);
					redirect('/admin');
				}
				else{
					//add beds since within the limits
					$first_bed_number = sizeof($beds) + 1;
					
					$number_to_add = ceil($this->input->post('num_beds'));
					
					for($i = 0; $i < $number_to_add ; $i++)
					{
						$this->bed_model->set_Bed($ward['ward_id'], "Bed#".$first_bed_number);
						$first_bed_number++;
					}
					
					$array = array('notice' => "Beds Successfully Added to ".$ward['ward_name']." Ward");
					$this->session->set_userdata($array);
					redirect('/admin');
				}
			}
			else
			{
				redirect('/admin');
			}
			
			
		
		
		
			
			
	}
	public function deleteWard()
	{
		$this->utilities->aunthenticateAccess(DELETE_WARD, "admin");
		
			if($this->input->post('ward_old_name'))
			{
				   $beds = $this->bed_model->getBedByWard($this->input->post('ward_old_name'));
						    if(sizeof($beds) > 0)
						    {
							$array = array('notice' => "Must remove all the beds in the ward");
							$this->session->set_userdata($array);
							redirect('/admin');
						    }
						    else
						    {
							
							$table_name = 'ward_master';
							$id = 'ward_id';
							$id_value = $this->input->post('ward_old_name');
							
							 $data = array(
										'status' => 'D'
									);
				
							$this->general_update_model->update($table_name,$id,$id_value, $data);
							
							
							$array = array('notice' => "Ward Successfully Deleted");
							$this->session->set_userdata($array);
							redirect('/admin');
						    }
			}
			else
			{
				redirect('/admin');
			}
		
	}
	public function updateWard()
	{
		
		$this->utilities->aunthenticateAccess(EDIT_WARD, "admin");
		
			if($this->input->post('ward_old_name'))
			{
				//get the old ward and compare if any change
				$ward = $this->ward_model->getWard($this->input->post('ward_old_name'));
				//compare old values with new values
				if(strtolower($ward['ward_name']) != strtolower($this->input->post('ward_name')) || $ward['ward_bed_limit'] != $this->input->post('ward_bed_limit'))
				{
					//if there is a change in ward limit
					if($ward['ward_bed_limit'] != $this->input->post('ward_bed_limit'))
					{
						//if the ward limit is less than the current ward limit , check if there is any bed in the ward
						if($this->input->post('ward_bed_limit') < $ward['ward_bed_limit'])
						{
						    $beds = $this->bed_model->getBedByWard($ward['ward_id']);
						    if(sizeof($beds) > 0)
						    {
							$array = array('notice' => "Must remove all the beds in a ward first to reduce the max limit");
							$this->session->set_userdata($array);
							redirect('/admin');
						    }
						}
						
						$date = new DateTime();
						date_timezone_set($date, timezone_open('Africa/Lagos'));
						$todaysDate =  date_format($date, 'Y-m-d H:i:s') ;

				
						$table_name = 'ward_master';
						$id = 'ward_id';
						$id_value = $ward['ward_id'];
						
						 $data = array(
									'ward_name' => ucfirst($this->input->post('ward_name')),
									'ward_bed_limit' => $this->input->post('ward_bed_limit'),
									'date_modified' => $todaysDate
								);
			
						$this->general_update_model->update($table_name,$id,$id_value, $data);
						
						
						$array = array('notice' => "Ward Successfully Updated");
						$this->session->set_userdata($array);
						redirect('/admin');
						
						
					}
				}
				else{
					redirect('/admin');
				}
			}
			else
			{
			  redirect("/login");
		        }
			
			
		
	}
	public function updateDepartment()
	{
		$this->utilities->aunthenticateAccess(UPDATE_DEPARTMENT, "admin");
		
			if($this->input->post('staff_no') && $this->input->post('dept_id'))
			{
				
				 $date = new DateTime();
				date_timezone_set($date, timezone_open('Africa/Lagos'));
				$todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
				
				$table_name = "staff_master";
				$id = "staff_no";
				$id_value = $this->input->post('staff_no');
			
			
			    
			    
			      $data = array(
					'dept_id' => $this->input->post('dept_id'),					
					'date_modified' => $todaysDate
				);
			
				$this->general_update_model->update($table_name,$id,$id_value, $data);
				
				$array = array('notice' => "Department sucessfully updated");
						$this->session->set_userdata($array);
						    redirect('/staff/number/'.$this->input->post('staff_no'));
				}
				else
				{
					$array = array('notice' => INVALID_FUNCTION_CALL);
						$this->session->set_userdata($array);
						    redirect('/home');
				}
		
		
	}
	public function getWardJson()
	{
		if($this->input->post('ward_id'))
		{
			$ward = $this->ward_model->getWard($this->input->post('ward_id'));
			echo json_encode($ward);
		}
		else
		{
			echo json_encode(null);
		}
	}
	public function getBillJson()
	{
		
		if($this->input->post('bill_id'))
		{
			$bill = $this->bill_master_model->getBill($this->input->post('bill_id'));
			echo json_encode($bill);
		}
		else
		{
			echo json_encode(null);
		}
		
	}
	public function updateShift()
	{
		
		$this->utilities->aunthenticateAccess(UPDATE_SHIFT, "admin");
		
			
			if(!$this->input->post('shift_id') || !$this->input->post('shift_name') || !$this->input->post('shift_start_time') || !$this->input->post('shift_end_time'))
			{
				$array = array('notice' => INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/home');
			}
			
			$table_name = "shift_master_table";
			$id = "shift_id";
			$id_value = $this->input->post('shift_id');
			$comments = $this->input->post('comments') ;
			
			 $date = new DateTime();
				date_timezone_set($date, timezone_open('Africa/Lagos'));
				$todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
			    
			    
			      $data = array(
					'shift_name' => $this->input->post('shift_name'),
					'shift_start_time' => $this->input->post('shift_start_time'),
					'shift_end_time' => $this->input->post('shift_end_time'),
					'comments' => $comments,
					'date_modified' => $todaysDate
				);
			
			$this->general_update_model->update($table_name,$id,$id_value, $data);
			
			$array = array('notice' => "Shift Updated");
				$this->session->set_userdata($array);
				redirect('/admin');
		
	}
	public function createShift()
	{
		
		$this->utilities->aunthenticateAccess(DEFINE_SHIFT, "home");
		
		
		
			
			if(!$this->input->post('shift_name') || !$this->input->post('shift_start_time') || !$this->input->post('shift_end_time'))
			{
				$array = array('notice' => INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/home');
			}
			
			
			$comments = $this->input->post('comments') ;
			
			$this->shift_model->set_Shift($this->input->post('shift_name'),
						      $this->input->post('shift_start_time'),
						      $this->input->post('shift_end_time'),
						      $comments,$this->session->userdata('staff_no'));
			
			$array = array('notice' => "New Shift Definition Created");
				$this->session->set_userdata($array);
				redirect('/admin');
			
		
		
		
	}
	public function deleteDepartment()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->moduleAccessCheck(CREATE_DEPARTMENT);
		}
		else
		{
			redirect('/redirect');
		}
	}
	public function createDepartment()
	{
		
		
		$this->utilities->aunthenticateAccess(CREATE_DEPARTMENT, "home");
		
			
			if(!$this->input->post('department_name'))
			{
				$array['notice'] = 'Invalid Function Call';
				$this->session->set_userdata($array);
			}
			
			
			
			$this->department_model->set_department($this->session->userdata('staff_no'));
			
			$array['notice'] = 'Department Created';
				$this->session->set_userdata($array);
				
				
			redirect('/admin');
		
		
		
	}
	public function uploadMaritalStat()
	{
		
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
			if($this->input->post('marital_status') && $this->input->post('marital_description') )
			{
				print_r($_POST);
				
				//check if maritalstatus already exists in the system
				$maritalstatus = $this->marital_model->getMaritalStatusByCode($this->input->post('marital_status'));
				
				if($maritalstatus)
				{
					$array = array('notice' =>"Marital Status Already Exists");
					$this->session->set_userdata($array);
					redirect('/admin');
					
				}
				
				else
				{
					
					$this->marital_model->set_MaritalStatus();
					
					$array = array('notice' =>"Marital Status Sucessfully created");
					$this->session->set_userdata($array);
					redirect('/admin');
				}
			}
			else{
				
				$array = array('notice' =>"Invalid Request");
					$this->session->set_userdata($array);
				redirect('/home');
			}
		
		
	}
	public function createBill()
	{
		
		$this->utilities->aunthenticateAccess(DEFINE_BILLABLE_ITEM, "home");
			
			if(isset($_POST['service_name']))
				{
					
					$this->bill_master_model->set_Bill($this->session->userdata('staff_no'));
					$array = array('notice' =>"Bill Created");
					$this->session->set_userdata($array);
					redirect('/admin');
				}
				else
				{
					$array = array('notice' =>"Invalid Request");
					$this->session->set_userdata($array);
					redirect('/admin');
				}
		
	}
	public function uploadLogo()
	{
		
		
	$this->utilities->aunthenticateAccess(CHANGE_LOGO, "home");
			
		
			
			
			
		   $config['upload_path'] = 'assets/img/logo/';
                    $config['allowed_types'] = 'png';
                    $config['max_size']	= '2000';
		    
		    /**
		    $config['max_width']  = '400';
		    **/
		    $config['max_height']  = '400';
		    
		    
                    //rename the formal logo
			rename("assets/img/logo/logo.png","assets/img/logo/logo_bck.png");
    
                    $this->load->library('upload', $config);
    
                    if ( ! $this->upload->do_upload())
                    {
			    $array = array('notice' =>$this->upload->display_errors());
					$this->session->set_userdata($array);
			
			//failed upload restore the formal logo	
			rename("assets/img/logo/logo_bck.png","assets/img/logo/logo.png");
			  
			    redirect('/admin');
                    }
                    else
                    {
			//remove the formal logo
			
			$pic = $this->upload->data();
			$new_name = "logo".$pic['file_ext'];
			
			
			
			//rename the image 
			rename("assets/img/logo/".$pic['orig_name'], "assets/img/logo/".$new_name);
			
			
			
			
			//create a thumbnail image
			
			$config['image_library'] = 'gd2';
			$config['source_image']	= "assets/img/logo/".$new_name;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = FALSE;
			
			$config['width']	 = 200;
			$config['height']	= 200;
			
			$this->load->library('image_lib', $config); 
			
			$this->image_lib->resize();
			
			
			unlink("assets/img/logo/logo_bck.png");
			$array = array('notice' =>"picture uploaded sucessfully");
					$this->session->set_userdata($array);
					
					redirect('/admin');
			
		    }
		
		
	}

    /**
     * convert to general settings update
     */
	public function updateHospitalSettings(){
		
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");


        $systemSettings = $this->settings_model->getSetting();

        foreach($systemSettings as $setting){

            $updatedValue = $this->input->post($setting['key']);

            if(trim($updatedValue) == ""){

                //setting was not updated please skip
                continue;
            }


            if(strtolower(trim($updatedValue)) == strtolower(trim($setting['value'])) ){

                continue;
            }

            if($setting['data_type'] == "boolean" ){

                if(!(strtolower($updatedValue) == "false" || strtolower($updatedValue) == "true" )){

                    $this->utilities->redirectWithNotice("admin", "invalid value for ". $setting['name'] . " must be either true or false");
                    break;
                }
            }


            //update settings

            $data['value'] = $updatedValue;
			$this->general_update_model->update("sys_settings",
                "key",
                $setting["key"],
                $data);

        }


		$this->utilities->redirectWithNotice("admin", "System Settings Successfully updated");

	}
	public function deleteDept()
	{
		$this->utilities->aunthenticateAccess(UPDATE_DEPARTMENT, "home");
		
		if(!$this->input->post("department"))
		{
			$this->utilities->redirectWithNotice("admin", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$department = $this->department_model->getDepartments($this->input->post("department"));
		
		if(!$department)
		{
			$this->utilities->redirectWithNotice("admin", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$data['status'] = "D";
		$this->general_update_model->update("department_master",
						    "dept_id",
						    $this->input->post("department"),
						    $data);
		
		$this->utilities->redirectWithNotice("admin", $this->lang->line(DELETE_DEPT_SUCCESS));		
		
		
	}
	public function index()
	{
		$this->utilities->aunthenticateAccess(ADMIN, "home");
		
		
			//get all user module mappings by role
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			
			$data['countries']  = $this->country_model->getCountries();
			
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
			$data['bills'] = $this->bill_master_model->getBill();
			
			$data['blood_groups'] = $this->bloodgrp_model->getBloodgrp();
			$data['genotypes'] = $this->phenotype_model->getPhenotype();
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			$data['shifts'] = $this->shift_model->getShift();
                        
                        $data['usergroups'] =  $this->user_groups_model->getUserGroups();
			$data['departments'] = $this->department_model->getDepartments();
			
			$data['freecodes'] = $this->free_code_model->getFreeCode();
			$data['freecodes2'] = $this->free_code_2_model->getFreeCode();
			
			$data['tasks'] = $this->tasks_model->getTask();
			$data['intaketype'] = $this->intake_type_model->getIntake();
			$data['outputtype'] = $this->output_type_model->getOutput();
			$data['deliverytype'] = $this->delivery_type_model->getDeliveryType();

            $data['settings'] = $this->settings_model->getSetting();
			
			$data['dosage_forms'] = $this->drug_presentation_model->getDrugPresentation();
			$data['drug_bill_forms'] = $this->drug_bill_form_model->getDrugBillForms();
			$data['units'] = $this->unit_model->getUnit();
			$data['wards'] = $this->ward_model->getWard();
			$data['marital_stats'] = $this->marital_model->getMaritalStatus();
			//get beds in ward			
			for($i=0; $i < sizeof($data['wards']); $i++)
			{
				$beds = $this->bed_model->getBedByWard($data['wards'][$i]['ward_id']);
				
				$data['wards'][$i]['current_beds_in_ward'] = sizeof($beds);
				
			}
			
			
			$data['title'] = "Medstation | Hospital Admin";
			$data['content-description'] = "Hospital Admin Manager";
			
			$pages[0] = "admin/home";
			
			$this->page->loadPage($pages,$data,TRUE);
			
			
		
	}

    public function deleteUser(){

        $this->utilities->aunthenticateAccess(DELETE_USER, "home");

        //confirm staff exists

        if(!$this->input->post("staff_no")){

            $this->utilities->redirectWithNotice("admin", $this->lang->line(INVALID_FUNC_CALL));
        }

        $staff = $this->staff_model->getStaff($this->input->post("staff_no"));

        if(!$staff){

            $this->utilities->redirectWithNotice("admin", $this->lang->line(INVALID_FUNC_CALL));
        }


        $data['status'] = "D";

        $table_name = "ult";
        $id = "staff_no";
        $id_value = $staff["staff_no"];
        $this->general_update_model->update($table_name,$id,$id_value, $data);

        $table_name = "staff_master";
        $this->general_update_model->update($table_name,$id,$id_value, $data);

        $this->utilities->redirectWithNotice("admin", "User Successfully deleted");

    }

    private function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }


    public function resetPassword(){

        $this->utilities->aunthenticateAccess(RESET_PASSWORD, "home");

        //confirm staff exists

        if(!$this->input->post("staff_no")){

            $this->utilities->redirectWithNotice("admin", $this->lang->line(INVALID_FUNC_CALL));
        }

        $staff = $this->staff_model->getStaff($this->input->post("staff_no"));

        if(!$staff){

            $this->utilities->redirectWithNotice("admin", $this->lang->line(INVALID_FUNC_CALL));
        }

        $newPassword =  $this->randomPassword();
        $data["password"] = $this->passwordhash->HashPassword($newPassword);

        $table_name = "ult";
        $id = "staff_no";
        $id_value = $staff["staff_no"];
        $this->general_update_model->update($table_name,$id,$id_value, $data);


        $notice = "User : ".$staff["first_name"] . "'s password reset to ".$newPassword;

        $parameters["username"] = $staff["email"];
        $parameters["password"] = $newPassword;
        //send email to staff with his credentials
        $this->utilities->sendHtmlEmail(PASSWORD_RESET_EMAIL_TEMPLATE,
            $parameters, $staff["email"], "Password Change");


        $this->utilities->redirectWithNotice("admin", $notice);

        /**
         *
         * $data['password'] = $this->passwordhash->HashPassword($this->input->post('new_pass'));

        $table_name = "ult";
        $id = "id";
        $id_value = $logindata['userlogindata']['id'];

        $this->general_update_model->update($table_name,$id,$id_value, $data);
         */

 //       print_r($_POST);

    }
	
	public function defineNewIntakeType()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
		if(!$this->input->post('intake_type'))
		{
			$this->utilities->redirectWithNotice('home', $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$intake = $this->intake_type_model->getIntakeByType($this->input->post("intake_type"));
		
		if($intake)
		{
			$this->utilities->redirectWithNotice('home', $this->lang->line(INTAKE_ALREADY_EXIST));
		}
		
		
		$this->intake_type_model->set_intake_type($this->input->post("intake_type"), $this->input->post("description"));
		
		
		$this->utilities->redirectWithNotice('admin', $this->lang->line(INTAKE_CREATED));
	}
	public function delIntakeType()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
		if(!$this->input->post('intake_id'))
			{
				$this->utilities->redirectWithNotice('home', $this->lang->line(INVALID_FUNC_CALL));
			}
			
		$data["status"] = "D";
                $this->general_update_model->update("intake_type","id",$this->input->post("intake_id"), $data);
			
		$this->utilities->redirectWithNotice('admin', $this->lang->line(INTAKE_DELETED));
		
	}
	
	public function defineNewOutputType()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
		if(!$this->input->post('output_type'))
		{
			$this->utilities->redirectWithNotice('home', $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$outputtype = $this->output_type_model->getOutputByType($this->input->post("output_type"));
		
		if($outputtype)
		{
			$this->utilities->redirectWithNotice('home', $this->lang->line(OUTPUT_ALREADY_EXIST));
		}
		
		
		$this->output_type_model->set_output_type($this->input->post("output_type"), $this->input->post("description"));
		
		
		$this->utilities->redirectWithNotice('admin', $this->lang->line(OUTPUT_CREATED));
	}
	public function delOutputType()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
		if(!$this->input->post('output_id'))
			{
				$this->utilities->redirectWithNotice('home', $this->lang->line(INVALID_FUNC_CALL));
			}
			
		$data["status"] = "D";
                $this->general_update_model->update("output_type","id",$this->input->post("output_id"), $data);
			
		$this->utilities->redirectWithNotice('admin', $this->lang->line(OUTPUT_DELETED));
		
	}
	
	
	public function defineNewDeliveryType()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
		if(!$this->input->post('delivery_type'))
		{
			$this->utilities->redirectWithNotice('home', $this->lang->line(INVALID_FUNC_CALL));
		}
		
		$deliverytype = $this->delivery_type_model->getDeliveryByType($this->input->post("delivery_type"));
		
		if($deliverytype)
		{
			$this->utilities->redirectWithNotice('home', $this->lang->line(DELIVERY_ALREADY_EXIST));
		}
		
		
		$this->delivery_type_model->set_delivery_type($this->input->post("delivery_type"), $this->input->post("description"));
		
		
		$this->utilities->redirectWithNotice('admin', $this->lang->line(DELIVERY_CREATED));
	}
	public function delDeliveryType()
	{
		$this->utilities->aunthenticateAccess(EIDT_BASE_DATA, "home");
		
		if(!$this->input->post('delivery_id'))
			{
				$this->utilities->redirectWithNotice('home', $this->lang->line(INVALID_FUNC_CALL));
			}
			
		$data["status"] = "D";
                $this->general_update_model->update("delivery_type","id",$this->input->post("delivery_id"), $data);
			
		$this->utilities->redirectWithNotice('admin', $this->lang->line(DELIVERY_DELETED));
		
	}
	
  
}