<?php
class Sample extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
	}

	public function index()
	{
	    
	    $newdata = array(
                   'username'  => 'johndoe',
                   'email'     => 'johndoe@some-site.com',
                   'logged_in' => FALSE
               );

	$this->session->set_userdata($newdata);

	    
	    if($this->session->userdata('logged_in'))
	    {
		$this->load->view('templates/header');
                $this->load->view('pages/home');
		$this->load->view('templates/footer');
	    }
	    else
	    {
		redirect('/login');
	    }

		 
	}

	
  
}