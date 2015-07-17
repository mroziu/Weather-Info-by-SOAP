<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_permissions();
        $this->load->model('commonmodel', '', true);
        $this->commonmodel->set_table('services');
    }

    public function index() {
        $data['page_title'] = 'Weather services';
        $this->load->view('headerview', $data);

        $tableName = 'service';
        $editable = 1;
        $service = $this->commonmodel->get();
        $tableDesc = array('No.', 'Name', 'url');
        $tableHeader = array('name', 'url');
        $unsorted_columns = array(0, 3, 4);
        $controller_dir = 'service';
        $params = array($tableName, $editable, $service, $tableDesc, $tableHeader, $unsorted_columns, $controller_dir);
        $this->load->library('datagrid', $params);
        $crud['datagrid'] = $this->datagrid->generateTable();

        $this->load->view('service/serviceview', $crud);
        $this->load->view('footerview');
    }

    public function edit() {
        $service_id = $this->uri->segment(4, 0);
        if (is_numeric($service_id) && $data = $this->commonmodel->get_one($service_id)) {
            $params = array('page_title' => 'Service edit');
            $this->load->view('headerview', $params);
            $this->load->view('service/editserviceview', $data[0]);
            $this->load->view('footerview');
        } else {
            show_404();
        }
    }

    public function delete() {
        $service_id = $this->uri->segment(4, 0);
        if (is_numeric($service_id)) {
            if ($this->commonmodel->count() <2 ) {
                $statement = str_replace("%s", $service[0]->name, $this->lang->line("msg_service_cant_delete"));
                $this->session->set_flashdata($statement);
            } else {
                $service = $this->commonmodel->get_one($service_id);
                $this->commonmodel->delete($service_id);
                $statement = str_replace("%s", $service[0]->name, $this->lang->line("msg_service_deleted"));
                $this->session->set_flashdata($statement);
            }
        }
        redirect('service/service', 'location');
    }

    public function new_() {
        $params = array('page_title' => 'New service');
        $this->load->view('headerview', $params);
        $this->load->view('service/newserviceview');
        $this->load->view('footerview');
    }

    private function check_permissions() {
        if ($this->session->userdata('logged_in')) {
            $this->_session_data = $this->session->userdata('logged_in');
        } else {
            redirect('login/login', 'location');
        }
    }

}
