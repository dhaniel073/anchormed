<?php
class Unit_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getUnit($unit_id = FALSE)
	    {
		if($unit_id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("unit_name","asc");
			$this->db->from('unit_of_measure');
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('unit_of_measure', array('id' => $unit_id));
                return $query->row_array();
	    }
	    
	  
	  public function getUnitByName($name)
	  {
		$query = $this->db->get_where('unit_of_measure', array('unit_name' => $name));
                return $query->row_array();            
	  }
	  
	 public function getUnitBySymbol($symbol)
	  {
		$query = $this->db->get_where('unit_of_measure', array('symbol' => $symbol));
                return $query->row_array();            
	  }
	  
	  
	  
	   public function set_unit($unit_name, $symbol, $staff_no)
            {                  
            
                
                    $data = array(
                            'unit_name' => $unit_name,
			    'symbol' => $symbol,
			    'created_by' => $staff_no,
			    'date_created' => $this->utilities->getDate(),
			    'status' => 'A'
                    );
            
                    return $this->db->insert('unit_of_measure', $data);
            }
	  
	  
	  
}