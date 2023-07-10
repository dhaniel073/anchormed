<?php

class Drug_master_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }


    public function getDrug($drug_id = FALSE)
    {

        if ($drug_id === FALSE) {
            $this->db->select('*');
            $this->db->order_by("name", "asc");
            $this->db->from('drug_master_table');
            $where_clause = "(`status` = 'A')";
            $this->db->where($where_clause);

            $query = $this->db->get();
            return $query->result_array();
        }

        $query = $this->db->get_where('drug_master_table', array('drug_id' => $drug_id));
        return $query->row_array();
    }

    public function getDrugLikeName($name)
    {

        $query = $this->db->get_where('drug_master_table', array('name' => $name, 'status' => 'A'));
        $result_array = $query->result_array();
        if ($result_array && sizeof($result_array) > 0) {
            return $result_array;
        } else {

            $test = preg_split('[ ]', $name);

            $where_clause = "((";

            if (sizeof($test) > 1) {
                $i = 0;

                foreach ($test as $t) {
                    if ($i > 0) {
                        $where_clause = $where_clause . " OR  ";
                    }
                    $where_clause = $where_clause . "`name` LIKE '%$t%' ";

                    $i++;
                }

                $where_clause = $where_clause . ") and `status` = 'A' )";


            } else $where_clause = "(`name` LIKE '%$name%' and `status` = 'A' )";


            $this->db->select('*');
            $this->db->order_by("name", "asc");
            $this->db->from('drug_master_table');
            $this->db->where($where_clause);


            $query = $this->db->get();
            return $query->result_array();
        }
    }
    
    public function getDrugByNameAndManufacturer($name, $manufacturer)
    {

        $query = $this->db->get_where('drug_master_table', array('name' => $name, 'manufacturer' => $manufacturer, 'status' => 'A'));

        return $query->row_array();
    }


    public function set_drug_excel($name,$manufacturer,$dosageForm,$description,$staff_no){

        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');


        $data = array('name' => $name,
            'created_by' => $staff_no,
            'status' => 'A',
            'date_created' => $todaysDate,
            'drug_presentation_id' => $dosageForm,
            'manufacturer' => $manufacturer,
            'picture' => "default.jpg");

        if ($description) {
            $data['packaging_description'] = $description;
        }

        return $this->db->insert('drug_master_table', $data);

    }

    public function set_drug($staff_no, $picture)
    {
        $date = new DateTime();
        date_timezone_set($date, timezone_open('Africa/Lagos'));
        $todaysDate = date_format($date, 'Y-m-d H:i:s');




        $data = array('name' => $this->input->post('name'),
            'created_by' => $staff_no,
            'status' => 'A',
            'date_created' => $todaysDate,
            'drug_presentation_id' => $this->input->post('drug_presentation_id'),
            'manufacturer' => $this->input->post('manufacturer'),
            'picture' => $picture);

        if ($this->input->post('description')) {
            $data['packaging_description'] = $this->input->post('description');
        }

        return $this->db->insert('drug_master_table', $data);
    }


}