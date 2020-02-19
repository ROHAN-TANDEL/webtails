<?php

class StudentSubjectMarksMapping extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $dataInputs = ['studentId', 'subjectId', 'marks', 'isDeleted'];
    }

    public function read()
    {
        $query = $this->db->get(__CLASS__);
        return $query->result_array();
    }

    public function update()
    {
        return $this->db->update(__CLASS__, $this->dataInputs);
    }
}
