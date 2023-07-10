<?php
class Surgery_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getSurgery($id)
	    {
		
		        $this->db->select('*');
			$this->db->order_by("date_created","asc");
			$this->db->from('surgery_report');
			$this->db->where("surgery_id = '$id'");
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		
		
		//$query = $this->db->get_where('surgery_report', array('surgery_id' => $id));
          //      return $query->row_array();
	    }
	    
	  
	  public function getDeliveryByType($type)
	  {
		$query = $this->db->get_where('delivery_type', array('type' => $type));
                return $query->row_array();            
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
	  
	  
	  public function getSurgeryByPatientNumber($id)
	    {
			
				$this->db->select('*');
			$this->db->order_by("date_created","desc");
			$this->db->from('surgery_report');
			$this->db->where("patient_number = '$id'");
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
			
			
				//$query = $this->db->get_where('surgery_report', array('patient_number' => $id,'status'=>'A'));
                //return $query->row_array();
	    }
	  
	  public function set_surgery()
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
                            'operation' => strtolower($this->input->post('operation')),
                            'surgeons' => strtolower($this->input->post('surgeons')),
							'anaesthetist' => strtolower($this->input->post('anaesthetist')),
                            'indication' => strtolower($this->input->post('indication')),
                            'findings' => strtolower($this->input->post('findings')),
							'icd10code' => strtolower($this->input->post('icd10code')),
							'Incision' => strtolower($this->input->post('incision')),
							'procedures' => strtolower($this->input->post('procedure')),
							'closure' => strtolower($this->input->post('closure')),
							'drains' => strtolower($this->input->post('drains')),
							'instrument' => strtolower($this->input->post('instruments')),
							'bloodloss' => strtolower($this->input->post('bloodloss')),
							'urine' => strtolower($this->input->post('urine')),
							'created_by' => $this->session->userdata("staff_no"),
                            'date_created' => $todaysDate,
                            'status' => "A"
                            );
                     
							 
					 if($this->input->post('patient_family_id'))
					 {
							$data['patient_family_id'] = $this->input->post('patient_family_id');
					 }
		     
		     
		    
		     
                     return $this->db->insert('surgery_report', $data);
                
            }
	  
	  
	  
}