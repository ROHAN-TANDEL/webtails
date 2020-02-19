<?php

class SubjectsDetails extends CI_Model {

    public function __construct()
    {
        $this->dataInputs = ["subjectName", "_updatedAt"];
        parent::__construct(__CLASS__);
        $this->load->database();
    }
}
