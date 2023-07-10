<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

define ('MODULE_NO', 0);
define ('TITLE', 'Home');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('passwordhash', array('iteration_count_log2' => 8, 'portable_hashes' => FALSE));
        $this->load->model('ult');
        $this->load->model('staff_master_model');
        $this->load->model('profile_pics_model');
        $this->load->model('module_map_model');
        $this->load->model('role_model');
        $this->load->model('hmo_model');
        $this->load->model('department_model');
        $this->load->model('appointment_model');
        $this->load->model('daily_schedule_model');
        $this->load->model('patient_model');


    }

    private function confirmUrl()
    {
        if ($this->session->userdata('base_url') != base_url()) {
            redirect("/logout");
        }

    }

    public function index()
    {

        if ($this->session->userdata('logged_in')) {
            $this->confirmUrl();


            $currentHome = $this->session->userdata("session_home");

            if(isset($currentHome) && $currentHome != ""){

                redirect($currentHome);

            }else{


                //get all user module mappings by role
                $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

                //get the role title
                $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));


                if ($data['user_role']['role_name'] == "admin") {
                    redirect('/admin');
                }elseif ($data['user_role']['role_name'] == "pharmacist") {
                    redirect('/pharmacy');
                }elseif ($data['user_role']['role_name'] == "laboratory") {
                    redirect('/laboratory');
                }else{

                    redirect('/workbench');

                }


            }
            



        } else {

            redirect('/login');

        }
    }


}