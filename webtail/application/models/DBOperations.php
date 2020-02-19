<?php

class DBOperations extends CI_Model{

    public function read()
    {
        $query = $this->db->get(__CLASS__);
        return $query->result_array();
    }

    public function readCursor($start=0, $limit=1, $result=false)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get(__CLASS__);
        if($result === true){
            return $query->result_array();   
        } else {
            return $this;
        }
    }

    public function limit($start=0, $limit=1)
    {
        $this->db->limit($limit, $start);
        return $this;        
    }

    public function where(array $where)
    {
        $this->db->where($where);
        return $this;
    }

    public function update(array $dataToUpdate, $result=false)
    {
        if($result === true) {
            return $this->db->update(__CLASS__, $dataToUpdate);
        } else {
            return $this;
        }
    }

    public function delete(array $dataToUpdate, $result=false) {
        if($result === true) {
            return $this->db->update(__CLASS__, $dataToUpdate);
        } else {
            return $this;
        }
    }

    public function insert(array $dataToUpdate, $result=false)
    {
        if($result===true) {
            return $this->db->insert(__CLASS__, $dataToUpdate);
        } else {
            return $this;
        }
    }

}