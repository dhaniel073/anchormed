<?php
class Phenotype_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
       
	    
	    
	    public function getPhenotype($phenotype_id = FALSE)
	    {
		if($phenotype_id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("phenotype_code","asc");
			$this->db->from('phenotype');
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('phenotype', array('phenotype_id' => $phenotype_id));
                return $query->row_array();
	    }
	    
	     public function getPhenotypeByCode($phenotype_code)
		{
		    
		    $query = $this->db->get_where('phenotype', array('phenotype_code' => $phenotype_code));
		    return $query->row_array();
		}
	    
	    
	    public function set_Phenotype()
            {
                    $this->load->helper('url');
            
                
                    $data = array(
                            'phenotype_code' => $this->input->post('phenotype_code'),
			    'status' => 'A'
                    );
            
                    return $this->db->insert('phenotype', $data);
            }
            
}