<?php

class ClassDetails extends CI_Model {

    public function __construct()
    {
        $this->dataInputs = ["standard", "userId", "_updatedAt"];
        parent::__construct(__CLASS__);
        $this->load->database();
    }
}
