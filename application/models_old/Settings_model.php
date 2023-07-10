<?php
class Settings_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	    public function getSetting($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("name","asc");
			$this->db->from('sys_settings');
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('sys_settings', array('id' => $id));
                return $query->row_array();
	    }
	    
	    public function getSettingByKey($key)
	    {
		$query = $this->db->get_where('sys_settings', array('key' => $key));
		 return $query->row_array();
	    }
	
	    public function set_Setting($key,$value)
            {
                    $this->load->helper('url');
            
                
                    $data = array(
                            'key' => $key,
			    'created_by' => $this->session->userdata("staff_no"),
			    'value' => $value,
			    'status' => 'A',
			    'date_created' => $this->utilities->getDate()
                     );
            
                    return $this->db->insert('sys_settings', $data);
            }
            
}