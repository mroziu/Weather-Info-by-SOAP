<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once(APPPATH . 'libraries/html_options.php' );

class Html_Options_Onchange extends html_options {

    public function generate_options() {
        if ($this->_default_value) {
            if ($this->_disabled) {
                $js = 'disabled="disabled" id="' . $this->_options_name . '" onchange="load_location_types();"';
                return form_dropdown($this->_options_name, $this->generate_array(), $this->_default_value, $js);
            } else {
                $js = 'id="' . $this->_options_name . '" onchange="load_location_types();"';
                return form_dropdown($this->_options_name, $this->generate_array(), $this->_default_value, $js);
            }
        } else {
            $js = 'id="' . $this->_options_name . '" onchange="load_location_types();"';
            return form_dropdown($this->_options_name, $this->generate_array(), $this->_value, $js);
        }
    }

}
