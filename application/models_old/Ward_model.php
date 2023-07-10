<?php
class Ward_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
       
	    public function getWardByName($name)
            {
                $query = $this->db->get_where('ward_master', array('ward_name' => $name,  'status'=>'A' ));
                return $query->row_array();
            }
	    
	    
	    public function getWard($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("ward_name","asc");
			$this->db->from('ward_master');
                        $this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('ward_master', array('ward_id' => $id, 'status'=>'A'));
                return $query->row_array();
	    }
	    
	  
	    
	    public function removeWard($id)
	    {
                $data = array('status'=>'D');
                	
		$this->db->where('ward_id', $id);
	        return $this->db->update('ward_master', $data);
                               
	    }
	    
	  
	    
	    public function set_Ward()
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'ward_name' => ucfirst($this->input->post('ward_name')),
			    'ward_bed_limit' => ucfirst($this->input->post('ward_bed_limit')),
			    'date_created' => $todaysDate,
			    'status' => 'A'
                    );
		    
		  
                    return $this->db->insert('ward_master', $data);
            }
	    
	   
            
}