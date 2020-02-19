<?php

class RoleDetails extends CI_Model {

    public function __construct()
    {
        $this->dataInputs = ["role", "permission", "_updatedAt"];
        parent::__construct(__CLASS__);
        $this->load->database();
    }
}
