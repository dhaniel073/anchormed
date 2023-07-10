<?php
define ('MODULE_NO', 4);
define ('TITLE', 'WorkBench');

class Pages extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('module_map_model');
		$this->load->model('role_model');
	}
	
	
public function test()
{

    error_reporting(E_ALL);
	echo "hello world";

   /* // Load the rest client spark
    $this->load->spark('restclient/2.2.1');

// Load the library
    $this->load->library('rest');

// Set config options (only 'server' is required to work)

    $config = array('server' => 'http://www.smslive247.com/'
        //'api_key'         => 'Setec_Astronomy'
        //'api_name'        => 'X-API-KEY'
        //'http_user'       => 'username',
        //'http_pass'       => 'password',
        //'http_auth'       => 'basic',
        //'ssl_verify_peer' => TRUE,
        //'ssl_cainfo'      => '/certs/cert.pem'
    );

// Run some setup
    $this->rest->initialize($config);

// Pull in an array of tweets
    $response = $this->rest->get("http/index.aspx?cmd=login&owneremail=ekenej@yahoo.com&subacct=mediphix&subacctpwd=mediphixv1");

    print_r($response);*/

    print_r($_POST);
}


	public function index()
	{
	  redirect('/frontdesk');
	  
	    $data['title'] = "Medstation | Home";
	    $data['content-description'] = "Start Page";
	    
	    if($this->session->userdata('logged_in'))
	    {
		//get all user module mappings by role
		$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
		$data['currentmodule']['number'] = MODULE_NO;
		$data['currentmodule']['title'] = TITLE;
		//get the role title
		$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/mainheader', $data);
                $this->load->view('pages/home');
		$this->load->view('templates/footer');
	    }
	    else
	    {
		redirect('/login');
	    }

		 
	}

	
  
}
