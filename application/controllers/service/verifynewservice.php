<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class VerifyNewService extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->_check_permissions();
        $this->load->model('commonmodel', '', TRUE);
        $this->commonmodel->set_table('services');
    }

    function index() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Service name', 'trim|required|min_length[3]|max_length[30]|xss_clean|is_unique[services.name]');
        $this->form_validation->set_rules('url', 'Service url', 'trim|required|min_length[11]|max_length[120]|xss_clean|callback__validurl');

        if ($this->form_validation->run() == FALSE) {
            $view['page_title'] = 'New service';
            $this->load->view('headerview', $view);
            $this->load->view('service/newserviceview');
            $this->load->view('footerview');
        } else {
            $data = $this->input->post();
            if ($this->commonmodel->_new($data) > 0) {
                $statement = str_replace("%s", $data['name'], $this->lang->line("msg_service_created"));
            } else {
                $statement = str_replace("%s", $data['name'], $this->lang->line("msg_service_not_created"));
            }
            $this->session->set_flashdata($statement);
            redirect('service/service', 'location');
        }
    }

    public function _validurl($url) {
        if (!$this->_checkurl($url)) {
            $message = $this->lang->line('msg_service_url_not_valid');
            $text = $message['text'];
            $statement = str_replace("%s", $url, $text);
            $this->form_validation->set_message('_validurl', $statement);
            return false;
        }
        return true;
    }
    
    private function _checkurl($input) {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $input);
    }    

    private function _check_permissions() {
        if ($this->session->userdata('logged_in')) {
            $this->_session_data = $this->session->userdata('logged_in');
        } else {
            redirect('login/login', 'location');
        }
    }

}
