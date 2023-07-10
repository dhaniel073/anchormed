<?php
class Param_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
        
        public function getParam($param_id)
            {
                    $query = $this->db->get_where('report_parameters', array('id' => $param_id));
                    return $query->row_array();
            }
	    
	public function getAllParam()
            {
		    $this->db->from("report_parameters");
                    $query = $this->db->get();
                    return $query->result_array();
            }
            
}