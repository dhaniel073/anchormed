<?php
class Hmo_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getHmo($hmo_code = FALSE)
	    {
		if($hmo_code === FALSE)
		{
			$this->db->select('*');
			$this->db->order_by("hmo_name","asc");
			$this->db->from('hmo');
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('hmo', array('hmo_code' => $hmo_code, 'status' => 'A'));
                return $query->row_array();
	    }
		
		
		
		
	    /**
	     *
	     *hmo_id`, `hmo_name`, `hmo_address`, `hmo_address_line_2`, `state_code`,
	     *`country_code`, `mobile_number`, `office_number`, `status`, `date_created`, `date_modified`, `hmo_code`
	     */
	    public function quick_set_HMO()
	    {
		 $this->load->helper('url');
		 $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
		    
		    
                    $data = array(
                            'hmo_name' => trim(strtolower($this->input->post('hmo_name'))),			   
			    'date_created' => $todaysDate,
			    'hmo_code' => trim(strtoupper($this->input->post('hmo_code'))),
			    'status' => 'A'
                    );
		    
		    return $this->db->insert('hmo', $data);
            
	    }
	   public function set_Hmo()
            {
                    $this->load->helper('url');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
                
                    $data = array(
                            'hmo_name' => trim(strtolower($this->input->post('hmo_name'))),
			    'hmo_address' => trim(strtolower($this->input->post('hmo_address'))),
			    'hmo_address_line_2' => trim(strtolower($this->input->post('hmo_address_line_2'))),
			    'state_code' => trim(strtoupper($this->input->post('state_code'))),
			    'country_code' => trim(strtoupper($this->input->post('country_code'))),
			    'mobile_number' => $this->input->post('mobile_number'),
			    'office_number' => $this->input->post('office_number'),
			    'date_created' => $todaysDate,
			    'hmo_code' => trim(strtoupper($this->input->post('hmo_code'))),
			    'status' => 'A'
                    );
            
                    return $this->db->insert('hmo', $data);
            }
	    
	     public function set_Hmo_Excel($hmo_name, $hmo_address,$hmo_address_line_2,$state_code,$country_code,$mobile_number,$office_number,$hmo_code)
            {
                    $this->load->helper('url');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
                
                    $data = array(
                            'hmo_name' => trim(strtolower($hmo_name)),
			    'hmo_address' => trim(strtolower($hmo_address)),
			    'hmo_address_line_2' => trim(strtolower($hmo_address_line_2)),
			    'state_code' => trim(strtoupper($state_code)),
			    'country_code' => trim(strtoupper($country_code)),
			    'mobile_number' => trim($mobile_number),
			    'office_number' => trim($office_number),
			    'date_created' => $todaysDate,
			    'hmo_code' => trim(strtoupper($hmo_code)),
			    'status' => 'A'
                    );
            
                    return $this->db->insert('hmo', $data);
            }
}