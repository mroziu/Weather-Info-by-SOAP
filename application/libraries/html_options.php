<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Html_Options {

    protected $_data = null;
    protected $_value = null;
    protected $_text = null;
    protected $_options_name = null;
    protected $_default_value = null;
    protected $_disabled = null;

    public function set_params($params) {
        $this->_data = $params['data'];
        $this->_options_name = $params['options_name'];
        $this->_value = $params['value'];
        $this->_text = $params['text'];
        if (isset($params['default']))
            $this->_default_value = $params['default'];
        if (isset($params['disabled']))
            $this->_disabled = $params['disabled'];
    }

    public function generate_options() {
        if ($this->_default_value) {
            if ($this->_disabled) {
                return form_dropdown($this->_options_name, $this->generate_array(), $this->_default_value, 'disabled="disabled", id="' . $this->_options_name . '"');
            } else {
                return form_dropdown($this->_options_name, $this->generate_array(), $this->_default_value, 'id="' . $this->_options_name . '"');
            }
        } else {
            return form_dropdown($this->_options_name, $this->generate_array(), NULL, 'id="' . $this->_options_name . '"');
        }
    }

    protected function generate_array() {
        foreach ($this->_data as $data) {
            $a = $this->_value;
            $b = $this->_text;
            $key = $data->$a;
            $value = $data->$b;
            $options_array[$key] = $value;
        }
        return $options_array;
    }

}
