<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once(APPPATH . 'libraries/datagrid.php' );

class DataGrid_Edit extends DataGrid {

    public function __construct($params) {
        parent::__construct($params);
    }

    protected function generateHead() {
        $this->_view .= PHP_EOL . '<table id="' . $this->_tableName . '" class="tablesorter">' . PHP_EOL . '<thead>' . PHP_EOL . '<tr>' . PHP_EOL;
        $no = 0;
        foreach ($this->_tableDesc as $col) {
            $this->_view .= "<th ";
            if (in_array($no, $this->_columns)) {
                $this->_view .= 'style="background-image: none;" ';
            }
            $no++;
            $this->_view .= "class=\"header\"> <strong>$col</strong> </th>" . PHP_EOL;
        }
        if ($this->_editable)
            $this->_view.="<th style=\"background-image: none;\" class=\"header\"> <strong>Edit</strong> </th>" . PHP_EOL;
        $this->_view .= '</tr>' . PHP_EOL . '</thead>' . PHP_EOL;
    }

    protected function generateData() {
        $on = 1;
        $this->_view.='<tbody class="t_body">' . PHP_EOL;
        foreach ($this->_data as $data) {
            $this->_view.='<tr>' . PHP_EOL;
            $this->_view.='<td class="highlight">' . $on . '</td>' . PHP_EOL;
            foreach ($this->_tableHeader as $col) {
                $this->_view.='<td class="highlight">' . $data->$col . '</td>' . PHP_EOL;
            }
            $on++;
            if ($this->_editable) {
                $currentController = & get_instance()->router->fetch_class();
                $this->_view.="<td class=\"highlight\">" . anchor(base_url($this->_controller_dir . '/' . $currentController . "/edit/" . $data->id), 'edit', array('class' => 'table_anchor_ed highlight', 'title' => 'edit')) . "</td>" . PHP_EOL;
            }
            $this->_view.='</tr>' . PHP_EOL;
        }
        $this->_view.='</tbody>' . PHP_EOL;
    }

}
