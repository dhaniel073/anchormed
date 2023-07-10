<?php
class Vitals_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
        public function getVitals($patient_number)
            {
		
		
                        $this->db->select('*');
			$this->db->order_by("date_created","desc");
			$this->db->from('patient_vitals');
                        $this->db->where("(`patient_number` = '$patient_number' AND `patient_family_id` is null)");
                        $this->db->limit(1);
			$query=$this->db->get();
			return $query->row_array();
            }
	    
	     public function getFamVitals($patient_number,$family_id)
            {
		
		
                        $this->db->select('*');
			$this->db->order_by("date_created","desc");
			$this->db->from('patient_vitals');
                        $this->db->where("(`patient_number` = '$patient_number' AND `patient_family_id` = $family_id)");
                        $this->db->limit(1);
			$query=$this->db->get();
			return $query->row_array();
            }
	    
            
            public function getVitalHistory($patient_number)
            {
		
		
                        $this->db->select('*');
			$this->db->order_by("date_created","desc");
			$this->db->from('patient_vitals');
                        $this->db->where("(`patient_number` = '$patient_number')");
			$query=$this->db->get();
			return $query->result_array();
            }
            
            
            public function set_vitals()
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
                            'temperature' => strtolower($this->input->post('temperature')),
                            'blood_pressure' => strtolower($this->input->post('blood_pressure')),
                            'pulse' => strtolower($this->input->post('pulse')),
                            'respiratory_rate' => strtolower($this->input->post('respiratory_rate')),
                            'temperature_unit' => strtolower($this->input->post('temperature_unit')),
                            'blood_pressure_unit' => strtolower($this->input->post('blood_pressure_unit')),
                            'pulse_unit' => strtolower($this->input->post('pulse_unit')),
                            'respiratory_rate_unit' => strtolower($this->input->post('respiratory_rate_unit')),
                            'blood_presure_diastolic' => strtolower($this->input->post('blood_pressure_diastolic')),
                            'date_created' => $todaysDate,
                            'status' => "A"
                            );
                     
                     
		     if($this->input->post('patient_family_id'))
		     {
			$data['patient_family_id'] = $this->input->post('patient_family_id');
		     }
		     
		     if($this->input->post('feotal_heart_rate'))
		     {
			$data['feotal_heart_rate'] = $this->input->post('feotal_heart_rate');
			$data['feotal_heart_rate_unit'] = $this->input->post('feotal_heart_rate_unit');
		     }
		     
		      if($this->input->post('spo'))
		     {
			$data['spo2'] = $this->input->post('spo');
			$data['spo2_unit'] = $this->input->post('spo_unit');
		     }
			 
			 if($this->input->post('bmi'))
		     {
			$data['bmi'] = $this->input->post('bmi');
			$data['bmi_unit'] = $this->input->post('bmi_unit');
		     }
		     
                     return $this->db->insert('patient_vitals', $data);
                
            }
            
            
	   
            
}