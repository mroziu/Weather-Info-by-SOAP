<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DataGrid {

    protected $_tableName = null;
    protected $_editable = null;
    protected $_data = null;
    protected $_tableDesc = null;
    protected $_tableHeader = null;
    protected $_columns = array();
    protected $_controller_dir = null;
    protected $_no_search_bar = null;
    protected $_view = null;

    public function __construct($params) {
        $this->_tableName = $params[0];
        $this->_editable = $params[1];
        $this->_data = $params[2];
        $this->_tableDesc = $params[3];
        $this->_tableHeader = $params[4];
        $this->_columns = $params[5];
        $this->_controller_dir = $params[6];
    }

    protected function generateSort() {
        $this->_view = PHP_EOL . '<script>
$(document).ready(function() { 
        $("#' . $this->_tableName . '").tablesorter({
            headers: {';
        foreach ($this->_columns as $no) {
            $this->_view .= PHP_EOL . "$no: { filter: false, sorter: false },";
        }
        $this->_view .= PHP_EOL . '},
            widgets: [\'numbering\', \'filter\'],
            widgetOptions : {
                  filter_external : \'\',
                  filter_columnFilters: true,
                  filter_placeholder: { search : \'Search...\' },
            }';
        $this->_view .= '}); 
});';
        $this->_view .= '
// add custom numbering widget
$.tablesorter.addWidget({
    id: "numbering",
    format: function(table) {
        //var c = table.config;
        $("tr:visible", table.tBodies[0]).each(function(i) {
            $(this).find(\'td\').eq(0).text(i + 1);
        });
    }
});';

        $this->_view .= '</script>' . PHP_EOL;
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
            $this->_view.="<th style=\"background-image: none;\" class=\"header\"> <strong>Edit</strong> </th>" . PHP_EOL . "<th style=\"background-image: none;\" class=\"header\"> <strong>Delete</strong> </th>" . PHP_EOL;
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
                $this->_view.="<td class=\"highlight\">" . anchor(base_url($this->_controller_dir . '/' . $currentController . "/edit/" . $data->id), 'edit', array('class' => 'table_anchor_ed highlight', 'title' => 'Edit')) . "</td>" . PHP_EOL;
                $this->_view.="<td class=\"highlight\">" . anchor(base_url($this->_controller_dir . '/' . $currentController . "/delete/" . $data->id), 'delete', array('class' => 'table_anchor_del highlight', 'title' => 'Delete', 'onClick'=>'return confirm(\'Are you absolutely sure you want to delete?\')')) . "</td>" . PHP_EOL;
            }
            $this->_view.='</tr>' . PHP_EOL;
        }
        $this->_view.='</tbody>' . PHP_EOL;
    }

    protected function generateFooter() {
        $this->_view.='</table>' . PHP_EOL;
    }

    public function generateTable() {
        $this->generateSort();
        $this->generateHead();
        if (!empty($this->_data)) {
            $this->generateData();
        }
        $this->generateFooter();

        return $this->_view;
    }

}
