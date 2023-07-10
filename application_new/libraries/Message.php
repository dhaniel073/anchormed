<?php

class Message {


    /**
     * Message constructor.
     */
    public function __construct()
    {
        $CI =& get_instance();

        $CI->load->library('session');
        $CI->load->model('staff_model');
        $CI->load->model('message_model');
        $CI->load->model('sub_module_map_model');
        $CI->load->database();
    }

    function sendChangeAlert($module, $title, $message, $from)
    {
        $CI =& get_instance();
        
        
        $usergroups = $CI->sub_module_map_model->getUserGroupsWithModuleAccess($module);
			
			$groups = array();
			
			$counter = 0;
			foreach($usergroups as $group)
			{
				$groups[$counter] = $group['user_group_id'];
				$counter++;
			}
			
			$staffToRecieveUpdates = $CI->staff_model->getStaffByUserGroup($groups);
			
			
			
			foreach($staffToRecieveUpdates as $to)
			{
				
				$CI->message_model->set_Message($message, $title, $to['staff_no'], $from, NULL);
			}
    }
    
    function send($title, $message, $to, $from , $ref)
    {
        $CI =& get_instance();
        return $CI->message_model->set_Message($message, $title, $to, $from, $ref);
    }
}


?>