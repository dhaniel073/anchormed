<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller{


    public function index(){

        $data = array("page"=> "index");
        $this->load->view("test", $data);
    }

    public function home(){

        $data = array("page"=> "home");
        $this->load->view("test", $data);
    }

}