<?php

class Consultation_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }


    public function getAllergy( $patient_number, $patient_family_id)
    {
        $this->load->helper('url');


        if ((isset($patient_family_id))&&($patient_family_id!='')) {
            $this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_allergy');
            $this->db->where("(`patient_number` = '$patient_number')");
			$this->db->where("(`patient_family_id` = '$patient_family_id')");
            $query = $this->db->get();
            return $query->result_array();
        }else{
			$this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_allergy');
            $this->db->where("(`patient_number` = '$patient_number')");
            $query = $this->db->get();
            return $query->result_array();
		}

        //$query = $this->db->get_where('consultation_allergy', array('consultation_id' => $patient_history_id));
        //return $query->row_array();
    }
	
	public function getExamination( $patient_number, $patient_family_id)
    {
        $this->load->helper('url');


        if ((isset($patient_family_id))&&($patient_family_id!='')) {
            $this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_examination');
            $this->db->where("(`patient_number` = '$patient_number')");
			$this->db->where("(`patient_family_id` = '$patient_family_id')");
            $query = $this->db->get();
            return $query->result_array();
		}
		else{
			$this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_examination');
            $this->db->where("(`patient_number` = '$patient_number')");
            $query = $this->db->get();
            return $query->result_array();
			
		}
        
    }
	
	public function getDiagnosis( $patient_number, $patient_family_id)
    {
        $this->load->helper('url');


        if ((isset($patient_family_id))&&($patient_family_id!='')) {
            $this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_diagnosis');
            $this->db->where("(`patient_number` = '$patient_number')");
			$this->db->where("(`patient_family_id` = '$patient_family_id')");
            $query = $this->db->get();
            return $query->result_array();
		}else{
			$this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_diagnosis');
            $this->db->where("(`patient_number` = '$patient_number')");
            $query = $this->db->get();
            return $query->result_array();
			
		}
		
        
    }
	
	public function getFamilyhistory( $patient_number, $patient_family_id)
    {
        $this->load->helper('url');


        if ((isset($patient_family_id))&&($patient_family_id!='')) {
            $this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_family_social');
            $this->db->where("(`patient_number` = '$patient_number')");
			$this->db->where("(`patient_family_id` = '$patient_family_id')");
            $query = $this->db->get();
            return $query->result_array();
		}else{
			$this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_family_social');
            $this->db->where("(`patient_number` = '$patient_number')");
            $query = $this->db->get();
            return $query->result_array();
		
		}
        
    }
	
	public function getGynaecology( $patient_number, $patient_family_id)
    {
        $this->load->helper('url');


        if ((isset($patient_family_id))&&($patient_family_id!='')) {
            $this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_gynaecology');
            $this->db->where("(`patient_number` = '$patient_number')");
			$this->db->where("(`patient_family_id` = '$patient_family_id')");
            $query = $this->db->get();
            return $query->result_array();
		}else{
			$this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_gynaecology');
            $this->db->where("(`patient_number` = '$patient_number')");
            $query = $this->db->get();
            return $query->result_array();
		}
        
    }
	
	public function getObstetrics( $patient_number, $patient_family_id)
    {
        $this->load->helper('url');


        if ((isset($patient_family_id))&&($patient_family_id!='')) {
            $this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_obstetrics');
            $this->db->where("(`patient_number` = '$patient_number')");
			$this->db->where("(`patient_family_id` = '$patient_family_id')");
            $query = $this->db->get();
            return $query->result_array();
		}else{
			$this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_obstetrics');
            $this->db->where("(`patient_number` = '$patient_number')");
            $query = $this->db->get();
            return $query->result_array();
		}
        
    }
	
	public function getPastmedicalhistory( $patient_number, $patient_family_id)
    {
        $this->load->helper('url');


        if ((isset($patient_family_id))&&($patient_family_id!='')) {
            $this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_past_medical_history');
            $this->db->where("(`patient_number` = '$patient_number')");
			$this->db->where("(`patient_family_id` = '$patient_family_id')");
            $query = $this->db->get();
            return $query->result_array();
		}else{
			$this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_past_medical_history');
            $this->db->where("(`patient_number` = '$patient_number')");
            $query = $this->db->get();
            return $query->result_array();
		}
        
    }
	
	public function getPresentinghistory( $patient_number, $patient_family_id)
    {
        $this->load->helper('url');


        if ((isset($patient_family_id))&&($patient_family_id!='')) {
            $this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_presenting_history');
            $this->db->where("(`patient_number` = '$patient_number')");
			$this->db->where("(`patient_family_id` = '$patient_family_id')");
            $query = $this->db->get();
            return $query->result_array();
		}else{
			$this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_presenting_history');
            $this->db->where("(`patient_number` = '$patient_number')");
            $query = $this->db->get();
            return $query->result_array();
		}
        
    }
	
	public function getSystemreview( $patient_number, $patient_family_id)
    {
        $this->load->helper('url');


        if ((isset($patient_family_id))&&($patient_family_id!='')) {
            $this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_review_systems');
            $this->db->where("(`patient_number` = '$patient_number')");
			$this->db->where("(`patient_family_id` = '$patient_family_id')");
            $query = $this->db->get();
            return $query->result_array();
		}else{
			$this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_review_systems');
            $this->db->where("(`patient_number` = '$patient_number')");
            $query = $this->db->get();
            return $query->result_array();
		}
        
    }
	
	public function getSurgery( $patient_number, $patient_family_id)
    {
        $this->load->helper('url');


        if ((isset($patient_family_id))&&($patient_family_id!='')) {
            $this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_surgery');
            $this->db->where("(`patient_number` = '$patient_number')");
			$this->db->where("(`patient_family_id` = '$patient_family_id')");
            $query = $this->db->get();
            return $query->result_array();
		}else{
			$this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_surgery');
            $this->db->where("(`patient_number` = '$patient_number')");
            $query = $this->db->get();
            return $query->result_array();
		
		}
        
    }
	
	public function getTreatment( $patient_number, $patient_family_id)
    {
        $this->load->helper('url');


        if ((isset($patient_family_id))&&($patient_family_id!='')) {
            $this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_treatment');
            $this->db->where("(`patient_number` = '$patient_number')");
			$this->db->where("(`patient_family_id` = '$patient_family_id')");
            $query = $this->db->get();
            return $query->result_array();
		}else{
			$this->db->select('*');
            $this->db->order_by("date_time_created", "desc");
            $this->db->from('consultation_treatment');
            $this->db->where("(`patient_number` = '$patient_number')");
            $query = $this->db->get();
            return $query->result_array();
		}
        
    }
	
	public function getConsultationMaster($patient_number, $patient_family_id)
    {
        $this->load->helper('url');


        if ((isset($patient_family_id))&&($patient_family_id!='')) {
            $this->db->select('*');
            $this->db->order_by("date_created", "desc");
            $this->db->from('consultation_master');
            $this->db->where("(`patient_number` = '$patient_number')");
			$this->db->where("(`patient_family_id` = '$patient_family_id')");
            $query = $this->db->get();
            return $query->result_array();
		}else{
			$this->db->select('*');
            $this->db->order_by("date_created", "desc");
            $this->db->from('consultation_master');
            $this->db->where("(`patient_number` = '$patient_number')");
            $query = $this->db->get();
            return $query->result_array();
		}
        
    }


	public function getVitalhistory($patient_number,$patient_family_id)
    {
        $this->load->helper('url');

		if ((isset($patient_family_id))&&($patient_family_id!='')) {
			$this->db->select('*');
			$this->db->order_by("date_created", "desc");
			$this->db->from('patient_vitals');
			$this->db->where("(`patient_number` = '$patient_number')");
			$this->db->where("(`patient_family_id` = '$patient_family_id')");
			$this->db->limit(20);
			$query = $this->db->get();
			return $query->result_array();
		}else{
			$this->db->select('*');
			$this->db->order_by("date_created", "desc");
			$this->db->from('patient_vitals');
			$this->db->where("(`patient_number` = '$patient_number')");
			$this->db->limit(20);
			$query = $this->db->get();
			return $query->result_array();
			
		}
	
    }

    public function getRecentHistory($patient_number)
    {
        $this->load->helper('url');

        $this->db->select('*');
        $this->db->order_by("date_created", "desc");
        $this->db->from('patient_history');
        $this->db->where("(`patient_number` = '$patient_number')");
        $this->db->limit(4);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getCurrentHistory($patient_number)
    {
        $this->load->helper('url');


        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $endate = date_format($date, 'Y-m-d H:i:s');

        $startdate = date("Y-m-d H:i:s", strtotime('-24 hours'));


        $this->db->select('*');
        $this->db->order_by("date_created", "desc");
        $this->db->from('patient_history');
        $this->db->where("(`patient_number` = '$patient_number' AND (date_created BETWEEN '$startdate' AND '$endate' ) )");
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();


    }


    public function set_Consultation($table_name,$patient_number,$consultation_id,$consulting_doctor,$columnname,$columvalue,$patient_family_id)
    {
        $this->load->helper('url');

        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');

		if (isset($patient_family_id)) {
			$data = array(
				'patient_number' => $patient_number,
				'consultation_id' => $consultation_id,
				'consulting_doctor' => $consulting_doctor,
				$columnname => $columvalue,
				'patient_family_id' => $patient_family_id,
				'date_time_created' => $todaysDate
			);
		}
		else{
			$data = array(
				'patient_number' => $patient_number,
				'consultation_id' => $consultation_id,
				'consulting_doctor' => $consulting_doctor,
				$columnname => $columvalue,
				'date_time_created' => $todaysDate
			);			
		}
		
		
        return $this->db->insert($table_name, $data);

    }
	
	
	public function set_Consultation_examination($table_name,$patient_number,$consultation_id,$consulting_doctor,$columnname,$columvalue,$examination_head_neck,$examination_upper_limp,$examination_abdomen,$examination_ve,$examination_pr,$patient_family_id)
    {
        $this->load->helper('url');

        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');

		if (isset($patient_family_id)) {
			$data = array(
				'patient_number' => $patient_number,
				'consultation_id' => $consultation_id,
				'consulting_doctor' => $consulting_doctor,
				$columnname => $columvalue,
				'hand_neck' => $examination_head_neck,
				'upper_limp' => $examination_upper_limp,
				'abdomen' => $examination_abdomen,
				've' => $examination_ve,
				'pr' => $examination_pr,
				'patient_family_id' => $patient_family_id,
				'date_time_created' => $todaysDate
			);
		}
		else{
			$data = array(
				'patient_number' => $patient_number,
				'consultation_id' => $consultation_id,
				'consulting_doctor' => $consulting_doctor,
				$columnname => $columvalue,
				'hand_neck' => $examination_head_neck,
				'upper_limp' => $examination_upper_limp,
				'abdomen' => $examination_abdomen,
				've' => $examination_ve,
				'pr' => $examination_pr,
				'date_time_created' => $todaysDate
			);			
		}
		
		
        return $this->db->insert($table_name, $data);

    }
	
	public function set_Consultation_systemreview($table_name,$patient_number,$consultation_id,$consulting_doctor,$columnname,$columvalue,$systemreview_cns,$systemreview_respiratory,$systemreview_cardio,$systemreview_git,$systemreview_urinary,$systemreview_genital,$systemreview_musculo,$patient_family_id)
    {
        $this->load->helper('url');

        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');

		if (isset($patient_family_id)) {
			$data = array(
				'patient_number' => $patient_number,
				'consultation_id' => $consultation_id,
				'consulting_doctor' => $consulting_doctor,
				$columnname => $columvalue,
				'cns' => $systemreview_cns,
				'respiratory' => $systemreview_respiratory,
				'cardiovascular' => $systemreview_cardio,
				'git' => $systemreview_git,
				'urinary' => $systemreview_urinary,
				'genital' => $systemreview_genital,
				'musculoskeletal' => $systemreview_musculo,
				'patient_family_id' => $patient_family_id,
				'date_time_created' => $todaysDate
			);
		}
		else{
			$data = array(
				'patient_number' => $patient_number,
				'consultation_id' => $consultation_id,
				'consulting_doctor' => $consulting_doctor,
				$columnname => $columvalue,
				'cns' => $systemreview_cns,
				'respiratory' => $systemreview_respiratory,
				'cardiovascular' => $systemreview_cardio,
				'git' => $systemreview_git,
				'urinary' => $systemreview_urinary,
				'genital' => $systemreview_genital,
				'musculoskeletal' => $systemreview_musculo,
				'date_time_created' => $todaysDate
			);			
		}
		
		
        return $this->db->insert($table_name, $data);

    }
	
		
	public function set_Consultation_master($patient_number,$consulting_doctor, $doctorsnotes,$description, $patient_family_id)
    {
        $this->load->helper('url');

        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');


        $data = array(
            'patient_number' => $patient_number,
            'consulting_doctor' => $consulting_doctor,
            'doctors_notes' => $doctorsnotes,
			'date_created' => $todaysDate,
			'status' => 'A',
			'description' => $description,
			'patient_family_id' => $patient_family_id 
        );


        return $this->db->insert('consultation_master', $data);

    }
	
	
	
	public function set_referal()
            {
                     $this->load->helper('url');
                    
                    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
                    /**
                     *
                     *id`, `patient_number`, `temperature`, `blood_pressure`, `pulse`, `respiratory_rate`, `date_created`, `status
                     */
                    
                     $data = array(
                            'patient_number' => $this->input->post('patient_number'),
                            'reason' => strtolower($this->input->post('referalreason')),
                            'refferal_notes' => strtolower($this->input->post('referalnotes')),
                            'hospital_name' => strtolower($this->input->post('hospitalname')),
                            'address' => strtolower($this->input->post('hospitaladdress')),
                            'date_time_created' => $todaysDate,
							'consulting_doctor' => $this->session->userdata('staff_no'),
                            'status' => "A"
                            );
                     
							 
					 if($this->input->post('patient_family_id'))
					 {
							$data['patient_family_id'] = $this->input->post('patient_family_id');
					 }
		     
		     
		    
		     
                     return $this->db->insert('consultation_refferal', $data);
                
            }
	


		public function set_Consultation_referal($table_name,$patient_number,$consultation_id,$consulting_doctor,$referalreason,$reasonnotes,$hostpitalname,$address,$patient_family_id)
			{
				$this->load->helper('url');

				$date = new DateTime();
				date_timezone_set($date, timezone_open('Africa/Lagos'));
				$todaysDate = date_format($date, 'Y-m-d H:i:s');

				if (isset($patient_family_id)) {
					$data = array(
						'patient_number' => $patient_number,
						'consultation_id' => $consultation_id,
						'reason' => $referalreason,
						'refferal_notes' => $reasonnotes,
						'hospital_name' => $hostpitalname,
						'address' => $address,
						'consulting_doctor' => $consulting_doctor,
						'status' => "A",
						'patient_family_id' => $patient_family_id,
						'date_time_created' => $todaysDate
					);
				}
				else{
					$data = array(
						'patient_number' => $patient_number,
						'consultation_id' => $consultation_id,
						'reason' => $referalreason,
						'refferal_notes' => $reasonnotes,
						'hospital_name' => $hostpitalname,
						'address' => $address,
						'consulting_doctor' => $consulting_doctor,
						'status' => "A",
						'date_time_created' => $todaysDate
					);			
				}
				
				
				return $this->db->insert($table_name, $data);

			}

	
			
			public function getReferralDetails($patient_number)
				{
					$this->load->helper('url');

					$this->db->select('*');
					$this->db->order_by("date_time_created", "desc");
					$this->db->from('consultation_refferal');
					$this->db->where("(`patient_number` = '$patient_number')");
					//$this->db->limit(4);
					$query = $this->db->get();
					return $query->result_array();
				}
				
				
			public function getReferralReportById($id)
				{
					
						$this->db->select('*');
					$this->db->order_by("date_time_created","desc");
					$this->db->from('consultation_refferal');
					$this->db->where("id = '$id'");
					$this->db->where("status = 'A'");
					$query=$this->db->get();
					return $query->result_array();
					
					
						//$query = $this->db->get_where('post_delivery', array('delivery_id' => $id,'status'=>'A'));
						//return $query->row_array();
				}
				
				
			public function getReferralReportByConsultationId($id)
				{
					
						$this->db->select('*');
					$this->db->order_by("date_time_created","desc");
					$this->db->from('consultation_refferal');
					$this->db->where("consultation_id = '$id'");
					$this->db->where("status = 'A'");
					$query=$this->db->get();
					return $query->result_array();
					

				}


}