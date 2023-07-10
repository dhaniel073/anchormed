<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
define('INVALID_FUNCTION_CALL', 'Action not permitted');
define ('MODULE_NO', 4);
define ('TITLE', 'Workbench');
define ('ASSIGN_PATIENT_TO_WARD', 36);
define ('DISCHARGE_PATIENT', 38);
define ('ADMIT_PATIENT', 39);
define ('REASSIGN_PATIENT_TO_WARD',40);
define ('PATIENT_NOT_IN_WARD',"Patient is not admitted in any ward");


class Workbench extends CI_Controller {

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
                $this->load->model('bills_model');
                $this->load->model('state_model');
                $this->load->model('country_model');
                $this->load->helper('date');
		$this->load->model('bill_master_model');
		$this->load->model('shift_model');
		$this->load->model('user_groups_model');
		$this->load->model('staff_model');
		$this->load->model('general_update_model');
		$this->load->model('notification_model');
		$this->load->model('current_patient_model');
		$this->load->model('occupation_model');
		$this->load->model('patient_history_model');
		$this->load->model('omt_model');
		$this->load->model('patient_admission_model');
		$this->load->model('ward_model');
		$this->load->model('bed_model');
		$this->load->model('message_model');
		$this->load->model('Consultation_model');
	}
	
	public function getPersonalQueueJson()
	{
		$data['queue'] = $this->daily_schedule_model->getDailyScheduleReadyForDoc();


			$data['patients'] = null;
			$counter = 0;
			foreach($data['queue'] as $queue)
			{

				if($this->session->userdata('staff_no') == $queue['staff_no'])
				{


					$data['patients'][$counter] = $this->patient_model->getPatient($queue['patient_number']);
					$data['patients'][$counter]['patient_family_id'] = "";
					$data['patients'][$counter]['queue_number'] = $queue['queue_number'];
					$data['patients'][$counter]['date'] = $queue['date'];
					$data['patients'][$counter]['schdule_id'] = $queue['schdule_id'];

					if(isset($queue['patient_family_id']) && $queue['patient_family_id'] != "")
					{
					 $family_member = $this->patient_model->getPatientFamMember($queue['patient_family_id']);

					$data['patients'][$counter]['first_name'] = $family_member['first_name'];
					$data['patients'][$counter]['last_name'] = $family_member['last_name'];
					$data['patients'][$counter]['middle_name'] = $family_member['middle_name'];
					$data['patients'][$counter]['patient_family_id'] = $family_member['patient_family_id'];

					}
					$counter++;

				}
			}

		echo json_encode($data['patients']);
	}
		
	public function getAdmittedPatientCountJson()
	{
		$count = $this->patient_admission_model->getAdmittedPatientCount();
		echo json_encode($count);
	}
        
	public function getAdmittedPatientsJson()
	{
		$admissions = $this->patient_admission_model->getAllAdmittedPatients();
		$counter = 0;

		foreach($admissions as $admission)
		{


			$staff = $this->staff_model->getStaff($admission["doctor_code"]);
			$ward = $this->ward_model->getWard($admission["ward_id"]);

			$admissions[$counter]["patient"] = $this->patient_model->getPatient($admission["patient_number"]);
			$admissions[$counter]["admitted_by"] = ucfirst($staff["first_name"])." ". ucfirst($staff["middle_name"])." ".ucfirst( $staff["last_name"]);
			$admissions[$counter]["ward_name"]  = $ward["ward_name"];
			
					$patientFullDetails = $this->patient_model->getPatient($admission["patient_number"]);
							
							if($patientFullDetails['hmo_code']){
								$hmoDetails = $this->patient_model->getHmoDetails($patientFullDetails['hmo_code']);
								$admissions[$counter]['hmo_code'] = $hmoDetails['hmo_code'];
								$admissions[$counter]['hmo_name'] = $hmoDetails['hmo_name'];
							}

			$counter++;
		}
		echo json_encode($admissions);
	}
	
	public function getDeptQueueJson()
	{
		$data['queue'] = $this->daily_schedule_model->getDailyScheduleReadyForDoc();



			$counter = 0;
			foreach($data['queue'] as $queue)
			{
				if($this->session->userdata('dept_id') == $queue['dept_id'])
				{


					$data['patients'][$counter] = $this->patient_model->getPatient($queue['patient_number']);
					$data['patients'][$counter]['patient_family_id'] = "";
					$data['patients'][$counter]['queue_number'] = $queue['queue_number'];
					$data['patients'][$counter]['date'] = $queue['date'];
					$data['patients'][$counter]['schdule_id'] = $queue['schdule_id'];

					if(isset($queue['patient_family_id']) && $queue['patient_family_id'] != "")
					{
					 $family_member = $this->patient_model->getPatientFamMember($queue['patient_family_id']);

					$data['patients'][$counter]['first_name'] = $family_member['first_name'];
					$data['patients'][$counter]['last_name'] = $family_member['last_name'];
					$data['patients'][$counter]['middle_name'] = $family_member['middle_name'];
					$data['patients'][$counter]['patient_family_id'] = $family_member['patient_family_id'];

					}
					$counter++;

				}
			}

		echo json_encode($data['patients']);
	}
	
	public function getUserWaitListJson()
	{

		$counter =  $this->daily_schedule_model->get_number_doc($this->session->userdata('staff_no'));

		echo json_encode($counter);


	}
	

	public function takeAction()
	{
		if($this->session->userdata('logged_in'))
		{

			$this->confirmUrl();
			$this->confirmRole();

			if($this->input->post('id'))
			{
				$date = new DateTime();
				date_timezone_set($date, timezone_open('Africa/Lagos'));
				$todaysDate =  date_format($date, 'Y-m-d H:i:s') ;

				$table_name = "omt";
					$id = "id";
					$id_value = $this->input->post('id');

					$data = array(
						'status' => 'P', 'carried_out_on'=>$todaysDate, 'carried_out_by' => $this->session->userdata('staff_no'));



					$this->general_update_model->update($table_name,$id,$id_value, $data);



					if($this->input->post('action_notes'))
					{
						$staff = $this->staff_model->getStaff($this->session->userdata('staff_no'));
						$order_in_view = $this->omt_model->getOmt($this->input->post('id'));

						$history = $this->patient_history_model->getHistory($order_in_view['patient_history_id'],FALSE);

						$doctors_notes = $this->input->post('action_notes');

						$table_name = "patient_history";
						$id = "patient_history_id";
						$id_value = $order_in_view['patient_history_id'];

						$update = array(
							'doctors_notes' => $history['doctors_notes']."<br/> ".$doctors_notes ."<br/>---- <b>".$staff['first_name']." " .$staff['last_name']."</b><br/>"
						);

						$this->general_update_model->update($table_name,$id,$id_value, $update);
					}



					$array = array('notice'=>"action performed");
					$this->session->set_userdata($array);
					redirect('/home');

			}
			else
			{
				$array = array('notice'=>INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/home');
			}
		}
		else
		{
			redirect("/login");
		}
	}
	
	private function confirmUrl()
		{
			if($this->session->userdata('base_url') != base_url())
			{
				redirect("/logout");
			}

		}

	private function confirmRole()
	{
		/**
		$role = $this->session->userdata('role');

		if($role > 2)
		{
			$array = array('notice' => ACCESS_ERROR);
			$this->session->set_userdata($array);
			redirect('/home');
		}
		**/
	}
	
	public function getHistorySpecific()
	{
		if($this->session->userdata('logged_in'))
		{


			$this->confirmUrl();
			$this->confirmRole();

			if($this->input->post("patient_history_id"))
			{
				$patient_history = $this->patient_history_model->getHistory($this->input->post("patient_history_id"), FALSE);

				$array = array('patient_need_action'=>$this->input->post("order_id"), 'patient_history'=>$patient_history, 'action_type' => $this->input->post("action_type"));

				$this->session->set_userdata($array);
				//$this->session->set_userdata("task_id",$this->input->post("order_id"));
				//echo $this->session->userdata('patient_need_action');
				//return false;


				redirect('/workbench');
			}
			else
			{
				$array = array('notice'=>INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/home');
			}
		}
		else
		{
			redirect('/login');
		}
	}
	
	public function getOrdersJson()
	{
		$this->confirmUrl();
		if($this->session->userdata('logged_in'))

			{
				if($this->input->post('dept'))
				{
					$orders = $this->omt_model->get_Omt_by_dept($this->input->post('dept'));

					$counter = 0;
					foreach($orders as $order)
					{
						$staffWhoMadeOrder = $this->staff_model->getStaff($order["created_by"]);

						$orders[$counter]['ordered_by'] =  ucfirst($staffWhoMadeOrder["first_name"]). " ".ucfirst($staffWhoMadeOrder["middle_name"]). " ".ucfirst($staffWhoMadeOrder["last_name"]);
						
						$patientHistoryDetails = $this->patient_history_model->getHistory($order['patient_history_id'], FALSE);
						$patiendetails = $patientHistoryDetails['patient_number'];
						if(isset($patiendetails)){
							//$patientNumber = $patientHistoryDetails['patient_number'];
							$patientFullDetails = $this->patient_model->getPatient($patiendetails);
							
							if($patientFullDetails['hmo_code']){
								$hmoDetails = $this->patient_model->getHmoDetails($patientFullDetails['hmo_code']);
								$orders[$counter]['hmo_code'] = $hmoDetails['hmo_code'];
								$orders[$counter]['hmo_name'] = $hmoDetails['hmo_name'];
							}
													
							
						}
						

						if($staffWhoMadeOrder["role_id"] = 1) $orders[$counter]['ordered_by'] = "Dr ".$orders[$counter]['ordered_by'];
						if($order['patient_family_id'])
						{
							 $family_member = $this->patient_model->getPatientFamMember($order['patient_family_id']);

							$orders[$counter]['first_name'] = $family_member['first_name'];
							$orders[$counter]['last_name'] = $family_member['last_name'];
							$orders[$counter]['middle_name'] = $family_member['middle_name'];

						}
						$counter++;
					}


					echo json_encode($orders);
				}

				else
				{

					echo json_encode(null);
				}

			}
			else
			{
				echo json_encode(null);
			}

	}
	
	public function getPharmacyPendingTasksJson()
	{

		$count = $this->omt_model->getOmtCountByDept("drugs");
		echo json_encode($count);
	}
	
	public function getLabPendingTasksJson()
	{
		$count = $this->omt_model->getOmtCountByDept("lab");
		echo json_encode($count);
	}
	
	public function getPendingReferalOrderJson()
	{
		$count = $this->omt_model->getOmtCountByDept("referal");
		echo json_encode($count);
	}
	
	public function getPendingPatientvisitOrderJson()
	{
		$count = $this->omt_model->getOmtCountByDept("admin");
		echo json_encode($count);
	}

	public function getNursePendingTasksJson()
	{
		$count = $this->omt_model->getOmtCountByDept("nurse");
		echo json_encode($count);
	}
	
	public function getAdmissionPendingTasksJson()
	{
		$count = $this->omt_model->getOmtCountByDept("admit");
		echo json_encode($count);
	}
	
	public function getTodayAppointmentJson()
	{
		$appointments = $this->appointment_model->getTodaysAppointments(FALSE, $this->session->userdata('staff_no'));
		echo json_encode($appointments);
	}

	public function getTodayAppointmentCountJson()
	{
		$counter = $this->appointment_model->getTodaysAppointments(TRUE, $this->session->userdata('staff_no'));
		echo json_encode($counter);
	}

	public function getNotificationCountJson()
	{
		$counter =  $this->notification_model->getUnreadNotificationCount($this->session->userdata('staff_no'));
		echo json_encode($counter);
	}

	public function getUnreadNotificationJson()
	{
		$notifications =  $this->notification_model->getUnreadNotifications($this->session->userdata('staff_no'));
		echo json_encode($notifications);
	}
	
	public function getNotificationJson()
	{
		$notification =  $this->notification_model->getNotification($this->input->post('notification_id'));
		echo json_encode($notification);

	}
	
	public function getAvailableBedsinWardJson()
	{

		if($this->input->post('hidden_bed_ward_id'))
		{
			$beds = $this->bed_model->getAvailableBedsInWard($this->input->post('hidden_bed_ward_id'));
			echo json_encode($beds);
		}
		else{
			echo json_encode(null);
		}

	}
	
	public function getUnreadMessagesCountJson()
	{

		if($this->session->userdata('logged_in'))
		{
			$staff = $this->session->userdata('staff_no');
			$count = $this->message_model->getUnreadNotificationCount($staff);
			echo json_encode($count);
		}
		else
		{
			echo json_encode(null);
		}
	}
	
	public function getMessageByIdJson()
	{

		if($this->session->userdata('logged_in') || $this->input->post('message_id'))
		{
			$staff = $this->session->userdata('staff_no');

			$message = $this->message_model->getMessage($this->input->post('message_id'), $staff);

			//update message to read

			$table_name = "message_table";
					$id = "message_id";
					$id_value = $this->input->post('message_id');

					$data = array(
						'status' => "R"
					);

					$this->general_update_model->update($table_name,$id,$id_value, $data);


			echo json_encode($message);
		}
		else
		{
			echo json_encode(null);
		}
	}
	
	public function getUnreadMessagesPrevJson()
	{
		if($this->session->userdata('logged_in'))
		{
			$staff = $this->session->userdata('staff_no');
			$messages = $this->message_model->getUnreadMessagesPrev($staff);
			echo json_encode($messages);
		}
		else
		{
			echo json_encode(null);
		}
	}
	
	public function getDeptWaitListJson()
	{
		$data['staff'] = $this->staff_model->getStaff($this->session->userdata('staff_no'));

		$counter =  $this->daily_schedule_model->get_number_dept($data['staff']['dept_id']);

		echo json_encode($counter);


	}
	
	public function getUsersJson()
	{
		if($this->session->userdata('logged_in'))
		{
			echo json_encode($this->staff_model->getStaff());
		}
		else
		{
			echo json_encode(null);
		}

	}

	public function getDeptsJson()
	{
		if($this->session->userdata('logged_in'))
		{
			echo json_encode($this->department_model->getDepartments());
		}
		else
		{
			echo json_encode(null);
		}
	}
	
	public function replyMessage()
	{



		if($this->session->userdata('logged_in'))
		{
			if(!$this->input->post('message_id') || !$this->input->post('reply'))
			{
				$array = array('notice'=>INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/workbench');
			}

			$from = $this->session->userdata('staff_no');
			$original_message = $this->message_model->getMessage($this->input->post('message_id'), $from);
			if($original_message)
			{


				if(strpos($original_message['title'], 'RE') !== false)
				{
					$title = $original_message['title'];

				}
				else
				{
					$title = "RE: ".$original_message['title'];
				}


				$to = $original_message['from'];
				$reference = $this->input->post('message_id');
				$message = $this->input->post('reply');


				$this->message_model->set_Message($message, $title, $to, $from, $reference);



				$array = array('notice'=>"Message Sent");
				$this->session->set_userdata($array);
				redirect('/workbench');

			}
			else
			{
				$array = array('notice'=>INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/workbench');
			}
		}
		else
		{
			redirect("/login");
		}
	}
	
	public function sendMessage()
	{

		if($this->session->userdata('logged_in'))
		{



			$this->confirmUrl();
			$this->confirmRole();

			if((!$this->input->post('to') && $this->input->post('destination_type') != "A") || !$this->input->post('message'))
			{
				$array = array('notice'=>INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/workbench');
			}

			$message = $this->input->post('message');
			$from = $this->session->userdata('staff_no');
			$title = $this->input->post('subject');
			$to = $this->input->post('to');
			$cc = $this->input->post('cc');

			if($this->input->post('destination_type') == "S")
			{

				//send message to the original user
				$this->message_model->set_Message($message, $title, $to, $from, NULL);

				foreach($cc as $copy)
				{
					$to = $copy;
					$this->message_model->set_Message($message, $title, $to, $from, NULL);
				}
			}
			else if($this->input->post('destination_type') == "D")
			{
				//get users in the department of the to field
				$recipients = $this->staff_model->getStaffByDeptId($to);
				foreach($recipients as $recipient)
				{
					$to = $recipient['staff_no'];
					$this->message_model->set_Message($message, $title, $to, $from, NULL);
				}

				foreach($cc as $copy_dept)
				{
					$recipients_copy = $this->staff_model->getStaffByDeptId($copy_dept);
					foreach($recipients_copy as $copy)
					{
						$to = $copy['staff_no'];
						$this->message_model->set_Message($message, $title, $to, $from, NULL);
					}
				}
			}
			else if($this->input->post('destination_type') == "A")
			{
				$recipients = $this->staff_model->getStaff();
				foreach($recipients as $recipient)
				{
					$to = $recipient['staff_no'];
					$this->message_model->set_Message($message, $title, $to, $from, NULL);
				}
			}


			$array = array('notice'=>"Message Sent");
				$this->session->set_userdata($array);
				redirect('/workbench');
		}
		else
		{
			redirect("/login");
		}
	}

	public function recordPatientHistory()
	{
		if($this->session->userdata('logged_in'))
		{


		$this->confirmUrl();
		$this->confirmRole();
			if(!$this->input->post('patient_number') || !$this->input->post('notes') || !$this->input->post('note_description'))
			{
				$array = array('notice'=>INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/home');
			}

			$patient_number = $this->input->post('patient_number');
			$staff_no = $this->session->userdata('staff_no');
			$description = $this->input->post('note_description');
			$doctors_notes = $this->input->post('notes');
			$patient_family_id = $this->input->post('patient_family_id_new');

			print_r($this->input->post('patient_family_id_new'));

			//add to notes all the orders the doctor made to the relative departments

			//if the prescribed drugs
			if($this->input->post("drugs"))
			{
				$doctors_notes = $doctors_notes."<hr/><b>Prescribed Drugs</b><br/>";
				$doctors_notes = $doctors_notes.$this->input->post('prescribed_drugs')."";
			}

			if($this->input->post("lab"))
			{
				$doctors_notes = $doctors_notes."<hr/><b>Requested Laboratory Test</b><br/>";
				$doctors_notes = $doctors_notes.$this->input->post('lab_action');
			}


			if($this->input->post("nurse"))
			{
				$doctors_notes = $doctors_notes."<hr/><b>Requested Nurse Action</b><br/>";
				$doctors_notes = $doctors_notes.$this->input->post('nurse_action');
			}

			if($this->input->post("admit_patient"))
			{
				$doctors_notes = $doctors_notes."<hr/><b>Patient Admission Request</b><br/>";
				$doctors_notes = $doctors_notes.$this->input->post('note_description');
			}

			$doctors_notes = $doctors_notes."<hr/>";


			$staff = $this->staff_model->getStaff($staff_no);


			$history = $this->patient_history_model->getCurrentHistory($patient_number);

				if($history)
				{
					//update history

					$table_name = "patient_history";
					$id = "patient_history_id";
					$id_value = $history['patient_history_id'];

					$data = array(
						'doctors_notes' => $history['doctors_notes']."<br/> ".$doctors_notes ."<br/>---- <b>".$staff['first_name']." " .$staff['last_name']." on ".$this->get_date()."</b><br/>"."</hr>"
					);

					//$this->general_update_model->update($table_name,$id,$id_value, $data);

				}

				else
				{
					//add new history data
					$this->patient_history_model->set_History($patient_number,$staff_no,$description,$doctors_notes."<br/>---- <b>".$staff['first_name']." " .$staff['last_name']." on ".$this->get_date()."</b><br/></hr>");
				}

			//added by james 05 apr 2021
			
			       $this->Consultation_model->set_Consultation_master($patient_number,$staff_no, $doctors_notes,$description,$patient_family_id);
				   $consultation_id=$this->db->insert_id();
				   
					
					if($this->input->post("presenting_history")){
						$this->Consultation_model->set_Consultation('consultation_presenting_history',$patient_number,$consultation_id,$staff_no,'presenting_history',$this->input->post('presenting_history_action'),$patient_family_id);
					}
					
					if($this->input->post("obstetrics_history")){
						$this->Consultation_model->set_Consultation('consultation_obstetrics',$patient_number,$consultation_id,$staff_no,'obstetrics_history',$this->input->post('obstetrics_history_action'),$patient_family_id);
					}
					
					if($this->input->post("gynaecology_history")){
						$this->Consultation_model->set_Consultation('consultation_gynaecology',$patient_number,$consultation_id,$staff_no,'gynaecology_history',$this->input->post('gynaecology_history_action'),$patient_family_id);
					}
					
					if($this->input->post("familyhistory")){
						$this->Consultation_model->set_Consultation('consultation_family_social',$patient_number,$consultation_id,$staff_no,'family_social_history',$this->input->post('familyhistory_action'),$patient_family_id);
					}
					
					if($this->input->post("surgeryhistory")){
						$this->Consultation_model->set_Consultation('consultation_surgery',$patient_number,$consultation_id,$staff_no,'surgery_history',$this->input->post('surgeryhistory_action'),$patient_family_id);
					}
					
					if($this->input->post("systemreview")){
						$this->Consultation_model->set_Consultation_systemreview('consultation_review_systems',$patient_number,$consultation_id,$staff_no,'review_system',$this->input->post('systemreview_action'),$this->input->post('systemreview_cns'),$this->input->post('systemreview_respiratory'),$this->input->post('systemreview_cardio'),$this->input->post('systemreview_git'),$this->input->post('systemreview_urinary'),$this->input->post('systemreview_genital'),$this->input->post('systemreview_musculo'),$patient_family_id);
					}
					
					if($this->input->post("pastmedicalhistory")){
						$this->Consultation_model->set_Consultation('consultation_past_medical_history',$patient_number,$consultation_id,$staff_no,'past_medical_history',$this->input->post('pastmedicalhistory_action'),$patient_family_id);
					}
																		
					if($this->input->post("examination")){
						$this->Consultation_model->set_Consultation_examination('consultation_examination',$patient_number,$consultation_id,$staff_no,'examination',$this->input->post('examination_action'),$this->input->post('examination_head_neck'),$this->input->post('examination_upper_limp'),$this->input->post('examination_abdomen'),$this->input->post('examination_ve'),$this->input->post('examination_pr'), $patient_family_id);
					}
					
										
					if($this->input->post("diagnosis")){
						$this->Consultation_model->set_Consultation('consultation_diagnosis',$patient_number,$consultation_id,$staff_no,'diagnosis',$this->input->post('diagnosis_action'),$patient_family_id);
					}
					
					if($this->input->post("treatment")){
						$this->Consultation_model->set_Consultation('consultation_treatment',$patient_number,$consultation_id,$staff_no,'treatment',$this->input->post('treatment_action'),$patient_family_id);
					}
					
					if($this->input->post("allergy")){
						$this->Consultation_model->set_Consultation('consultation_allergy',$patient_number,$consultation_id,$staff_no,'allergy',$this->input->post('allergy_action'),$patient_family_id);
					}
					
					if($this->input->post("referal")){
						$this->Consultation_model->set_Consultation_referal('consultation_refferal',$patient_number,$consultation_id,$staff_no,$this->input->post('referal_referalreason'),$this->input->post('referal_action'),$this->input->post('referal_hospitalname'),$this->input->post('referal_hospitaladdress'),$patient_family_id);
					}


			//remove pateint from current patient
			$table_name = "doctor_current_patient";
				$id = "staff_no";
				$id_value = $staff_no;

				$data = array(
					'queue_number' => null,
					'status' => 'F'
				);

				$this->general_update_model->update($table_name,$id,$id_value, $data);


				$this->session->unset_userdata('current_patient');
				
				$this->session->unset_userdata('patient_family_id_new');


				//add all the actions that are required to the corresponding order management record

				$history = $this->patient_history_model->getCurrentHistory($patient_number);

				if($history){

					if($this->input->post('drugs'))
					{
						$this->omt_model->set_Omt($this->session->userdata('staff_no'),
								  'drugs', $history['patient_history_id'], $this->input->post('prescribed_drugs'));
					}

					if($this->input->post('lab'))
					{
						$this->omt_model->set_Omt($this->session->userdata('staff_no'),
								  'lab', $history['patient_history_id'], $this->input->post('lab_action'));
					}


					if($this->input->post('nurse'))
					{
						$this->omt_model->set_Omt($this->session->userdata('staff_no'),
								  'nurse', $history['patient_history_id'], $this->input->post('nurse_action'));
					}
					
					if($this->input->post('referal'))
					{
						$this->omt_model->set_Omt_referal($this->session->userdata('staff_no'),
								  'referal', $history['patient_history_id'], $this->input->post('referal_action'), $consultation_id);
					}
					
					if($this->input->post('admit_patient'))
					{

						$this->omt_model->set_Omt($this->session->userdata('staff_no'),
								  'admit', $history['patient_history_id'], $this->input->post('note_description'));
					}
				}

					//added by James on 08 sep 2021 to capture queues for admin staffs
					$this->omt_model->set_Omt($this->session->userdata('staff_no'), 'admin', $history['patient_history_id'], 'View the Paitent History to see what the doctor prescribed');


				redirect('/workbench');
		}
		else
		{
			redirect('/login');
		}
	}
	
	private function get_date()
	{
		$date = new DateTime();
		date_timezone_set($date, timezone_open('Africa/Lagos'));
		$todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
		return $todaysDate;
	}
	
	public function forcePerformAction()
	{
		$patient_number = $this->input->post("patient_number");

		//first create order
		$history = $this->patient_history_model->getCurrentHistory($patient_number);
		$staff_no = $this->session->userdata("staff_no");
		$staff = $this->staff_model->getStaff($staff_no);
		if(!$history)
		{
			$this->patient_history_model->set_History($patient_number,
								  $staff_no,
								  "Admitted Patient Administration",
								  "History Created by ".$staff['first_name']." " .$staff['last_name']." on ".$this->get_date()."</b><br/>");

			$history = $this->patient_history_model->getCurrentHistory($patient_number);

		}

		$this->omt_model->set_Omt($this->session->userdata('staff_no'),
								  'nurse', $history['patient_history_id'], "Direct Administration Action, Initiated by ".$staff['first_name']." " .$staff['last_name']);

		$order = $this->omt_model->getPatientLastOmt("nurse", $history['patient_history_id']);

		$array = array('patient_need_action'=>$order['order_id'], 'patient_history'=>$history, 'action_type' => "nurse");

		$this->session->set_userdata($array);

		redirect('\workbench');
	}
	
	public function forceTakeUpPatient()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->confirmUrl();
			$this->confirmRole();

			if(!$this->input->post('patient_number'))
			{
				$array = array('notice'=>INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/home');
			}

			//get patient data

			$patientData = $this->patient_model->getPatient($this->input->post('patient_number'));

			if(!$patientData)
			{
				$array = array('notice'=>INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/home');
			}


			$queueNumber =  $this->getQueueNumber();

			$department = null;
			$staff_no  = $this->session->userdata("staff_no");

			$staff  = $this->staff_master_model->getStaff($staff_no);
					//print_r($staff);
			$department = $staff['dept_id'];


			$patient_number  = $this->input->post('patient_number');
			
			$patient_family_id_new  = $this->input->post('patient_family_id_new');

			/**
			check if already in todays queue
			**/

			if($this->input->post("patient_family_id"))
			{
				$isInQueue = $this->daily_schedule_model->checkifFamAlreadyQueued($patient_number, $department, $this->input->post("patient_family_id"), $staff_no);
			}
			else
			{
				$isInQueue = $this->daily_schedule_model->checkifAlreadyQueued($patient_number, $department, $staff_no);
			}


					if($isInQueue)
					{
						if($isInQueue['status'] == "L")
						{


							$table_name = "daily_schedule";
							$id = "schdule_id";
							$id_value = $isInQueue['schdule_id'];


							$data = array(
								'queue_number' => $queueNumber,
								'status' => 'A'
							);


							if($department)
							{
								$data['dept_id'] = $department;
							}

							if($staff_no)
							{
								$data['staff_no'] = $staff_no;
							}

							if($patient_number)
							{
								$data['patient_number'] = $patient_number;
							}

							$patient_family_id = NULL;

							if($this->input->post("patient_family_id"))
							{
								$patient_family_id = $this->input->post("patient_family_id");
								$data['patient_family_id'] = $this->input->post("patient_family_id");
							}

							$this->general_update_model->update($table_name,$id,$id_value, $data);

						}


					}
					else
					{
						$this->daily_schedule_model->set_queue_proper($queueNumber, $department, $staff_no, $patient_number, NULL);
					}



					if($this->input->post("patient_family_id"))
					{
						$queueDetails = $this->daily_schedule_model->checkifFamAlreadyQueued($patient_number, $department, $this->input->post("patient_family_id"), $staff_no);
					}
					else
					{
						$queueDetails = $this->daily_schedule_model->checkifAlreadyQueued($patient_number, $department, $staff_no);
					}

					$schedule_id = $queueDetails['schdule_id'];

					$currentPatientWith = $this->current_patient_model->getCurrentPatientWithDoc($staff_no);

					//if no record exits
					if($currentPatientWith == "" || empty($currentPatientWith) || sizeof($currentPatientWith) < 1)
					{
						$this->current_patient_model->set_CurrentPatientWithDoc($staff_no,
													$schedule_id);


					}
					else
						{
							$table_name = "doctor_current_patient";
							$id = "staff_no";
							$id_value = $staff_no;

							 $date = new DateTime();
							date_timezone_set($date, timezone_open('Africa/Lagos'));
							$todaysDate =  date_format($date, 'H:i:s') ;


						      $data = array(
								'queue_number' => $schedule_id,
								'time_entered' => $todaysDate,
								'status' => 'A'
							);

							$this->general_update_model->update($table_name,$id,$id_value, $data);



							$table_name = "daily_schedule";
							$id = "schdule_id";
							$id_value = $schedule_id;

							$data = array(

								'status' => 'L'
							);

							$this->general_update_model->update($table_name,$id,$id_value, $data);
						}


			
			
			$array['current_patient']= $this->patient_model->getPatient($queueDetails['patient_number']);
					$array['current_patient']['patient_family_id'] = "";
					$array['current_patient']['queue_number'] = $queueDetails['queue_number'];
					$array['current_patient']['date'] = $queueDetails['date'];
					$array['current_patient']['schdule_id'] = $queueDetails['schdule_id'];
					$array['current_patient']['patient_family_id'] = $this->input->post("patient_family_id");

					if(isset($queueDetails['patient_family_id']) && $queueDetails['patient_family_id'] != "")
					{
					 $family_member = $this->patient_model->getPatientFamMember($queueDetails['patient_family_id']);

					$array['current_patient']['first_name'] = $family_member['first_name'];
					$array['current_patient']['last_name'] = $family_member['last_name'];
					$array['current_patient']['middle_name'] = $family_member['middle_name'];
					$array['current_patient']['patient_family_id'] = $family_member['patient_family_id'];
					}

					$array['current_patient']['occupation'] = $this->occupation_model->getOccupation($array['current_patient']['occupation_id']);

					$this->session->set_userdata($array);

					redirect('/workbench');


		}
		else{
			redirect("/login");
		}
	}

	private function getQueueNumber()
	{
		return $this->daily_schedule_model->obtainQueueNumber();
	}

	public function takeUpPatient()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->confirmUrl();
			$this->confirmRole();
			
			if(!$this->input->post('staff_no') || !$this->input->post('schedule_id') )
			{
				$array = array('notice'=>INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/home');
			}
			
			$currentPatientWith = $this->current_patient_model->getCurrentPatientWithDoc($this->input->post('staff_no'));
			
			//return false;
			
			//if no record exits 
			if($currentPatientWith == "" || empty($currentPatientWith) || sizeof($currentPatientWith) < 1)
			{
				$this->current_patient_model->set_CurrentPatientWithDoc($this->input->post('staff_no'),
											$this->input->post('schedule_id'));
										
				
			}
			else
			{
				$table_name = "doctor_current_patient";
				$id = "staff_no";
				$id_value = $this->input->post('staff_no');
				$schedule_id = $this->input->post('schedule_id') ;
				
				 $date = new DateTime();
				date_timezone_set($date, timezone_open('Africa/Lagos'));
				$todaysDate =  date_format($date, 'H:i:s') ;
			    
			    
			      $data = array(
					'queue_number' => $schedule_id,
					'time_entered' => $todaysDate,
					'status' => 'A'
				);
			
				$this->general_update_model->update($table_name,$id,$id_value, $data);
				
				
				
				$table_name = "daily_schedule";
				$id = "schdule_id";
				$id_value = $schedule_id;
				
				$data = array(
					
					'status' => 'L'
				);
				
				$this->general_update_model->update($table_name,$id,$id_value, $data);
			}
			
			
			$queue = $this->daily_schedule_model->getDailySchedule($this->input->post('schedule_id'));
			
			
			$array['current_patient']= $this->patient_model->getPatient($queue['patient_number']);
					$array['current_patient']['patient_family_id'] = "";
					$array['current_patient']['queue_number'] = $queue['queue_number'];
					$array['current_patient']['date'] = $queue['date'];
					$array['current_patient']['schdule_id'] = $queue['schdule_id'];
					
					if(isset($queue['patient_family_id']) && $queue['patient_family_id'] != "")
					{
					 $family_member = $this->patient_model->getPatientFamMember($queue['patient_family_id']);
					
					$array['current_patient']['first_name'] = $family_member['first_name'];
					$array['current_patient']['last_name'] = $family_member['last_name'];
					$array['current_patient']['middle_name'] = $family_member['middle_name'];
					$array['current_patient']['patient_family_id'] = $family_member['patient_family_id'];
					}
					
					$array['current_patient']['occupation'] = $this->occupation_model->getOccupation($array['current_patient']['occupation_id']);
					
					$this->session->set_userdata($array);
					
					redirect('/workbench');
					
					
					
		}
		else{
			redirect('/login');
		}
	}
	
	public function dischargePatient()
	{
		$todaysDate = $this->get_date();


		if($this->session->userdata('logged_in'))
		{
			$this->confirmUrl();
			$this->moduleAccessCheck(DISCHARGE_PATIENT);
			if(!$this->input->post('patient_number'))
			{
				$array = array('notice'=>INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/home');
			}
			else
			{
				//check if the patient is really admitted in a ward
				$admission_data = $this->patient_admission_model->getPatientAdmission($this->input->post('patient_number'));
				if($admission_data)
				{
					$patient_number = $this->input->post('patient_number');
					$staff_no = $this->session->userdata('staff_no');
					$doctors_notes = "Discharged From Ward on ".$todaysDate;
					$description = "Patient Discharge";

					if($this->input->post('notes') && trim($this->input->post('notes')) != "")
					{
						$doctors_notes = $this->input->post('note_description')."<br/><br/>".$doctors_notes;
					}


					$staff = $this->staff_model->getStaff($staff_no);


					$history = $this->patient_history_model->getCurrentHistory($patient_number);
					//is there a current history in view
					if($history)
					{
						//update history

						$table_name = "patient_history";
						$id = "patient_history_id";
						$id_value = $history['patient_history_id'];

						$data = array(
							'doctors_notes' => $history['doctors_notes']."<br/> ".$doctors_notes ."<br/>---- <b>".$staff['first_name']." " .$staff['last_name']."</b><br/>"
						);

						$this->general_update_model->update($table_name,$id,$id_value, $data);

					}

					else
					{
						//add new history data
						$this->patient_history_model->set_History($patient_number,$staff_no,$description,$doctors_notes."<br/>---- <b>".$staff['first_name']." " .$staff['last_name']."</b><br/>");
					}


					//remove pateint from current patient
					$table_name = "doctor_current_patient";
					$id = "staff_no";
					$id_value = $staff_no;

					$data = array(
						'queue_number' => null,
						'status' => 'F'
					);

					$this->general_update_model->update($table_name,$id,$id_value, $data);


					$this->session->unset_userdata('current_patient');

					//discharge patient

					$table_name = "patient_admissions";
					$id = "id";
					$id_value = $admission_data['id'];

					$data = array(
						'status' => 'D',
						'date_discharged' => $todaysDate
					);

					$this->general_update_model->update($table_name,$id,$id_value, $data);

					//success
					$array = array('notice'=>"Patient Suceesfully Discharged");
					$this->session->set_userdata($array);
					redirect('/workbench');
				}
				else
				{
					$array = array('notice'=>PATIENT_NOT_IN_WARD);
					$this->session->set_userdata($array);
					redirect('/home');
				}
			}
		}
		else
		{
			redirect("/login");
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
	
	public function reassignWard()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->confirmUrl();
			$this->moduleAccessCheck(REASSIGN_PATIENT_TO_WARD);
			
			if(!$this->input->post('new_bed_id') || !$this->input->post('new_ward') || !$this->input->post('id') || !$this->input->post('patient_number'))
			{
				$array = array('notice'=>INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/home');
			}
			
			$todaysDate =  $this->get_date();
			$ward_details = $this->ward_model->getWard($this->input->post('new_ward'));
			
			//update ward and bed
			
				$table_name = "patient_admissions";
					$id = "id";
					$id_value = $this->input->post('id');
					
					$data = array(
						'ward_id'=>$this->input->post('new_ward'), 'bed_id' => $this->input->post('new_bed_id'));
					
					
		
					$this->general_update_model->update($table_name,$id,$id_value, $data);
					
					$description = "Patient Ward Update";
					$doctors_notes = "Patient Ward Changed to ".$ward_details['ward_name']." on ".$todaysDate;
					
					//update patient history
					$staff_no = $this->session->userdata('staff_no');
					$staff = $this->staff_model->getStaff($staff_no);					
					$history = $this->patient_history_model->getCurrentHistory($this->input->post('patient_number'));
					//is there a current history in view
					if($history)
					{
						//update history
						
						$table_name = "patient_history";
						$id = "patient_history_id";
						$id_value = $history['patient_history_id'];
						
						$data = array(
							'doctors_notes' => $history['doctors_notes']."<br/> ".$doctors_notes ."<br/>---- <b>".$staff['first_name']." " .$staff['last_name']."</b><br/>"
						);
						
						$this->general_update_model->update($table_name,$id,$id_value, $data);
					
					}
				
					else
					{
						//add new history data
						$this->patient_history_model->set_History($patient_number,$staff_no,$description,$doctors_notes."<br/>---- <b>".$staff['first_name']." " .$staff['last_name']."</b><br/>");
					}
					
					
					$array = array('notice'=>"Patinet Ward Successfully Changed");
					$this->session->set_userdata($array);
					redirect('/home');
		}
		else
		{
			redirect("/login");
		}
		
	}
	public function assignToWard()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->confirmUrl();
			$this->moduleAccessCheck(ASSIGN_PATIENT_TO_WARD);
			if(!$this->input->post('ward_id') || !$this->input->post('bed_id') || !$this->input->post('patient_number'))
			{
				$array = array('notice'=>INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/home');
			}
			
			//check if the patient has already been admitted	
			
			
			$admission_data = $this->patient_admission_model->getPatientAdmission($this->input->post('patient_number'));
			
			if($admission_data)
			{
				$array = array('notice'=>"Patient Already Admitted");
				$this->session->set_userdata($array);
				redirect('/home');
			}
			
			$order_details = $this->omt_model->getOmt($this->input->post('order_id'));
			
			//set admitted patient
			 $this->patient_admission_model->set_AdmittedPatient($this->input->post('ward_id')
						    , $this->input->post('bed_id'),
						       $order_details['created_by'],
						       $this->input->post('patient_number'));
			 
			 //update order status to processed
			 
			 
				$ward_details = $this->ward_model->getWard($this->input->post('ward_id'));
				
				$todaysDate =  $this->get_date();
		
				$table_name = "omt";
					$id = "id";
					$id_value = $this->input->post('order_id');
					
					$data = array(
						'status' => 'P', 'carried_out_on'=>$todaysDate, 'carried_out_by' => $this->session->userdata('staff_no'));
					
					
		
					$this->general_update_model->update($table_name,$id,$id_value, $data);
					
					
					 //update patient history to admitted
					 
					if(true)
					{
						$staff = $this->staff_model->getStaff($this->session->userdata('staff_no'));
						
						$history = $this->patient_history_model->getHistory($order_details['patient_history_id'],FALSE);
						
						$doctors_notes = "Patient Admitted ".$ward_details['ward_name']." on ".$todaysDate;
						
						$table_name = "patient_history";
						$id = "patient_history_id";
						$id_value = $order_details['patient_history_id'];
						
						$update = array(
							'doctors_notes' => $history['doctors_notes']."<br/> ".$doctors_notes ."<br/>---- <b>".$staff['first_name']." " .$staff['last_name']."</b><br/>"
						);
						
						$this->general_update_model->update($table_name,$id,$id_value, $update);
					}
					
					
					
					$array = array('notice'=>"Patient Successfully Admitted to ward");
					$this->session->set_userdata($array);
					redirect('/home');
			 
			
			
			
			
			
		}
		else{
			redirect("/login");
		}
		
	}
	
	
        public function changePassword()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->confirmUrl();
			$this->confirmRole();
			
			if(!$this->input->post('cur_pass') || !$this->input->post('new_pass') || !$this->input->post('new_pass_confirm'))
			{
				$array = array('notice'=>INVALID_FUNCTION_CALL);
				$this->session->set_userdata($array);
				redirect('/home');
			}
			
			
			$logindata['userlogindata'] = $this->ult->getuserloginByStaff($this->session->userdata('staff_no'));
			
			$isPwdCorrect = $this->passwordhash->CheckPassword(trim($this->input->post('cur_pass')),$logindata['userlogindata']['password']);
			
			if($isPwdCorrect)
			{
				$data["password"] = $this->passwordhash->HashPassword($this->input->post("new_pass"));
				
				$table_name = "ult";
				$id = "id";
				$id_value = $logindata['userlogindata']['id'];
				
				$this->general_update_model->update($table_name,$id,$id_value, $data);
				
				$array = array('notice'=>'Password updated Sucessfully, Please relogin with new password to complete change');
				$this->session->set_userdata($array);

                $staff = $this->staff_model->getStaff($this->session->userdata('staff_no'));

                $parameters["username"] = $logindata['userlogindata']["username"];
                $parameters["password"] = $this->input->post('new_pass');
                //send email to staff with his credentials
                $this->utilities->sendHtmlEmail(PASSWORD_RESET_EMAIL_TEMPLATE,
                    $parameters, $staff["email"], "Password Change");


				redirect('/workbench');
				
			}
			else{
				$array = array('notice'=>"Incorrect Password");
				$this->session->set_userdata($array);
				redirect('/workbench');
			}
			
			
		}
		else{
			redirect('/login');
		}
		
	}
                
                
        public function index()
        {
           if($this->session->userdata('logged_in'))
			{
			$this->confirmUrl();
			$this->confirmRole();
			//$this->moduleAccessCheck(ADMIN);
                        
                        //get all user module mappings by role
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			
			if($this->session->userdata('patient_family_id_new')){
			$data['patient_family_id_new']  = $this->session->userdata('patient_family_id_new');
			}
			
			if($this->session->userdata('patient_family_id')){
				$data['patient_family_id']  = $this->session->userdata('patient_family_id');
			}
			
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
			//only system, doctors and nurses are permitted to see this page
			if($data['user_role']['role_id'] == 3 && $this->session->userdata('staff_no') != "2005/10/01")
			{
				redirect('/home');
			}
			
			if(!$this->session->userdata('current_patient'))
			{
				$current_patient = $this->current_patient_model->getCurrentActivePatientWithDoc($this->session->userdata('staff_no'));
				//if there is a patient he has not finished with
				if($current_patient)
				{
					//print_r($current_patient);
					
					$queue = $this->daily_schedule_model->getDailySchedule($current_patient['queue_number']);
			
					if(isset($queue['patient_number'])){
					
					$array['current_patient']= $this->patient_model->getPatient($queue['patient_number']);
							$array['current_patient']['patient_family_id'] = "";
							$array['current_patient']['queue_number'] = $queue['queue_number'];
							$array['current_patient']['date'] = $queue['date'];
							$array['current_patient']['schdule_id'] = $queue['schdule_id'];
					}		
					
					if(isset($queue['patient_family_id']) && $queue['patient_family_id'] != "")
					{
					 $family_member = $this->patient_model->getPatientFamMember($queue['patient_family_id']);
					
					$array['current_patient']['first_name'] = $family_member['first_name'];
					$array['current_patient']['last_name'] = $family_member['last_name'];
					$array['current_patient']['middle_name'] = $family_member['middle_name'];
					$array['current_patient']['patient_family_id'] = $family_member['patient_family_id'];
					}
					
					
					$array['current_patient']['occupation'] = $this->occupation_model->getOccupation($array['current_patient']['occupation_id']);
					
					$this->session->set_userdata($array);
					
				}
				
				
			}
			
			if($this->session->userdata('current_patient'))
			{
				$current_patient = $this->session->userdata('current_patient');

				if(isset($current_patient['patient_number'])){				
				$history = $this->patient_history_model->getCurrentHistory($current_patient['patient_number']);
				
				if($history)
				{
					$data['history_data'] = $history;					
				}
				}
			}
			$actio = $this->session->userdata('patient_need_action');
			
			//this is used incase a nurse selects an action from lab or pharmacy side to see patient data
			if($this->session->userdata('patient_need_action') )
			{
				$data['action_type'] = $this->session->userdata('action_type');
				$data['order_id'] = $this->session->userdata('patient_need_action');
				$order_details = $this->omt_model->getOmt($data['order_id']);
				//$data['referalID']=7;
				$data['referalID']=$this->Consultation_model->getReferralReportByConsultationId($order_details['consultation_id']);
				
				$history_to_be_actioned = $this->session->userdata('patient_history');
				$data['action_details']  = $order_details['notes'];
				$data['action_patient'] = $this->patient_model->getPatient($history_to_be_actioned['patient_number']);
				$data['hmo_name'] = $this->patient_model->getHmoDetails($data['action_patient']['hmo_code']);
				
				
				if($history_to_be_actioned['patient_family_id'])
				{
				
					// $data['family_member'] = $this->patient_model->getPatientFamMember($history_to_be_actioned['patient_family_id']);
					// $data['family_member'] = $this->patient_model->getPatientFamMember($history_to_be_actioned['patient_family_id']);
					
					echo('balles');
					$this->session->unset_userdata('patient_family_id');
					$this->session->unset_userdata('family_member');
										
					$data['action_patient']['dob'] = $data['family_member']['dob'];
					$data['action_patient']['first_name'] = $data['family_member']['first_name'];
					$data['action_patient']['middle_name'] = $data['family_member']['middle_name'];
					$data['action_patient']['last_name'] = $data['family_member']['last_name'];
					$data['action_patient']['last_name'] = $data['family_member']['last_name'];
					$data['action_patient']['mobile_number'] = $data['family_member']['mobile_number'];
					$data['action_patient']['cell_number'] = $data['family_member']['cell_number'];
					$data['action_patient']['email'] = $data['family_member']['email'];
					$data['action_patient']['alt_email'] = $data['family_member']['alt_email'];
					$data['action_patient']['email'] = $data['family_member']['email'];
					$data['action_patient']['sex'] = $data['family_member']['sex'];
					$data['action_patient']['phenotype_id'] = $data['family_member']['phenotype_id'];
					$data['action_patient']['blood_group_id'] = $data['family_member']['blood_group_id'];
					$data['action_patient']['occupation_id'] = "";
					$data['action_patient']['weight'] = $data['family_member']['weight'];
					$data['action_patient']['height'] = $data['family_member']['height'];
					
					
				
				
					
				}
				
				
				$this->session->unset_userdata('patient_need_action');
				$this->session->unset_userdata('action_type');
				$this->session->unset_userdata('patient_history');
				$this->session->unset_userdata('order_id');
			}
			//$array = array('patient_need_action'=>TRUE, 'patient_history'=>$patient_history);
		
		
			
			$data['staff'] = $this->staff_model->getStaff($this->session->userdata('staff_no'));
			
			$data['address_country_code'] = $this->country_model->getCountries($data['staff']['address_country_code']);
			$data['address_state_code'] = $this->state_model->getState($data['staff']['address_state_code']);
			    
			$data['department'] = $this->department_model->getDepartments($data['staff']['dept_id']);
			$data['role'] = $this->role_model->getrole($data['staff']['role_id']);
			$data['group'] = $this->user_groups_model->getUserGroups($data['staff']['group_id']);
			$data['address_states'] = $this->state_model->getStateByCountry($data['staff']['address_country_code']);
			$data['countries'] = $this->country_model->getCountries();
			$data['pic'] = $this->profile_pics_model->getuserpic($this->session->userdata('staff_no'));
			     
			     //if there is a current patient set find out if the patient is admitted
			 if($this->session->userdata('current_patient'))
				{
				    $current_patient = $this->session->userdata('current_patient');
					if(isset($current_patient['patient_number'])){
						
				    $admission_data['admission_data'] = $this->patient_admission_model->getPatientAdmission($current_patient['patient_number']);
					
				    
				    if($admission_data['admission_data'])
				    {
					$this->session->set_userdata($admission_data);
					
				    }	
					}
				
				}
			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
			$data['shifts'] = $this->shift_model->getShift();
                        $data['wards'] = $this->ward_model->getWard();
                        $data['usergroups'] =  $this->user_groups_model->getUserGroups();
			$data['departments'] = $this->department_model->getDepartments();
			$data['staffs'] = $this->staff_model->getStaff();
			
			$data['title'] = "Medstation | Workbench";
			$data['content-description'] = "Hospital Workbench";
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/mainheader', $data);
			$this->load->view('workbench/home');
			$this->load->view('templates/footer');
		
                }
                
                else{
                    
                    redirect('/login');
                }
        }
        
		
		
		
		public function printReferalDoc($referalID)
			{
				

				
				$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
				//get the role title
				$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
				$data['hmos'] = $this->hmo_model->getHmo();

				$data['currentmodule']['number'] = MODULE_NO;
				$data['currentmodule']['title'] = TITLE;
				$data['departments'] = $this->department_model->getDepartments();
				$data['doctors'] = $this->staff_master_model->getDoctors();
				$data['referaldetails'] =  $this->Consultation_model->getReferralReportById($referalID);
				//print_r ($data['referaldetails']);
				$data['referalnotes']=$data['referaldetails'][0]['refferal_notes'];
				$data['patient'] = $this->patient_model->getPatient($data['referaldetails'][0]['patient_number']);
				$data['referaldetails'] = $data['referaldetails'][0];
				
				$data['state'] = $this->state_model->getState($data['patient']['address_state_code']);
				$data['country'] = $this->country_model->getCountries($data['patient']['address_country_code']);

				$data['title'] = "Medstation | Referal Document";
				$data['content-description'] = "Referal Document Management";
				//$data['post_access'] = $this->chceckPostAccess();
				$data['hmo_name'] = $this->hmo_model->getHmo($data['patient']['hmo_code']);
				

				$data['enableBack'] = true;



				$this->load->view('templates/header', $data);
				$this->load->view('workbench/referal_print');
				//$this->load->view('templates/footer', $data);


			}
		
}