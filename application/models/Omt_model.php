<?php
class Omt_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
       
	    
	    
	    public function getOmt($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("date_created","desc");
			$this->db->from('omt');
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('omt', array('id' => $id));
                return $query->row_array();
	    }
	    public function getPatientLastOmt($actionType, $history_id)
	    {
		$this->db->order_by("date_created","desc");
		$this->db->limit(1);
		$query = $this->db->get_where('orders', array('action_type' => $actionType,'patient_history_id' => $history_id, 'status' => 'N'));
		return $query->row_array();
	    }
	    public function get_Omt_by_dept($dept)
	    {
		$this->load->helper('url');
		$this->db->order_by("date_created","desc");
		$query = $this->db->get_where('orders', array('action_type' => $dept, 'status' => 'N'));
		return $query->result_array();
	    }
	    
	    public function getOmtCountByDept($dept)
	    {
		$this->load->helper('url');
		$this->db->select('count(id) as total',FALSE);
		$query = $this->db->get_where('orders', array('action_type' => $dept, 'status' => 'N'));
		return $query->row_array();
	    }
	    

	    public function set_Omt($staff_no, $action_type, $patient_history_id, $action)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'patient_history_id' => $patient_history_id,
			    'action_type' =>$action_type,
			    'created_by' => $staff_no,
			    'date_created' => $todaysDate,
			    'notes'=>$action,
			    'status' => 'N'
                    );
            
                    return $this->db->insert('omt', $data);
            }
			
			
		public function set_Omt_referal($staff_no, $action_type, $patient_history_id, $action, $consulattionid)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'patient_history_id' => $patient_history_id,
			    'action_type' =>$action_type,
			    'created_by' => $staff_no,
			    'date_created' => $todaysDate,
			    'notes'=>$action,
			    'status' => 'N',
				'consultation_id' => $consulattionid
                    );
            
                    return $this->db->insert('omt', $data);
            }
	    
	   
            
}