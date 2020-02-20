<?php

class Mapping extends CI_Model {

    public function __construct()
    {
        parent::__construct(__CLASS__);
        $this->load->database();
    }
}
