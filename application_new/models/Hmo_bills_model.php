<?php
class Hmo_bills_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
        
	public function getHmoBillCount($hmo_code)
	{
		 $this->db->select("count(id) as count");
		 $this->db->where("hmo_code = '$hmo_code' AND (status = 'N' or status = 'R')");
		 $this->db->from('hmo_bills');
		 $query=$this->db->get();
		 return $query->row_array();
	}
        
	
	public function getHmoBillByRef($reference_id)
	{
		$query = $this->db->get_where('hmo_bills', array('reference_id' => $reference_id));
                return $query->row_array();
	}
	
      public function getHmoBills($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("date_created","desc");
			$this->db->from('hmo_bills');
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('hmo_bills', array('id' => $id));
                return $query->row_array();
	    }
            
     
     public function getBillsWithActivity($hmo_code)
     {
	$this->db->select('*');
	 $this->db->where("hmo_code = '$hmo_code' AND (status = 'P' or status = 'R')");
	 $this->db->from('hmo_bills');
	 $query=$this->db->get();
        return $query->result_array();
     }
     
     
     public function getHmoBillsUnpostedByHmo($hmo_code)
     {
        
	 $this->db->select('*');
	 $this->db->where("hmo_code = '$hmo_code' AND (status = 'N' or status = 'R')");
	 $this->db->from('hmo_bills');
	 $query=$this->db->get();
        return $query->result_array();
     }
     
       public function setHmoBill($hmo_code, $reference_id, $total_amount, $staff_no)
            {
                    $this->load->helper('url');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
                
                    $data = array(
                            'hmo_code' => $hmo_code,
			    'reference_id' => $reference_id,
			    'total_amount' => $total_amount,
			    'created_by' => $staff_no,
			    'date_created' => $todaysDate,
			    'status' => 'N'
                    );
            
                    return $this->db->insert('hmo_bills', $data);
            }
     
}
    