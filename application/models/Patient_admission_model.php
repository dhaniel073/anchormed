<?php
class Patient_admission_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
       
	    public function getPatientByWard($ward)
            {
				$this->db->order_by("date_admitted","desc");
                $query = $this->db->get_where('patient_admissions', array('ward_id' => $ward, 'status' => 'A'));
                return $query->result_array();
            }
	    
	    public function getAllAdmittedPatients(){
		$this->db->order_by("date_admitted","desc");
		$query = $this->db->get_where('patient_admissions', array('status' => 'A'));
		return $query->result_array();
	    }
	    
	    
	    public function getInPatients()
	    {
		$this->db->order_by("date_admitted","desc");	
		$query = $this->db->get_where('InPatients', array('status' => 'A'));
		return $query->result_array();
	    }
		
		public function getInPatientsAll()
	    {
		$this->db->order_by("date_admitted","desc");	
		$query = $this->db->get('InPatients');
		return $query->result_array();
	    }
	    
	    
	    public function getInPatientsLike($name)
	    {
		$query = $this->db->get_where('InPatients', array('patient_number' => $name, 'status' => 'A'));
			$result_array = $query->result_array();
			if($result_array && sizeof($result_array) >  0)
			{
				return $result_array;
			}
			else
			
			{
				
				$test = preg_split('[ ]',$name);
				
				$where_clause = "(";
				
				if(sizeof($test) > 1)
				{
					$i = 0;
					
					foreach($test as $t)
					{
						if($i > 0)
						{
							$where_clause = $where_clause." OR  ";
						}
						$where_clause = $where_clause."`first_name` LIKE '%$t%' OR  `last_name` LIKE '%$t%' OR `middle_name` LIKE '%$t%' OR `patient_number` LIKE '%$t%' " ;
						
						$i++;
					}
					
					$where_clause = $where_clause.")";
					
					
				}
				else $where_clause = "(`first_name` LIKE '%$name%' OR  `last_name` LIKE '%$name%' OR `middle_name` LIKE '%$name%' OR `patient_number` LIKE '%$name%')";
				
				
				$where_clause = "status = 'A' AND ".$where_clause;
				
				$this->db->select('*');
				$this->db->order_by("last_name","asc");
				$this->db->from('InPatients');
				$this->db->where($where_clause);
	
			    
				$query=$this->db->get();
				return $query->result_array();
			}
		
	    }
	
	public function getAdmittedPatientCount()
	{
		$this->db->select("count(*) as total");
		$query = $this->db->get_where('patient_admissions', array('status' => 'A'));
		return $query->row_array();
	}
	    
	    public function getPatientAdmission($patient_number)
	    {
		$query = $this->db->get_where('patient_admissions', array('patient_number' => $patient_number, 'status' => 'A'));
		return $query->row_array();
	    }
	  
	    
	  
	  
	  
	    
	    public function set_AdmittedPatient($ward_id, $bed_id, $doctors_code, $patient_number)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'ward_id' => $ward_id,
			    'bed_id' => $bed_id,
			    'doctor_code' => $doctors_code,
			     'patient_number' => $patient_number,
			     'date_admitted' => $todaysDate,
			    'status' => 'A'
                    );
		    
		  
                    return $this->db->insert('patient_admissions', $data);
            }
	    
	   
            
}