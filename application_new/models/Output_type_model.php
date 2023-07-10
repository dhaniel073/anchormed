<?php
class Output_type_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getOutput($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("type","asc");
			$this->db->from('output_type');
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('output_type', array('id' => $id));
                return $query->row_array();
	    }
	    
	  
	  public function getOutputByType($type)
	  {
		$query = $this->db->get_where('output_type', array('type' => $type));
                return $query->row_array();            
	  }
	  
	  
	  public function getOutputByPatientNumber($id)
	    {
			
				$this->db->select('*');
			$this->db->order_by("date_created","desc");
			$this->db->from('inpatient_output');
			$this->db->where("patient_number = '$id'");
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
			
			
				//$query = $this->db->get_where('inpatient_output', array('patient_number' => $id,'status'=>'A'));
                //return $query->row_array();
	    }
	  
	  
	   public function set_output_type($type, $description)
            {                  
            
                
                    $data = array(
                            'type' => $type,
			    'description' => $description,
			    'date_created' => $this->utilities->getDate(),
				'status' => 'A'
                    );
            
                    return $this->db->insert('output_type', $data);
            }
	  
	  
	  public function set_record_intake()
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
                            'output_amount' => strtolower($this->input->post('output_amount')),
                            'output_type' => strtolower($this->input->post('output_type')),
                            'output_time' => strtolower($this->input->post('output_time')),
                            'output_date' => strtolower($this->input->post('outputdate')),
                            'date_created' => $todaysDate,
                            'status' => "A"
                            );
                     
							 
					 if($this->input->post('patient_family_id'))
					 {
							$data['patient_family_id'] = $this->input->post('patient_family_id');
					 }
		     
		     
		    
		     
                     return $this->db->insert('inpatient_output', $data);
                
            }
	  
	  
}