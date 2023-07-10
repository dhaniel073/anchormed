<?php

class Utilities
{


    private $redirectPage = "/home";

    private $medstation;

    function __construct() {

        $this->medstation =& get_instance();

        $this->medstation->load->library('session');
        $this->medstation->load->library('email');
        $this->medstation->load->model('sub_module_map_model');
        $this->medstation->load->database();
    }

    public function setNotice($notice)
    {
        $array = array('notice' => $notice);
        $this->medstation->session->set_userdata($array);

    }


    public function loadUserLang()
    {
        $language = "english";
        $this->medstation->lang->load("error", $language);
        $this->medstation->lang->load("notice", $language);
    }

    public function getDate()
    {
        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');

        return $todaysDate;
    }

    public function setSessionHome($sessionHome){


        $array = array('session_home' => $sessionHome);
        $this->medstation->session->set_userdata($array);

        return true;
    }

    
    public function userHasAccess($accessLevel)
    {


        $moduleAccess = $this->medstation->sub_module_map_model->getSubAccess($this->medstation->session->userdata('group'), $accessLevel);

        if (!isset($moduleAccess['access'])) {

            return false;
        }
        if (!isset($moduleAccess) || $moduleAccess['access'] != "W") {
            return false;
        } else {
            return true;
        }


    }


    public function sendHtmlEmail($template, $parameters, $to, $subject){

        //load template

        $this->medstation->load->helper('file');


        $emailBody = read_file("./assets/email/$template.php");

        //replace all the keys
        foreach ($parameters as $key => $value){

            $emailBody = str_replace("{".$key."}", $value, $emailBody);
        }


        $from_email = "no-reply@anchormedhospital.com";

        $this->medstation->email->from($from_email, 'Mediphix');
        $this->medstation->email->to($to);
        $this->medstation->email->subject($subject);
        $this->medstation->email->message($emailBody);

        //Send mail
        if($this->medstation->email->send())
            return true;
        else
            log_message("error", "could not send email to $to");

        return false;

    }

    public function aunthenticateAccess($accessLevel, $fallbackpage = FALSE)
    {
        if ($fallbackpage === FALSE) {
            $fallbackpage = "/home";
        } else {
            $this->redirectPage = "/" . $fallbackpage;
        }

        //first check login status

        $this->loginCheck();

        //then check module access

        $this->moduleAccessCheck($accessLevel);

        return true;
    }

    public function loginCheck()
    {

        if (!$this->medstation->session->userdata('logged_in')) {
            redirect("/login");
        } else {
            $this->confirmUrl();
        }

        return true;
    }

    public function redirectWithNotice($fallbackpage, $notice)
    {

        if ($fallbackpage) {
            $this->redirectPage = $fallbackpage;
        }

        $this->setNotice($notice);
        redirect($this->redirectPage);
    }




    public function generateRandomVerificationCode(){
            $alphabet = '1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 4; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string

    }

    public function moduleAccessCheck($accessLevel)
    {

        $moduleAccess = $this->medstation->sub_module_map_model->getSubAccess($this->medstation->session->userdata('group'), $accessLevel);

        if (!isset($moduleAccess) || $moduleAccess['access'] != "W") {
            $this->redirectWithNotice($this->redirectPage, ACCESS_ERROR);
        }
    }

    private function confirmUrl()
    {

        if ($this->medstation->session->userdata('base_url') != base_url()) {
            redirect("/logout");
        }

    }

}

?>