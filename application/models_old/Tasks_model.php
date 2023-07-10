<?php
class Tasks_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getTask($task_id = FALSE)
	    {
		if($task_id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("name","asc");
			$this->db->from('in_patient_tasks_master');
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('in_patient_tasks_master', array('task_id' => $task_id));
                return $query->row_array();
	    }
	    
	    public function getInPatientTask($id)
	    {
		
		$query = $this->db->get_where('in_patient_tasks', array('id' => $id));
                return $query->row_array();
	    }
	    
	    
	    
	    public function getScheduledSummary($task_reference)
	    {
	       $select = "count(*) as number_of_tasks, (select count(*) from in_patient_tasks where status = 'D' and task_reference = '$task_reference') ";
	       $select = $select."as number_done ";
	       $this->db->select($select);
	       $query = $this->db->get_where('in_patient_tasks', array('task_reference' => $task_reference));
	       return $query->row_array();
	       
	    }
	    public function getNextDueTaskInSeries($task_reference)
	    {
		$this->db->select('*');
		$this->db->order_by("due_time","asc");
		$this->db->from('in_patient_tasks');
		$this->db->limit(1);
		$this->db->where("status = 'N' AND task_reference='".$task_reference."'");
		$query=$this->db->get();
		return $query->row_array();		
	    }
	    
	    
	    public function get_in_patient_pending_tasks_count($patient_number)
	    {
		
		$this->db->select("task_reference,patient_number,created_by,task_id");
		$this->db->group_by("task_reference, patient_number,created_by,task_id");
		$query = $this->db->get_where('in_patient_tasks', array('patient_number' => $patient_number, 'status' => 'N'));
		return $query->result_array();
	    }
	    
	    public function checkIfNextTaskInSeriesIsDue($task_reference, $current_task_id)
	    {
		$current_time = $this->utilities->getDate();
		
		$this->db->select("task_reference");
		$this->db->where("status = 'N' AND task_reference = '$task_reference' AND due_time <= '$current_time' AND id != $current_task_id" );
		$this->db->limit(1);
		$this->db->order_by("due_time","asc");
		$this->db->from('in_patient_tasks');
		$query=$this->db->get();
		return $query->row_array();	
	    }
	    
	    public function getTaskByReference( $task_reference)
	    {
		$query = $this->db->get_where('in_patient_tasks', array('task_reference' => $task_reference));
		return $query->result_array();
	    }	
	    
	   public function get_in_patient_pending_tasks($patient_number)
	    {
		$query = $this->db->get_where('in_patient_tasks', array('patient_number' => $patient_number, 'status' => 'N'));
		return $query->result_array();
	    }		
		
	    public function getTaskByName($name)
	    {
		$query = $this->db->get_where('in_patient_tasks_master', array('name' => $name));
		 return $query->row_array();
	    }
	
		
	    public function set_Task($name,$description)
	    {
		
		$this->load->helper('url');
		
		 $data = array(
                            'name' => $name,
			    'description' => $description,
			    'created_by' => $this->session->userdata("staff_no"),
			    'status' => 'A',
			    'date_created' => $this->utilities->getDate()
                     );
		 
		  return $this->db->insert('in_patient_tasks_master', $data);
	    }
	    
	   
	    public function create_in_patient_task($patient_number,$due_time,$task_id,$task_specific_instructions, $task_reference)
            {
                    $this->load->helper('url');
            
                
                    $data = array(
                            'patient_number' => $patient_number,
			    'due_time' => $due_time,
			    'task_id' => $task_id,
			    'task_specific_instructions' => $task_specific_instructions,
			    'created_by' => $this->session->userdata("staff_no"),
			    'status' => 'N',
			    'task_reference' => $task_reference,
			    'date_created' => $this->utilities->getDate()
                     );
            
                    return $this->db->insert('in_patient_tasks', $data);
            }
            
}