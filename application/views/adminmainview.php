<?php
        echo '<ul id="main_menu">';
	if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            if ($this->session->userdata('logged_in'))
            {
                echo '<li>'.anchor('city/city', 'City database', 'title="City database"');
                echo '<li>'.anchor('service/service', 'Weather services', 'title="Weather services"');
                echo '<li>'.anchor('timeout/timeout', 'Timeout config', 'title="Timeout config"');
            }
            echo '<li style="clear: both; float: right;">'.anchor('login/login/logout', 'Logout', array('class' => 'control', 'title' => 'Logout'));
        }
        echo '</ul>';