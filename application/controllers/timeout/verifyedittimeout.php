<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class VerifyEditTimeout extends CI_Controller {

    private $_id = null;
    private $_timeoutvalue = null;

    function __construct() {
        parent::__construct();
        $this->_check_permissions();
        $this->load->model('commonmodel', '', TRUE);
        $this->commonmodel->set_table('timeout');
        $this->_id = 1;
        $this->_timeoutvalue = $this->input->post('timeout');
    }

    function index() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('timeout', 'Timeout value', 'trim|required|xss_clean|integer|greater_than[0]|less_than[7]');

        if ($this->form_validation->run() == FALSE) {
            $data = $this->commonmodel->get();
            $view['page_title'] = 'Timeout configuration [s]';
            $this->load->view('headerview', $view);
            $this->load->view('timeout/edittimeoutview', $data[0]);
            $this->load->view('footerview');
        } else {
            $data = array(array('id' => $this->_id), array('value' => $this->_timeoutvalue));
            switch ($this->commonmodel->update($data)) {
                case 0 : $statement = str_replace("%s", $data[1]['groupname'], $this->lang->line("msg_timeout_not_edited"));
                    break;
                default : $statement = str_replace("%s", $data[1]['groupname'], $this->lang->line("msg_timeout_edited"));
            }
            $this->session->set_flashdata($statement);
            redirect('timeout/timeout', 'location');
        }
    }

    private function _check_permissions() {
        if ($this->session->userdata('logged_in')) {
            $this->_session_data = $this->session->userdata('logged_in');
        } else {
            redirect('login/login', 'location');
        }
    }

}
