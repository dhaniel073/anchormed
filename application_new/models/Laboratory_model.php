<?php
class Laboratory_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
            
             public function getLab($lab_id = FALSE)
                {                
                    
                    if($lab_id === FALSE)
                    {
                            $this->db->select('*');
                            $this->db->order_by("name","asc");
                            $this->db->from('lab_master');
                            $where_clause = "(`status` = 'A')";
                            $this->db->where($where_clause);                            
                            $query=$this->db->get();
                            return $query->result_array();
                    }
                    
                    $query = $this->db->get_where('lab_master', array('lab_id' => $lab_id));
                    return $query->row_array();
                }
	   
           public function getLabLikeName($name)
            {
                 $this->db->select('*');
                 $this->db->order_by("name","asc");
                 $this->db->from('lab_master');
                 $where_clause = "(`name` LIKE '%$name%' AND `status` = 'A')";
                 $this->db->where($where_clause);                
                $query=$this->db->get();
                return $query->result_array();
            }
	  
            public function getLabByName($name)
            {
                 $query = $this->db->get_where('lab_master', array('name' => $name));
                return $query->row_array();
            }
	    
	    public function setLabTest($test_name, $description, $created_by, $required_sample_type)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'name' => $test_name,
			    'description' => $description,
			    'date_created' => $todaysDate,
                            'created_by' => $created_by,
			    'required_sample_type' => $required_sample_type,
			    'status' => 'A'
                    );
		    
		  
                    return $this->db->insert('lab_master', $data);
            }
	    
	   
            
}