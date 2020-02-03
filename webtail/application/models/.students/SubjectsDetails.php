<?php

class SubjectsDetails extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $dataInputs = ['subjectName'];
    }

    public function read()
    {
        $query = $this->db->get(__CLASS__);
        return $query->result_array();
    }
}
