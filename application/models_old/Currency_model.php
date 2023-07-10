<?php
class Currency_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getCurrency($currency_code = FALSE)
	    {                
                
		if($currency_code === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("description","asc");
			$this->db->from('currency');
			$where_clause = "(`status` = 'A')";
			$this->db->where($where_clause);
			
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('currency', array('currency_code' => $currency_code));
                return $query->row_array();
	    }
	    
	    public function set_drug_bill_form($staff_no)
	    {
                $date = new DateTime();
                date_timezone_set($date, timezone_open('Africa/Lagos'));
                $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
                    
                    
		$data = array('currency_code'=> $this->input->post('currency_code'),
			      'description' => $this->input->post('description'),
			      'created_by' => $staff_no,
			      'status' => 'A',
                              'date_created' => $todaysDate);
		return $this->db->insert('currency', $data);
	    }
	
	  
	
}