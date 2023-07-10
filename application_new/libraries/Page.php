<?php


class Page {

        
        private $redirectPage = "/home";
        
        function Pageh()
	{
            $CI =& get_instance();                
            $CI->load->library('session');
	}
       
        public function loadPage($pages, $data, $useStandardHeaders)
        {
            $CI =& get_instance();
            
	    if($useStandardHeaders)
	    {
		 $CI->load->view('templates/header', $data);
		 $CI->load->view('templates/mainheader', $data);		 
	    }
	    foreach($pages as $page)
	    {
		$CI->load->view($page, $data);		
	    }
	    
	    $CI->load->view('templates/footer');
        }
        
      
}

?>