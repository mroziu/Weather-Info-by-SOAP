<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class VerifyEditCity extends CI_Controller {

    private $_oldcityname = null;
    private $_id = null;
    private $_cityname = null;

    function __construct() {
        parent::__construct();
        $this->_check_permissions();
        $this->load->model('commonmodel', '', TRUE);
        $this->commonmodel->set_table('city');

        $this->_id = $this->input->post('id');
        $this->_cityname = $this->input->post('cityname');
        $this->_oldcityname = $this->input->post('oldcityname');
    }

    function index() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cityname', 'Name', 'trim|required|min_length[3]|max_length[30]|xss_clean|callback__unique_name');

        if ($this->form_validation->run() == FALSE) {
            $data = $this->commonmodel->get_one($this->_id);
            $view['page_title'] = 'City name edit';
            $this->load->view('headerview', $view);
            $this->load->view('city/editcityview', $data[0]);
            $this->load->view('footerview');
        } else {
            $data = array(array('id' => $this->_id), array('name' => $this->_cityname));
            switch ($this->commonmodel->update($data)) {
                case 0 : $statement = str_replace("%s", $data[1]['cityname'], $this->lang->line("msg_city_not_edited"));
                    break;
                default : $statement = str_replace("%s", $data[1]['cityname'], $this->lang->line("msg_city_edited"));
            }
            $this->session->set_flashdata($statement);
            redirect('city/city', 'location');
        }
    }

    public function _unique_name($name) {
        if ($this->commonmodel->getone_by('name', $name) > 0 && $this->_cityname != $this->_oldcityname) {
            $message = $this->lang->line('msg_service_url_not_valid');
            $text = $message['text'];
            $statement = str_replace("%s", $name, $text);
            $this->form_validation->set_message('_unique_name', $statement);
            return false;
        }
        return true;
    }

    private function _check_permissions() {
        if ($this->session->userdata('logged_in')) {
            $this->_session_data = $this->session->userdata('logged_in');
        } else {
            redirect('login/login', 'location');
        }
    }

}
