<?php

class StudentsDetails extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $dataInputs = ['studentName'];
    }

    public function read()
    {
        $query = $this->db->get(__CLASS__);
        return $query->result_array();
    }
}
