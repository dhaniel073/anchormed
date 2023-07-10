<?php

define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
define ('MODULE_NO', 14);

define ('TITLE', 'In Patient');

class Inpatient extends CI_Controller {

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
		$this->load->helper('date');
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
                $this->load->model('patient_admission_model');
		$this->load->model('patient_history_model');
		$this->load->model('omt_model');		
		$this->load->model('tasks_model');
		$this->utilities->loadUserLang();
		
		
	}
	
	public function performTask()
	{
		$this->utilities->aunthenticateAccess(PERFORM_IN_PATIENT_TASK, "inpatient");
		
		if(!$this->input->post("task_id"))
		{
			$this->utilities->redirectWithNotice("inpatient", $this->lang->line(INVALID_FUNC_CALL));
		}
		
		//get tasks data
		
		$inpatientTask = $this->tasks_model->getInPatientTask($this->input->post("task_id"));
		
		$taskData = $this->tasks_model->getTask($inpatientTask["task_id"]);
		
		
		$order_notes = "Scheduled Task : ".$taskData["name"]."<br/>Task Details : ".$inpatientTask["task_specific_instructions"];
		
		
		$patient_number = $inpatientTask["patient_number"];
		
		//first create order
		$history = $this->patient_history_model->getCurrentHistory($patient_number);
		$staff_no = $this->session->userdata("staff_no");
		$staff = $this->staff_model->getStaff($staff_no);
		if(!$history)
		{
			$this->patient_history_model->set_History($patient_number,
								  $staff_no,
								  "Admitted Patient Administration",
								  "History Created by System for Scheduled task run</b><br/>$order_notes<br/>");
		
			$history = $this->patient_history_model->getCurrentHistory($patient_number);
		
		}
		else{
			
			$table_name = "patient_history";
				$id = "patient_history_id";
				$id_value = $history["patient_history_id"];
		
				$data = array(
					'doctors_notes'=> $history["doctors_notes"]." ".$order_notes."<br/>"
				);
				
				$this->general_update_model->update($table_name,$id,$id_value, $data);
		}
		
		$this->omt_model->set_Omt($this->session->userdata('staff_no'),
								  'nurse', $history['patient_history_id'], $order_notes);
		
		$order = $this->omt_model->getPatientLastOmt("nurse", $history['patient_history_id']);
		//print_r($order);
				
		$array = array('patient_need_action'=>$order['id'], 'patient_history'=>$history, 'action_type' => "nurse");
	
				
		$this->session->set_userdata($array);
		
		$table_name = "in_patient_tasks";
				$id = "id";
				$id_value = $this->input->post("task_id");
		
				$data = array(
					'status' => "D",
					'skipped_by'=> $this->session->userdata("staff_no")
				);
				
				$this->general_update_model->update($table_name,$id,$id_value, $data);
		
		//update the status of task to performed
		
		$this->utilities->redirectWithNotice('workbench', "Task Added to workspace");
	}
        
	private function getInpatientPendingTaskCount($patient_number)
	{
		$tasks = $this->tasks_model->get_in_patient_pending_tasks_count($patient_number);		
		return sizeof($tasks);
	}
	
	public function skipTaskJson()
	{
		$task_id = $this->input->post("task_id");
		if($task_id)
		{
			if($this->utilities->userHasAccess(SKIP_TASK))
			{
				$table_name = "in_patient_tasks";
				$id = "id";
				$id_value = $task_id;
		
				$data = array(
					'status' => "S",
					'skipped_by'=> $this->session->userdata("staff_no")
				);
				
				$this->general_update_model->update($table_name,$id,$id_value, $data);
				
				$response["status"] = "success";			
				echo json_encode($response);
			}
			else
			{
				$response["status"] = ACCESS_ERROR;
				echo json_encode($response);
			}
			
		}
		else
		{
			echo json_encode(null);
		}
	}
	public function getTaskIndividualItemsJson()
	{
		$task_reference = $this->input->post("task_reference");
		
		if($task_reference)
		{
			$inpatientTasks = $this->tasks_model->getTaskByReference($task_reference);
			$counter = 0;
			foreach($inpatientTasks as $task)
			{
				$inpatientTasks[$counter]["patient_data"] = $this->patient_model->getPatient($task["patient_number"]);
				$inpatientTasks[$counter]["staff_data"] = $this->staff_model->getStaff($task["created_by"]);
				$inpatientTasks[$counter]["performed_by"] = $this->staff_model->getStaff($task["carried_out_by"]);
				$inpatientTasks[$counter]["task_data"] = $this->tasks_model->getTask($task["task_id"]);
				
				if($task["status"] == "D")
				{
					$inpatientTasks[$counter]["status"] = "Completed";
				}
				else if($task["status"] == "S")
				{
					$inpatientTasks[$counter]["status"] = "Skipped";
				}
				else
				{
					$inpatientTasks[$counter]["status"] = $this->getTaskStatus($task["due_time"],$task["id"],$task["task_reference"]);
				}
				
				$counter++;
			}
			
			echo json_encode($inpatientTasks);
		}
		else
		{
			echo json_encode(null);
		}
	}
	
	private function getTaskStatus($task_due_time,$task_id,$task_reference)
	{
		//initialise the status
		$status = "Upcoming";
		
		
		$currentDate = new DateTime($this->utilities->getDate());
		$dueDate = new DateTime($task_due_time);
		if($currentDate >= $dueDate )
			{
			     $status = "Due";				     
			     //also check if the next task in the sequence is due, then set status to expired
			     if($this->tasks_model->checkIfNextTaskInSeriesIsDue($task_reference, $task_id))
			     {
				$status = "Attention Required";	
				
			     }
			     

			}
			
			return $status;
				
	}
	
	public function getInpatientPendingTaskJson()
	{
		$patient_number = $this->input->post("patient_number");
		
		
		
		if($patient_number)
		{
			$tasks = $this->tasks_model->get_in_patient_pending_tasks_count($patient_number);
			
			$counter = 0;
			foreach($tasks as $task)
			{
				$tasks[$counter]["patient_data"] = $this->patient_model->getPatient($task["patient_number"]);
				$tasks[$counter]["staff_data"] = $this->staff_model->getStaff($task["created_by"]);
				$tasks[$counter]["task_data"] = $this->tasks_model->getTask($task["task_id"]);
				
				$dueTask = $this->tasks_model->getNextDueTaskInSeries($task["task_reference"]);
				$tasks[$counter]["next_due_date"] = $dueTask["due_time"];
				
								
				$tasks[$counter]["status"] = $this->getTaskStatus($dueTask["due_time"],$dueTask["id"],$dueTask["task_reference"]);
				
				
				//get task summary
				$tasks[$counter]["summary"] = $this->tasks_model->getScheduledSummary($dueTask["task_reference"]);
				
				
				
				
				$counter++;	
			}
			
			echo json_encode($tasks);
		}
		else
		{
			echo json_encode(null);
		}
		
	}
        
        public function search()
        {
            $this->utilities->aunthenticateAccess(VIEW_IN_PATIENTS, "home");
            
            if(isset($_POST['name']))
				{
					$data['patients'] = $this->patient_admission_model->getInPatientsLike($_POST['name']);
				}
				else
				{
					$data['patients'] = $this->patient_admission_model->getInPatients();
				}
			
			
			$counter = 0;
			
			foreach($data['patients'] as $patient)
			{
				$data['patients'][$counter]["task_count"] = $this->getInpatientPendingTaskCount($patient["patient_number"]);
				$counter ++;
			}
			
			
			//get all user module mappings by role
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			if(isset($_POST['return_base']))
			{
				$data['return_base'] = $_POST['return_base'];			
			}
			$data['title'] = "Medstation | Inpatient Search";
			$data['search_url']= "index.php/inpatient/search";
			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
			$data["tasks"] = $this->tasks_model->getTask();
			
                        
                        $pages[0] = "inpatient/search";
			
			$this->page->loadPage($pages,$data,TRUE);
                        
        }
		
	
	public function all()
        {
            $this->utilities->aunthenticateAccess(VIEW_IN_PATIENTS, "home");
            
            if(isset($_POST['name']))
				{
					$data['patients'] = $this->patient_admission_model->getInPatientsLike($_POST['name']);
				}
				else
				{
					$data['patients'] = $this->patient_admission_model->getInPatientsAll();
				}
			
			
			$counter = 0;
			
			foreach($data['patients'] as $patient)
			{
				$data['patients'][$counter]["task_count"] = $this->getInpatientPendingTaskCount($patient["patient_number"]);
				$counter ++;
			}
			
			
			//get all user module mappings by role
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			if(isset($_POST['return_base']))
			{
				$data['return_base'] = $_POST['return_base'];			
			}
			$data['title'] = "Medstation | Inpatient Search";
			$data['search_url']= "index.php/inpatient/search";
			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
			$data["tasks"] = $this->tasks_model->getTask();
			
                        
                        $pages[0] = "inpatient/viewall";
			
			$this->page->loadPage($pages,$data,TRUE);
                        
        }
	
	public function createPatientRecurringTask()
	{		
	     $this->utilities->aunthenticateAccess(SCHEDULE_IN_PATIENT_TASK, "inpatient");
	     
	     if(!$this->input->post("task_id") || !$this->input->post("date") || !$this->input->post("time") || !$this->input->post("frequency") || !$this->input->post("rounds"))
	     {
		$this->utilities->redirectWithNotice("inpatient", $this->lang->line(INVALID_FUNC_CALL));
	     }
	     
	     $splitdate = preg_split('[-]',$this->input->post("date"));
	     $startDate =  $splitdate[2]."-".$splitdate[0]."-".$splitdate[1]." ".$this->input->post("time") ;
	 
	
	     //compile time
	     
	     $d1 = new DateTime($startDate);
	     $d2 = new DateTime($this->utilities->getDate());
	     
	     //invalid date selected
	     if($d1 < $d2)
	     {
		$this->utilities->redirectWithNotice("inpatient/search",$this->lang->line(INVALID_TASK_START_DATE));
	     }
	     
	     $currentTaskDate = $startDate;
	     
	     $task_reference = "TASK|".now()."|".$this->input->post("patient_number");
	     
	     for($i=0; $i < $this->input->post("rounds");$i++)
	     {
		if($i > 0)
		{
		    $currentTaskDate = $this->calculateNextTaskDate($this->input->post("frequency"),$currentTaskDate,$this->input->post("times"));
		}
		
		$this->tasks_model->create_in_patient_task($this->input->post("patient_number"),
							  $currentTaskDate,
							  $this->input->post("task_id"),
							  $this->input->post("notes"),
							  $task_reference);	
		
	     }
	     
	   $this->utilities->redirectWithNotice("inpatient",$this->lang->line(INPATIENT_TASK_SCHEDULED));

	     
	}
	
	private function calculateNextTaskDate($frequency,$currentTaskDate,$numberOfTimes)
	{
		$date =  new DateTime($currentTaskDate);
		$interval = 0;
		
		switch($frequency)
		{
			case "h":
				$interval = 60/$numberOfTimes;
				$date->add(new DateInterval("PT".$interval."M"));
				break;
			case "d":
				$interval = 24/$numberOfTimes;
				$date->add(new DateInterval("PT".$interval."H"));
				break;
			case "m":
				$interval = 30/$numberOfTimes;
				$date->add(new DateInterval("P".$interval."D"));
				break;
			case "y":
				$interval = 12/$numberOfTimes;
				$date->add(new DateInterval("P".$interval."M"));
				break;
		}
		
		return $date->format('Y-m-d H:i:s');
	}
        
        public function index()
        {
            
            $this->utilities->aunthenticateAccess(VIEW_IN_PATIENT_HOME, "home");
	
		
		
			//get all user module mappings by role
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			
						
			
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
                        
			
			$data['title'] = "Medstation | In Patients";
			$data['content-description'] = "In patients";
			
			$pages[0] = "inpatient/home";
			
			$this->page->loadPage($pages,$data,TRUE);
        }
        
}

?>