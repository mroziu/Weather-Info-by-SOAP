<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class VerifyNewCity extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->check_permissions();
        $this->load->model('commonmodel', '', TRUE);
        $this->commonmodel->set_table('city');
    }

    function index() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'City name', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[city.name]');

        if ($this->form_validation->run() == FALSE) {
            $view['page_title'] = 'New city';
            $this->load->view('headerview', $view);
            $this->load->view('city/newcityview');
            $this->load->view('footerview');
        } else {
            $data = $this->input->post();
            if ($this->commonmodel->_new($data) > 0) {
                $statement = str_replace("%s", $data['name'], $this->lang->line("msg_city_created"));
            } else {
                $statement = str_replace("%s", $data['name'], $this->lang->line("msg_city_not_created"));
            }
            $this->session->set_flashdata($statement);
            redirect('city/city', 'location');
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
