<?php
define ('MODULE_NO', 9);
define ('HOME', 21);
define ('TITLE', 'Cash Management');


class Cashier extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('country_model');
        $this->load->model('module_map_model');
        $this->load->model('sub_module_map_model');
        $this->load->model('role_model');
        $this->load->model('bills_model');
        $this->load->model('partial_payments_model');
        $this->load->model('non_customer_order_model');
        $this->utilities->loadUserLang();

    }


    public function search()
    {
        $this->utilities->aunthenticateAccess(CASHIER_HOME, "home");

        $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

        //get the role title
        $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));

        // print_r($data['partial_current_bill'] = $this->bills_model->getBillPartialByReference($data['user_role']));
        

        $data['currentmodule']['number'] = MODULE_NO;
        $data['currentmodule']['title'] = TITLE;
        $data['search_url'] = "index.php/cashier/search";
        $data['title'] = "Medstation | Cashier";
        $data['content-description'] = "Cash Management";

        $search = FALSE;
        if ($this->input->post('name')) {
            $search = $this->input->post('name');

        }

        $data['unposted'] = $this->bills_model->get_all_unposted($search);

        // $billcheck = $data['partial_current_bill'] = $this->bills_model->getBillPartialByReference($unposted['reference_id']);

            $reference = [];
            $ref = $data['unposted'];
            foreach($ref as $refs){
                $referencecheck = $refs['status'];
                $referencecheck1 = $refs['reference_id'];
                $billcheck =  $data['partial_current_bill'] = $this->partial_payments_model->getPartialPaymentByReference($referencecheck);
                // print_r($referencecheck);
                // echo( $referencecheck1);
            };
        //hack for walk in customers
        $counter = 0;
        foreach ($data['unposted'] as $unposted) {
            if ($unposted['patient_number'] == NON_CUSTOMER_ID) {
                //get the name from the walk in order table
                $walkInBill = $this->non_customer_order_model->getNonCustomerOrderByReference($unposted['reference_id']);
                
                // print_r($unposted['reference_id']);
                $data['unposted'][$counter]['first_name'] = $walkInBill['name'];
                $data['unposted'][$counter]['last_name'] = "";

            }
            $data['unposted'][$counter]['patient_total'] = $this->bills_model->gettotalamount($unposted['reference_id']);
            $data['unposted'][$counter]['patient_partial_payment'] = $this->bills_model->gettotalamountdue($unposted['reference_id']);
            
            $counter++;
            
        }


        $pages[0] = "cashier/search";
        $this->page->loadPage($pages, $data, TRUE);
    }

    public function index()
    {

        $this->utilities->aunthenticateAccess(CASHIER_HOME, "home");

        $data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));

        //get the role title
        $data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));

        $data['currentmodule']['number'] = MODULE_NO;
        $data['currentmodule']['title'] = TITLE;
        $data['title'] = "Medstation | Cashier";
        $data['content-description'] = "Cash Management";


        $pages[0] = "cashier/home";
        $this->page->loadPage($pages, $data, TRUE);
    }


}