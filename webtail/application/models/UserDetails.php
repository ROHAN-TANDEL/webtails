<?php

class UserDetails extends CI_Model {

    public function __construct()
    {
        $this->dataInputs = ["userName","firstName" ,"lastName", "contact" ,"isDeleted" ,"_updatedAt"];
        parent::__construct(__CLASS__);
        $this->load->database();
    }
}
