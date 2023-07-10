<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

define ('MODULE_NO', 7);
define ('TITLE', 'Staff Management');
define ('SUB_MODULE_NO', 4);
define ('CREATE_STAFF', 4);
define ('VIEW_STAFF_DATA', 17);
define ('EDIT_USER_PERMISSIONS', 5);
define ('DEFINE_BILLABLE_ITEM', 19);
define ('UPDATE_ROLE', 29);
define ('UPDATE_DEPARTMENT', 30);
define ('CHANGE_USER_GROUP', 32);
define ('PERMISSION_ERROR', 'You do not have enough Permission to Perform Function, contact admin');

class Staff extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('passwordhash', array('iteration_count_log2' => 8, 'portable_hashes' => FALSE));
        $this->load->model('ult');
        $this->load->model('staff_master_model');
        $this->load->model('staff_model');
        $this->load->model('state_model');
        $this->load->model('profile_pics_model');
        $this->load->model('module_map_model');
        $this->load->model('role_model');
        $this->load->model('hmo_model');
        $this->load->model('department_model');
        $this->load->model('appointment_model');
        $this->load->model('religion_model');
        $this->load->model('country_model');
        $this->load->model('daily_schedule_model');
        $this->load->model('patient_model');
        $this->load->model('sub_module_map_model');
        $this->load->model('user_groups_model');
        $this->load->model('general_update_model');
        $this->load->model('marital_model');


    }

    private function confirmUrl()
    {
        if ($this->session->userdata('base_url') != base_url()) {
            redirect("/logout");
        }

    }

    public function getDepartmentDoctorsJson()
    {
        if ($this->input->post('dept_id')) {
            $doctors = $this->staff_model->getStaffByDeptId($this->input->post('dept_id'));
            echo json_encode($doctors);
        } else {
            echo json_encode(null);
        }
    }


    public function updatePersonalData()
    {

        if($this->session->userdata('logged_in'))
        {
            $this->confirmUrl();


            $data["first_name"] = $this->input->post("first_name");

            if( $this->input->post("first_name") )
            {
                $data["first_name"] = $this->input->post("first_name");
            }

            if( $this->input->post("dob") )
            {
                $splitdob = preg_split('[-]',$this->input->post("dob"));

                $data['dob'] =  $splitdob[2]."-".$splitdob[0]."-".$splitdob[1] ;
            }

            if( $this->input->post("last_name") )
            {
                $data["last_name"] = $this->input->post("last_name");
            }

            if( $this->input->post("middle_name") )
            {
                $data["middle_name"] = $this->input->post("middle_name");
            }

            if( $this->input->post("marital_status") )
            {
                $data["marital_status"] = $this->input->post("marital_status");
            }

            if( $this->input->post("mobile_number") )
            {
                $data["mobile_number"] = $this->input->post("mobile_number");
            }
            if( $this->input->post("cell_number") )
            {
                $data["cell_number"] = $this->input->post("cell_number");
            }
            if( $this->input->post("alt_email") )
            {
                $data["alt_email"] = $this->input->post("alt_email");
            }



            $table_name = "staff_master";
            $id = "staff_no";
            $id_value = $this->input->post("staff_no");


            $this->general_update_model->update($table_name,$id,$id_value, $data);

            $array = array('notice' =>"Data Successfully Updated");
            $this->session->set_userdata($array);

            redirect('/staff/number/'.$this->input->post("staff_no"));
        }
        else
        {
            redirect('/login');
        }

    }


    public function updateAddressData()
    {
        if($this->session->userdata('logged_in'))
        {
            $this->confirmUrl();



            if( $this->input->post("address_line_1") )
            {
                $data["address_line_1"] = $this->input->post("address_line_1");
            }


            if( $this->input->post("address_line_2") )
            {
                $data["address_line_2"] = $this->input->post("address_line_2");
            }

            if( $this->input->post("address_state_code") )
            {
                $data["address_state_code"] = $this->input->post("address_state_code");
            }
            if( $this->input->post("address_country_code") )
            {
                $data["address_country_code"] = $this->input->post("address_country_code");
            }





            $table_name = "staff_master";
            $id = "staff_no";
            $id_value = $this->input->post("staff_no");
            $this->general_update_model->update($table_name,$id,$id_value, $data);

            $array = array('notice' =>"Data Successfully Updated");
            $this->session->set_userdata($array);


            redirect('/staff/number/'.$this->input->post("staff_no"));


        }
        else
        {
            redirect('/login');
        }

    }


    private function moduleAccessCheckOverload($accessLevel)
    {

        $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), $accessLevel);

        if($moduleAccess){

            if($moduleAccess['access'] != "W"){

                return false;
            }

        }else{

            return false;
        }

        /*if (!isset($moduleAccess) || $moduleAccess['access'] != "W") {
            return false;
        }*/

        return true;
    }


    private function moduleAccessCheck($accessLevel)
    {
        $this->confirmUrl();
        $moduleAccess = $this->sub_module_map_model->getSubAccess($this->session->userdata('group'), $accessLevel);

        if (!isset($moduleAccess) || $moduleAccess['access'] != "W") {
            $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
            $this->session->set_userdata($array);
            redirect('/home');
        }
    }


    private function SpecialUserCheck()
    {
        if ($this->session->userdata('staff_no') != '2005/10/01') {
            $array = array('notice' => "Super User Required to Perform Function");
            $this->session->set_userdata($array);
            redirect('/home');
        }
    }

    public function search()
    {


        if ($this->session->userdata('logged_in')) {

            $this->moduleAccessCheck(VIEW_STAFF_DATA);


            if (isset($_POST['name'])) {
                $data['staffs'] = $this->staff_model->getStaffLikeName($_POST['name']);
            } else {
                $data['staffs'] = $this->staff_model->getStaff();
            }


            //get all user module mappings by role
            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
            $data['departments'] = $this->department_model->getDepartments();

            $data['roles'] = $this->role_model->getroles();
            $data['title'] = "Medstation | Staff Search";
            $data['search_url'] = "index.php/staff/search";

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;
            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));

            $this->load->view('templates/header', $data);
            $this->load->view('templates/mainheader', $data);
            $this->load->view('admin/staff/search', $data);
            $this->load->view('templates/footer');

        } else {
            redirect('/login');
        }

    }

    public function uploadStaffPic()
    {
        $this->session->unset_userdata('alert');


        if ($this->session->userdata('logged_in')) {
            if (!$this->input->post("staff_no")) {
                redirect('/home');
            }

            //picture should be updateable by all staff

          /*  $this->moduleAccessCheck(CREATE_STAFF);
            if ($this->input->post('staff_no') != $this->session->userdata('staff_no')) {
                $this->SpecialUserCheck();
            }*/


            $config['upload_path'] = 'assets/img/profiles/';
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = '2000';

            /**
             * $config['max_width']  = '400';
             * $config['max_height']  = '400';
             **/


            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $array = array('notice' => $this->upload->display_errors());
                $this->session->set_userdata($array);

                redirect('/staff/number/' . $this->input->post("staff_no"));
            } else {
                $pic = $this->upload->data();
                $new_name = $this->input->post('staff_no') . $pic['file_ext'];

                //rename the image

                rename("assets/img/profiles/" . $pic['orig_name'], "assets/img/profiles/" . $new_name);


                //create a thumbnail image

                $config['image_library'] = 'gd2';
                $config['source_image'] = "assets/img/profiles/" . $new_name;
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = FALSE;

                $config['width'] = 200;
                $config['height'] = 200;

                $this->load->library('image_lib', $config);

                $this->image_lib->resize();

                $data['picture'] = $this->input->post('staff_no') . "_thumb" . $pic['file_ext'];

                $table_name = "profile_pics";
                $id = "staff_no";
                $id_value = $this->input->post("staff_no");
                $this->general_update_model->update($table_name, $id, $id_value, $data);


                $array = array('notice' => "picture uploaded sucessfully");
                $this->session->set_userdata($array);

                redirect('/staff/number/' . $this->input->post("staff_no"));

            }
        } else {
            redirect('/login');
        }

    }

    public function number($staff_no)
    {
        if ($this->session->userdata('logged_in')) {
            // $this->moduleAccessCheck(VIEW_STAFF_DATA);

            if ($staff_no != $this->session->userdata('staff_no')) {
                $this->SpecialUserCheck();
            }

            if (!isset($staff_no) || $staff_no == "") {
                $array = array('notice' => "Staff Does not Exist");
                $this->session->set_userdata($array);
                redirect('/home');
            }

            $data['staff'] = $this->staff_model->getStaff($staff_no);

            if (empty($data['staff'])) {

                $array = array('notice' => "Staff Does not Exist");
                $this->session->set_userdata($array);
                redirect('/home');
            }

            if ($this->session->userdata('shift_id')) {
                $userdata['staff'] = $data['staff'];
                $this->session->set_userdata($userdata);
                redirect('/dailyroaster/addShiftMember');
            }


            $data['title'] = "Medstation | Staff info";

            $data['can_update_group'] = $this->moduleAccessCheckOverload(CHANGE_USER_GROUP);
            $data['can_update_department'] = $this->moduleAccessCheckOverload(UPDATE_DEPARTMENT);
            $data['can_update_role'] = $this->moduleAccessCheckOverload(UPDATE_ROLE);
            $data['can_delete_user'] = $this->moduleAccessCheckOverload(DELETE_USER);
            $data['can_reset_password'] = $this->moduleAccessCheckOverload(RESET_PASSWORD);

            //get all user module mappings by role
            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
            $data['address_country_code'] = $this->country_model->getCountries($data['staff']['address_country_code']);
            $data['address_state_code'] = $this->state_model->getState($data['staff']['address_state_code']);

            $data['department'] = $this->department_model->getDepartments($data['staff']['dept_id']);
            $data['role'] = $this->role_model->getrole($data['staff']['role_id']);
            $data['roles'] = $this->role_model->getrole();
            $data['groups'] = $this->user_groups_model->getUserGroups();
            $data['departments'] = $this->department_model->getDepartments();
            $data['group'] = $this->user_groups_model->getUserGroups($data['staff']['group_id']);
            $data['address_states'] = $this->state_model->getStateByCountry($data['staff']['address_country_code']);
            $data['countries'] = $this->country_model->getCountries();
            $data['pic'] = $this->profile_pics_model->getuserpic($staff_no);

            $date = new DateTime($data['staff']['dob']);
            $dateToday = new DateTime();
            date_timezone_set($date, timezone_open('Africa/Lagos'));

            $splitdob = preg_split('[-]', $data['staff']['dob']);

            $data['dob'] = $splitdob[1] . "-" . $splitdob[2] . "-" . $splitdob[0];

            $diff = strtotime(date_format($dateToday, 'Y-m-d')) - strtotime(date_format($date, 'Y-m-d'));

            $data['age'] = floor($diff / (365 * 60 * 60 * 24));

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;
            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
            $data['acct'] = $this->ult->userState($staff_no);


            $this->load->view('templates/header', $data);
            $this->load->view('templates/mainheader', $data);
            $this->load->view('admin/staff/view', $data);
            $this->load->view('templates/footer');


        } else {

            redirect('/login');
        }
    }


    public function addGroup()
    {
        if ($this->session->userdata('logged_in')) {

            $this->moduleAccessCheck(CREATE_STAFF);
            $this->SpecialUserCheck();


            if (isset($_POST['name'])) {


                $groupdata = $this->user_groups_model->getUserGroupByName(trim(strtolower($_POST['name'])));

                if (sizeof($groupdata) > 0) {
                    $array = array('notice' => "User Group not created  , user group : " . $_POST['name'] . "already exists");
                    $this->session->set_userdata($array);
                    redirect('/admin');
                } else {
                    $this->user_groups_model->set_usergroup(trim(strtolower($_POST['name'])));
                    $array = array('notice' => "User Group Created");
                    $this->session->set_userdata($array);
                    redirect('/admin');
                }
            } else {
                redirect('/admin');
            }


        } else {
            redirect('/login');
        }
    }

    public function savePermission()
    {
        if ($this->session->userdata('logged_in')) {

            $this->moduleAccessCheck(CREATE_STAFF);
            $this->SpecialUserCheck();


            if (!isset($_POST['module_id']) || !isset($_POST['sub_module_id']) || !isset($_POST['permission']) || !isset($_POST['user_group_id'])) {
                $array = array('notice' => "Contact Administrator, You Do not have enough permision to perform action");
                $this->session->set_userdata($array);
                redirect('/admin');
            }


            $this->sub_module_map_model->clear_permissions($_POST['user_group_id']);


            //set_permission($user_group_id,$module_id,$sub_module_id,$access)
            $sub_modules = $_POST['sub_module_id'];
            $permission = $_POST['permission'];
            $module = $_POST['module_id'];

            $i = 0;
            foreach ($sub_modules as $sub_module) {


                $this->sub_module_map_model->set_permission($_POST['user_group_id'], $module[$i], $sub_module, $permission[$i]);

                $i++;
            }


            $array = array('notice' => "Permission Mapping saved");
            $this->session->set_userdata($array);
            redirect('/admin');
        } else {

            redirect('/login');

        }
    }

    public function editGroupPermissions()
    {


        if ($this->session->userdata('logged_in')) {


            $this->moduleAccessCheck(CREATE_STAFF);
            $this->SpecialUserCheck();


            if (!isset($_POST['user_group_id'])) {
                redirect('/admin');
            }

            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

            $data['permissions'] = $this->sub_module_map_model->getGroupAccess($_POST['user_group_id']);
            $data['submodules'] = $this->sub_module_map_model->getSubModules();
            $data['modules'] = $this->sub_module_map_model->getModules();

            $data['user_group'] = $this->user_groups_model->getUserGroups($_POST['user_group_id']);
            $data['title'] = "Medstation | User Group Permissions";
            $data['search_url'] = "index.php/staff/search";

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;
            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));


            $this->load->view('templates/header', $data);
            $this->load->view('templates/mainheader', $data);
            $this->load->view('admin/staff/groups', $data);
            $this->load->view('templates/footer');


        } else {
            redirect('/login');
        }
    }

    public function searchDepartments()
    {
        if ($this->session->userdata('logged_in')) {

            $this->moduleAccessCheck(VIEW_STAFF_DATA);


            if (isset($_POST['dept_id'])) {
                $data['staffs'] = $this->staff_model->getStaffByDeptId($_POST['dept_id']);
            } else {
                $data['staffs'] = $this->patient_model->getStaff();
            }


            //get all user module mappings by role
            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

            $data['roles'] = $this->role_model->getroles();
            $data['departments'] = $this->department_model->getDepartments();
            $data['title'] = "Medstation | Staff Search";
            $data['search_url'] = "index.php/staff/search";

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;
            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));

            $this->load->view('templates/header', $data);
            $this->load->view('templates/mainheader', $data);
            $this->load->view('admin/staff/search', $data);
            $this->load->view('templates/footer');

        } else {
            redirect('/login');
        }

    }


    public function searchNumber()
    {
        if ($this->session->userdata('logged_in')) {

            $this->moduleAccessCheck(VIEW_STAFF_DATA);


            if (isset($_POST['staff_no'])) {
                $data['staffs'] = $this->staff_model->getStaffLikeNumber($_POST['staff_no']);
            } else {
                $data['staffs'] = $this->staff_model->getStaff();
            }


            //get all user module mappings by role
            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

            $data['roles'] = $this->role_model->getroles();
            $data['departments'] = $this->department_model->getDepartments();

            $data['title'] = "Medstation | Staff Search";
            $data['search_url'] = "index.php/staff/search";

            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;
            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));

            $this->load->view('templates/header', $data);
            $this->load->view('templates/mainheader', $data);
            $this->load->view('admin/staff/search', $data);
            $this->load->view('templates/footer');

        } else {
            redirect('/login');
        }

    }


    private function generateRandomPassword()
    {
        $length = 8;
        $password = "";


        $validCharacters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ&*@!1234567890";

        $validCharNumber = strlen($validCharacters);


        for ($i = 0; $i < $length; $i++) {
            $index = mt_rand(0, $validCharNumber - 1);
            $password .= $validCharacters[$index];
        }


        return $password;

    }

    public function add()
    {
        $this->session->unset_userdata('permission_error');
        if ($this->session->userdata('logged_in')) {

            $this->moduleAccessCheck(CREATE_STAFF);


            $data['title'] = "Medstation | Add Staff";


            //all module mappings
            $data['marital_stats'] = $this->marital_model->getMaritalStatus();
            $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
            $data['religions'] = $this->religion_model->getReligion();
            $data['countries'] = $this->country_model->getCountries();
            $data['user_groups'] = $this->user_groups_model->getUserGroups();
            $data['departments'] = $this->department_model->getDepartments();
            $data['currentmodule']['number'] = MODULE_NO;
            $data['currentmodule']['title'] = TITLE;
            $data['roles'] = $this->role_model->getroles();
            //get the role title
            $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));


            //prepare form
            $this->load->helper('form');
            $this->load->library('form_validation');


            //form validations here
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('dob', 'Date Of Birth', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required');
            $this->form_validation->set_rules('sex', 'Sex', 'required');
            $this->form_validation->set_rules('marital_status', 'Marital Status', 'required');
            $this->form_validation->set_rules('staff_no', 'Staff Number', 'required');
            $this->form_validation->set_rules('role_id', 'Role', 'required');
            $this->form_validation->set_rules('role_id', 'Role', 'required');
            $this->form_validation->set_rules('group_id', 'User Group', 'required');
            $this->form_validation->set_rules('dept_id', 'Department', 'required');

            //save last posted data
            if ($this->input->post("first_name")) {
                $data["first_name"] = $this->input->post("first_name");
            }

            if ($this->input->post("last_name")) {
                $data["last_name"] = $this->input->post("last_name");
            }
            if ($this->input->post("sex")) {
                $data["sex"] = $this->input->post("sex");
            }
            if ($this->input->post("middle_name")) {
                $data["middle_name"] = $this->input->post("middle_name");
            }
            if ($this->input->post("dob")) {
                $data["dob"] = $this->input->post("dob");
            }
            if ($this->input->post("occupation_id")) {
                $data["occupation_id"] = $this->input->post("occupation_id");
            }
            if ($this->input->post("religion_id")) {
                $data["religion_id"] = $this->input->post("religion_id");
            }
            if ($this->input->post("marital_status")) {
                $data["marital_status"] = $this->input->post("marital_status");
            }
            if ($this->input->post("state_of_origin")) {
                $data["state_of_origin"] = $this->input->post("state_of_origin");
            }
            if ($this->input->post("orign_country_code")) {
                $data["orign_country_code"] = $this->input->post("orign_country_code");
            }
            if ($this->input->post("orign_country_code")) {
                $data["orign_country_code"] = $this->input->post("orign_country_code");
            }
            if ($this->input->post("origin_lga_id")) {
                $data["origin_lga_id"] = $this->input->post("origin_lga_id");
            }
            if ($this->input->post("mobile_number")) {
                $data["mobile_number"] = $this->input->post("mobile_number");
            }
            if ($this->input->post("cell_number")) {
                $data["cell_number"] = $this->input->post("cell_number");
            }
            if ($this->input->post("email")) {
                $data["email"] = $this->input->post("email");
            }
            if ($this->input->post("alt_email")) {
                $data["alt_email"] = $this->input->post("alt_email");
            }
            if ($this->input->post("address_line_1")) {
                $data["address_line_1"] = $this->input->post("address_line_1");
            }
            if ($this->input->post("address_line_2")) {
                $data["address_line_2"] = $this->input->post("address_line_2");
            }
            if ($this->input->post("address_state_code")) {
                $data["address_state_code"] = $this->input->post("address_state_code");
            }
            if ($this->input->post("address_country_code")) {
                $data["address_country_code"] = $this->input->post("address_country_code");
            }
            if ($this->input->post("staff_no")) {
                $data["staff_no"] = $this->input->post("staff_no");
            }


            if ($this->form_validation->run() === FALSE) {


                $this->load->view('templates/header', $data);
                $this->load->view('templates/mainheader', $data);
                $this->load->view('admin/staff/create', $data);
                $this->load->view('templates/footer');

            } else {
                $existingLoginDetails = $this->ult->getuserlogin(trim($this->input->post("email")));

                if (sizeof($existingLoginDetails) > 1) {

                    $array = array('notice' => "Staff Not created staff email : " . $this->input->post("email") . " already exists");
                    $this->session->set_userdata($array);


                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/mainheader', $data);
                    $this->load->view('admin/staff/create', $data);
                    $this->load->view('templates/footer');


                    return;
                }


                //Print_r($_POST);
                $staff = $this->staff_model->getStaff($this->input->post("staff_no"));
                if (sizeof($staff) < 1) {


                    $return = $this->staff_model->set_staff();
                    if ($return) {
                        $password = $this->generateRandomPassword();
                        $hashedpwd = $this->passwordhash->HashPassword($password);

                        $return = false;
                        $return = $this->ult->set_user(trim($this->input->post("email")), $hashedpwd, trim($this->input->post("staff_no")));

                        $this->profile_pics_model->set_user_pic(trim($this->input->post("staff_no")));

                        $email = trim($this->input->post("email"));
                    }
                    //$this->session->set_userdata("notice","Staff Created Sucessfully. Please note down credentials\n User : $email \n Password : $password");

                    $array = array('notice' => "Staff Created Sucessfully. Please note down credentials User : " . $email . " Password : " . $password);
                    $this->session->set_userdata($array);
                    //$notice_message

                    $parameters["username"] = $email;
                    $parameters["password"] = $password;
                    //send email to staff with his credentials
                    $this->utilities->sendHtmlEmail(NEW_USER_EMAIL_TEMPLATE, $parameters, $email, "Welcome to Mediphix");

                    redirect('/admin');
                } else {
                    $data['validation-error'] = "Staff with Staff Number : " . $this->input->post("staff_no") . " already exists ";
                    $this->session->set_userdata("permission_error", "Staff Not created staff number : " + $this->input->post("staff_no") + " already exists");

                    $array = array('notice' => "Staff Not created staff number : " . $this->input->post("staff_no") . " already exists");
                    $this->session->set_userdata($array);
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/mainheader', $data);
                    $this->load->view('admin/staff/create', $data);
                    $this->load->view('templates/footer');
                }
            }

        } else {
            redirect('/login');

        }


    }


}