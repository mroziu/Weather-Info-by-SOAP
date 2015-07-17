<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->load->helper(array('form'));
        if (!$this->session->userdata('logged_in')) {
            $data['page_title'] = 'Login';
        } else {
            $this->session->set_flashdata($this->lang->line("msg_user_loged_in_already"));
            redirect('', 'location');
        }
        $this->load->view('headerview', $data);
        $this->load->view('login/loginview');
        $this->load->view('footerview');
    }

    function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->set_flashdata($this->lang->line("msg_user_logged_out"));
        redirect('', 'location');
        $this->session->sess_destroy();
    }

}
