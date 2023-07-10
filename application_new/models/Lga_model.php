<?php
class Lga_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
	
	    public function getLga($lga_id = FALSE)
	    {
		if($lga_id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("lga_name","asc");
			$this->db->from('lga');
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('lga', array('lga_id' => $lga_id));
                return $query->row_array();
	    }
	    
	     public function getLgaByName($lga_name)
		{
		    $query = $this->db->get_where('lga', array('lga_name' => $lga_name));
		    return $query->row_array();
		}
		
		 public function getLgaByState($state_code)
		{
		    $query = $this->db->get_where('lga', array('state_code' => $state_code, 'status' => 'A'));
		    return $query->result_array();
		}
	    
	    
	    public function set_lga()
            {
                    $this->load->helper('url');
            
                
                    $data = array(
                            'lga_name' => strtolower($this->input->post('lga_name')),
			    'state_code' => $this->input->post('state_code'),
			    'country_code' => $this->input->post('country_code'),
			    'status' => 'A'
                    );
            
                    return $this->db->insert('lga', $data);
            }
	    
	    public function set_lga_excel($lganame, $state_code, $country_code)
            {
                    $this->load->helper('url');
            
                
                    $data = array(
                            'lga_name' => strtolower($lganame),
			    'state_code' => $state_code,
			    'country_code' => $country_code,
			    'status' => 'A'
                    );
            
                    return $this->db->insert('lga', $data);
            }
            
}