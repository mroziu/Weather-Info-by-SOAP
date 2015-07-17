<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class VerifyEditService extends CI_Controller {

    private $_oldservicename = null;
    private $_id = null;
    private $_servicename = null;
    private $_serviceurl = null;

    function __construct() {
        parent::__construct();
        $this->check_permissions();
        $this->load->model('commonmodel', '', TRUE);
        $this->commonmodel->set_table('services');
        //
        $this->_id = $this->input->post('id');
        $this->_servicename = $this->input->post('name');
        $this->_serviceurl = $this->input->post('url');
        $this->_oldservicename = $this->input->post('oldservicename');
    }

    function index() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Service Name', 'trim|required|min_length[2]|max_length[30]|xss_clean|callback__unique_name');
        $this->form_validation->set_rules('url', 'Service Url', 'trim|required|min_length[11]|max_length[120]|xss_clean|callback__validurl');

        if ($this->form_validation->run() == FALSE) {
            $data = $this->commonmodel->get_one($this->_id);
            $view['page_title'] = 'Weather service edit';
            $this->load->view('headerview', $view);
            $this->load->view('service/editserviceview', $data[0]);
            $this->load->view('footerview');
        } else {
            $data = array(array('id' => $this->_id), array('name' => $this->_servicename, 'url' => $this->_serviceurl));
            switch ($this->commonmodel->update($data)) {
                case 0 : $statement = str_replace("%s", $data[1]['servicename'], $this->lang->line("msg_service_not_edited"));
                    break;
                default : $statement = str_replace("%s", $data[1]['servicename'], $this->lang->line("msg_service_edited"));
            }
            $this->session->set_flashdata($statement);
            redirect('service/service', 'location');
        }
    }

    public function _unique_name($name) {
        if ($this->commonmodel->getone_by('name', $name) > 0 && $this->_servicename != $this->_oldservicename) {
            $message = $this->lang->line('msg_service_not_unique');
            $text = $message['text'];
            $statement = str_replace("%s", $name, $text);
            $this->form_validation->set_message('_unique_name', $statement);
            return false;
        }

        return true;
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

    private function check_permissions() {
        if ($this->session->userdata('logged_in')) {
            $this->_session_data = $this->session->userdata('logged_in');
        } else {
            redirect('login/login', 'location');
        }
    }

}
