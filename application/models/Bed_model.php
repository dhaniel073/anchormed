<?php
class Bed_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
       
	    public function getBedByWard($ward)
            {
                $query = $this->db->get_where('bed_master', array('ward_id' => $ward,  'status'=>'A'));
                return $query->result_array();
            }
	    
	    public function getAvailableBedsInWard($ward_id)
	    {
		
		$beds = $this->getBedByWard($ward_id);
		
		$result = null;
		$counter = 0;
		
		
		foreach($beds as $bed)
		{
			$query = $this->db->get_where('patient_admissions', array('bed_id' => $bed['bed_id'], 'status' => 'A'));
			$isFound = $query->row_array();
			
			if($isFound)
			{
				continue;			
			}
			
			$result[$counter] = $bed;			
			$counter++;
		}
		return $result;
	    }
	    
	  
	    
	    public function remove_bed($bed_id)
	    {
		$this->db->where('bed_id', $bed_id);
		return $this->db->delete('bed_master'); 
	    }
	  
	  
	    
	    public function set_Bed($ward_id, $bed_name)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'ward_id' => $ward_id,
			    'bed_name' => $bed_name,
			    'date_created' => $todaysDate,
			    'status' => 'A'
                    );
		    
		  
                    return $this->db->insert('bed_master', $data);
            }
	    
	   
            
}