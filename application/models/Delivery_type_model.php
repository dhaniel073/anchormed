<?php
class Delivery_type_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getDeliveryType($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("type","asc");
			$this->db->from('delivery_type');
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('delivery_type', array('id' => $id));
                return $query->row_array();
	    }
	    
	  
	  public function getDeliveryByType($type)
	  {
		$query = $this->db->get_where('delivery_type', array('type' => $type));
                return $query->row_array();            
	  }
	  
	  public function getDeliveryByPatientNumber($id)
	    {
			
				$this->db->select('*');
			$this->db->order_by("date_created","desc");
			$this->db->from('post_delivery');
			$this->db->where("patient_number = '$id'");
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
			
			
				//$query = $this->db->get_where('post_delivery', array('patient_number' => $id,'status'=>'A'));
                //return $query->row_array();
	    }
		
		
		public function getDeliveryReportById($id)
	    {
			
				$this->db->select('*');
			$this->db->order_by("date_created","desc");
			$this->db->from('post_delivery');
			$this->db->where("delivery_id = '$id'");
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
			
			
				//$query = $this->db->get_where('post_delivery', array('delivery_id' => $id,'status'=>'A'));
                //return $query->row_array();
	    }
	  
	   public function set_delivery_type($type, $description)
            {                  
            
                
                    $data = array(
                            'type' => $type,
			    'description' => $description,
			    'date_created' => $this->utilities->getDate(),
				'status' => 'A'
                    );
            
                    return $this->db->insert('delivery_type', $data);
            }
	  
	  
	  public function set_delivery()
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
                            'dob' => $this->input->post('deliverydate'),
                            'duration_preg' => strtolower($this->input->post('preg_duration')),
							'num_of_baby' => strtolower($this->input->post('num_of_baby')),
                            'sex_baby' => $this->input->post('sex_baby'),
                            'weight' => $this->input->post('wieght'),
							'delivery_type' => $this->input->post('delivery_type'),
							'baby_a_d' => $this->input->post('baby_sb_ndd'),
							'time_of_delivery' => $this->input->post('time_of_delivery'),
							
							'first_skin_color' => $this->input->post('first_skin_color'),
							'first_muslce_tone' => $this->input->post('first_muslce_tone'),
							'first_resp_effort' => $this->input->post('first_resp_effort'),
							'first_heart_rate' => $this->input->post('first_heart_rate'),
							'first_resp_to_stimulis' => $this->input->post('first_resp_to_stimulis'),
							'first_apga_total' => $this->input->post('first_apga_total'),
							
							'fifth_skin_color' => $this->input->post('fifth_skin_color'),
							'fifth_muslce_tone' => $this->input->post('fifth_muslce_tone'),
							'fifth_resp_effort' => $this->input->post('fifth_resp_effort'),
							'fifth_heart_rate' => $this->input->post('fifth_heart_rate'),
							'fifth_resp_to_stimulis' => $this->input->post('fifth_resp_to_stimulis'),
							'fifth_apga_total' => $this->input->post('fifth_apga_total'),
							
							'parity' => $this->input->post('parity'),
							'abnormality' => $this->input->post('abnormality'),
							'state_of_perineum' => $this->input->post('state_of_perineum'),
							'length' => $this->input->post('length'),
							'head_circumference' => $this->input->post('head_circumference'),
							'estimated_blood_loss' => $this->input->post('estimated_blood_loss'),
							'presentation' => $this->input->post('presentation'),
							'delivered_by' => $this->input->post('delivered_by'),
							'other_findings' => $this->input->post('other_findings'),



                            'date_created' => $todaysDate,
                            'status' => "A"
                            );
                     
							 
					 if($this->input->post('patient_family_id'))
					 {
							$data['patient_family_id'] = $this->input->post('patient_family_id');
					 }
		     
		     
		    
		     
                     return $this->db->insert('post_delivery', $data);
                
            }
	  
	  
	  
}