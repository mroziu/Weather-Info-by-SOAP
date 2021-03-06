<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Weather extends CI_Controller {

    private $city;

    function __construct() {
        parent::__construct();
        session_start();
        $this->load->model('commonmodel', '', TRUE);
    }

    public function index() {
        $data['page_title'] = 'Weather Information';
        $city = $this->_get_city();
        $this->load->view('headerview', $data);
        $this->load->view('mainview', $city);
        $this->load->view('footerview');
    }

    public function admin() {
        $this->_check_permissions();
        $data['page_title'] = 'Command Center';
        $this->load->view('headerview', $data);
        $this->load->view('adminmainview');
        $this->load->view('footerview');
    }

    public function get_weather_information() {
        $this->city = $this->uri->segment(3, 0);

        $timeout = $this->_get_timeout_from_db();
        $time_out = $timeout[0]->value;
        $activeurl = $this->_get_active_url_from_db();
        $url = $activeurl[0]->url;
        $params = array('url' => $url, 'time_out' => $time_out);

        $this->load->library('receiveweatherbysoap', $params);
        $this->receiveweatherbysoap->set_city($this->city);
        $simpleXMLobj = $this->receiveweatherbysoap->get_xml();
        $html_table = $this->_choose_getting_method($simpleXMLobj);

        echo json_encode($html_table);
    }

    private function _check_permissions() {
        if ($this->session->userdata('logged_in')) {
            $this->_session_data = $this->session->userdata('logged_in');
        } else {
            redirect('login/login', 'location');
        }
    }

    private function _choose_getting_method($simpleXMLobj) {
        $html_table = $simpleXMLobj;
        switch ($simpleXMLobj) {
            case "Could not connect to host" :
                $html_table = $this->_read_message_lang('msg_try_later');
                $weather_obj = $this->_read_data_from_DB($this->city);
                if (empty($weather_obj)) {
                    $html_table .= $this->_read_message_lang('msg_no_data');
                } else {
                    $html_table = $this->_convert_xmlobj_to_html_table($weather_obj[0]);
                }
                break;
            case "Data Not Found" :
                $html_table .= $this->_read_message_lang('msg_not_found');
                break;
            case "Error Fetching http headers" :
                $weather_obj = $this->_read_data_from_DB($this->city);
                if (empty($weather_obj)) {
                    $html_table = $this->_read_message_lang('msg_no_data');
                } else {
                    $html_table = $this->_convert_xmlobj_to_html_table($weather_obj[0]);
                }
                break;
            case "HTTP Error" :
                $weather_obj = $this->_read_data_from_DB($this->city);
                if (empty($weather_obj)) {
                    $html_table = $this->_read_message_lang('msg_no_data');
                } else {
                    $html_table = $this->_convert_xmlobj_to_html_table($weather_obj[0]);
                }
                break;
            default :
                $html_table = $this->_convert_xmlobj_to_html_table($simpleXMLobj);
                $this->_save_data_to_DB($simpleXMLobj);
        }
        return $html_table;
    }

    private function _read_message_lang($name) {
        $arr = $this->lang->line($name);
        return $arr['text'];
    }

    private function _read_data_from_DB() {
        $this->commonmodel->set_table('city');
        $city_id_obj = $this->commonmodel->getone_by('name', $this->city);
        $city_id = $city_id_obj[0]->id;
        $this->commonmodel->set_table('weather');
        $weather_obj = $this->commonmodel->getone_by('city_id', $city_id);
        if (!empty($weather_obj)) {
            unset($weather_obj[0]->id);
            unset($weather_obj[0]->city_id);
        }
        return $weather_obj;
    }

    private function _save_data_to_DB($xml_data) {
        $arr = $this->_convert_xmlobj_to_array($xml_data);

        $this->commonmodel->set_table('city');
        $city_id_obj = $this->commonmodel->getone_by('name', $this->city);
        $arr['city_id'] = $city_id_obj[0]->id;

        $this->commonmodel->set_table('weather');
        $weather_id_obj = $this->commonmodel->getone_by('city_id', $arr['city_id']);
        $empty = empty($weather_id_obj) ? 1 : 0;
        $this->commonmodel->set_table('weather');
        $arr['Status'] = $this->_read_message_lang('msg_offline');
        switch ($empty) {
            case 1 :
                $this->commonmodel->_new($arr);
                break;
            case 0 :
                $city_id = $weather_id_obj[0]->id;

                $data[0]['id'] = $city_id;
                $data[1] = $arr;

                $this->commonmodel->update($data);
                break;
        }
    }

    private function _get_timeout_from_db() {
        $this->commonmodel->set_table('timeout');
        return $this->commonmodel->get();
    }

    private function _get_active_url_from_db() {
        $this->commonmodel->set_table('services');
        return $this->commonmodel->get();
    }

    private function _convert_xmlobj_to_html_table($simpleXMLobj) {
        $html = '';
        foreach ($simpleXMLobj as $key => $value) {
            $html .= '<tr><td>';
            $html .= $key;
            $html .= '</td><td>';
            $html .= $value;
            $html .= '</td></tr>';
        }
        return $html;
    }

    private function _convert_xmlobj_to_array($simpleXMLobj) {
        foreach ($simpleXMLobj as $key => $value) {
            $arr[$key] = htmlspecialchars($value, ENT_QUOTES);
        }
        return $arr;
    }

    private function _get_city() {
        $this->commonmodel->set_table('city');
        $this->load->library('html_options');
        $city = $this->commonmodel->get('name');
        if (false !== $city) {
            $params = array('data' => $city, 'options_name' => 'city_name', 'value' => 'name', 'text' => 'name');
            $this->html_options->set_params($params);
            $data['html_options'] = $this->html_options->generate_options();
            return $data;
        } else {
            show_error($this->lang->line("msg_database_error"));
        }
    }

}
