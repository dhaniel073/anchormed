<?php
class Laboratory_price_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
            
	    public function getLabTestPrice($lab_price_id = FALSE)
                {                
                    
                    if($lab_price_id === FALSE)
                    {
                            $this->db->select('*');
                            $this->db->from('lab_pricie_master');
                            $where_clause = "(`status` = 'A')";
                            $this->db->where($where_clause);
                            
                            $query=$this->db->get();
                            return $query->result_array();
                    }
                    
                    $query = $this->db->get_where('lab_pricie_master', array('lab_price_id' => $lab_price_id));
                    return $query->row_array();
                }
		
	
	public function getPriceOfLabTest($lab_id)
	{
		 $query = $this->db->get_where('lab_pricie_master', array('lab_id' => $lab_id));
                 return $query->row_array();
	}
	    public function setLabTestPrice($lab_id, $lab_price,$currency_code,$created_by)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'lab_id' => $lab_id,
			    'lab_price' => $lab_price,
			    'currency_code' => $currency_code,
                            'date_created' => $todaysDate,
                            'created_by' => $created_by,
			    'status' => 'A'
                    );
		    
		  
                    return $this->db->insert('lab_pricie_master', $data);
            }
	    
	   
            
}