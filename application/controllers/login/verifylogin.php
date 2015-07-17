<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('usermodel');
        $this->usermodel->set_table('users');
        $this->load->library('form_validation');
    }

    function index() {
        $this->form_validation->set_rules('username', 'Login', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback__check_database');

        if ($this->form_validation->run() == FALSE) {
            $data['page_title'] = 'Błąd logowania';
            $this->load->view('headerview', $data);
            $this->load->view('login/loginview');
            $this->load->view('footerview');
        } else {
            $data = $this->session->userdata('logged_in');
            $statement = str_replace("%s", $data['username'], $this->lang->line("msg_user_loged_in"));
            $this->session->set_flashdata($statement);
            redirect('weather/admin', 'location');
        }
    }

    public function _check_database($password) {
        $username = $this->input->post('username');

        $result = $this->usermodel->login($username, $password);

        if ($result) {
            $sess_array = null;
            foreach ($result as $row) {
                $sess_array = array(
                    'id' => $row->id,
                    'username' => $row->username
                );
                $this->session->set_userdata('logged_in', $sess_array);
            }
            return TRUE;
        } else {
            $message = $this->lang->line('msg_user_invalid');
            $text = $message['text'];
            $this->form_validation->set_message('_check_database', $text);
            return false;
        }
    }

}
