<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class City extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->_check_permissions();
        $this->load->model('commonmodel', '', true);
        $this->commonmodel->set_table('city');
    }

    public function index() {
        $data['page_title'] = 'City';
        $this->load->view('headerview', $data);

        $tableName = 'city';
        $editable = 1;
        $city = $this->commonmodel->get('name');
        $tableDesc = array('No.', 'City');
        $tableHeader = array('name');
        $unsorted_columns = array(0, 2, 3);
        $controller_dir = 'city';
        $params = array($tableName, $editable, $city, $tableDesc, $tableHeader, $unsorted_columns, $controller_dir);
        $this->load->library('datagrid', $params);
        $crud['datagrid'] = $this->datagrid->generateTable();

        $this->load->view('city/cityview', $crud);
        $this->load->view('footerview');
    }

    public function edit() {
        $city_id = $this->uri->segment(4, 0);
        if (is_numeric($city_id) && $data = $this->commonmodel->get_one($city_id)) {
            $params = array('page_title' => 'City name edit');
            $this->load->view('headerview', $params);
            $this->load->view('city/editcityview', $data[0]);
            $this->load->view('footerview');
        } else {
            redirect('city/city', 'location');
        }
    }

    public function delete() {
        $city_id = $this->uri->segment(4, 0);
        if (is_numeric($city_id)) {
            $city = $this->commonmodel->get_one($city_id);
            $this->_delete_city_in_weather_table($city[0]->name);
            $this->commonmodel->set_table('city');
            $this->commonmodel->delete($city_id);
            $statement = str_replace("%s", $city[0]->name, $this->lang->line("msg_city_deleted"));
            $this->session->set_flashdata($statement);
        }
        redirect('city/city', 'location');
    }

    public function new_() {
        $params = array('page_title' => 'New city');
        $this->load->view('headerview', $params);
        $this->load->view('city/newcityview');
        $this->load->view('footerview');
    }

    private function _delete_city_in_weather_table($city_name) {
        $this->commonmodel->set_table('weather');
        $this->commonmodel->delete_by_like('location', $city_name);
    }

    private function _check_permissions() {
        if ($this->session->userdata('logged_in')) {
            $this->_session_data = $this->session->userdata('logged_in');
        } else {
            redirect('login/login', 'location');
        }
    }

}
