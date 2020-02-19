<?php

class ContactDetails extends CI_Model {

    public function __construct()
    {
        $this->dataInputs = ["userId", "phoneNumber","email", "address","_updatedAt"];
        parent::__construct(__CLASS__);
        $this->load->database();
    }
}
