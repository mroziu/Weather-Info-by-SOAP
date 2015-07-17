<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

Class CommonModel extends CI_Model {

    protected $_tableName = null;

    public function set_table($tableName) {
        $this->_tableName = $tableName;
    }

    public function get($order_by = '') {
        $this->db->select('*');
        $this->db->from($this->_tableName);
        if ($order_by != '') $this->db->order_by($order_by);         
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_one($id) {
        $this->db->select('*');
        $this->db->from($this->_tableName);
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getone_by($field, $val) {
        $this->db->select('*');
        $this->db->from($this->_tableName);
        $this->db->where($field, $val);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function delete_by_like($field, $like) {
        $this->db->like($field, $like);
        $this->db->delete($this->_tableName);
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->_tableName);
        return $this->db->affected_rows();
    }

    public function _new(array $data) {
        $this->db->set($data);
        $this->db->insert($this->_tableName);
        return $this->db->affected_rows();
    }

    public function update(array $data) {
        $id = $data[0]['id'];
        $dataToSave = $data[1];
        $this->db->where('id', $id);
        $this->db->update($this->_tableName, $dataToSave);
        return $this->db->affected_rows();
    }
    
    public function count() {
        return $this->db->count_all($this->_tableName);        
    }

}
