<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timeout extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_permissions();
        $this->load->model('commonmodel', '', true);
        $this->commonmodel->set_table('timeout');
    }

    public function index() {
        $data['page_title'] = 'Timeout configuration [s]';
        $this->load->view('headerview', $data);
        $tableName = 'timeout';
        $timeout = $this->commonmodel->get();
        $tableDesc = array('No.', 'Value');
        $tableHeader = array('value');
        $unsorted_columns = array(0, 1, 2);
        $controller_dir = 'timeout';
        $editable = 1;
        $params = array($tableName, $editable, $timeout, $tableDesc, $tableHeader, $unsorted_columns, $controller_dir);
        $this->load->library('datagrid_edit', $params);
        $crud['datagrid'] = $this->datagrid_edit->generateTable();

        $this->load->view('timeout/timeoutview', $crud);
        $this->load->view('footerview');
    }

    public function edit() {
        if ($data = $this->commonmodel->get()) {
            $params = array('page_title' => 'Timeout configuration [s]');
            $this->load->view('headerview', $params);
            $this->load->view('timeout/edittimeoutview', $data[0]);
            $this->load->view('footerview');
        } else {
            die('Database error');
        }
    }

    private function check_permissions() {
        if ($this->session->userdata('logged_in')) {
            $this->_session_data = $this->session->userdata('logged_in');
        } else {
            redirect('login/login', 'location');
        }
    }

}
