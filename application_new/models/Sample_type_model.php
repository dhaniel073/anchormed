<?php
class Sample_type_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
       
	    public function getSampleTypeByName($name)
            {
                $query = $this->db->get_where('sample_type_master', array('name' => $name));
                return $query->row_array();
            }
	    
	    
	    public function getSampleType($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("name","asc");
			$this->db->from('sample_type_master');
                        $this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('sample_type_master', array('sample_type_id' => $id, 'status'=>'A'));
                return $query->row_array();
	    }
	    
	    public function getSampleTypeLike($name)
	    {
		$this->db->select('*');
			$this->db->order_by("name","asc");
			$this->db->from('sample_type_master');
                        $this->db->where("name LIKE '%$name%' and status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
	    }
	  
	    
	    public function removeSampleType($id)
	    {
                $data = array('status'=>'D');
                	
		$this->db->where('sample_type_id', $id);
	        return $this->db->update('sample_type_master', $data);
                               
	    }
	    
	  
	    
	    public function set_SampleType($name, $description, $created_by)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'name' => ucfirst($name),
			    'created_by' => $created_by,
                            'description' => $description,
			    'date_created' => $todaysDate,
			    'status' => 'A'
                    );
		    
		  
                    return $this->db->insert('sample_type_master', $data);
            }
	    
	   
            
}