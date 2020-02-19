<?php

class DocumentDetails extends CI_Model {

    public function __construct()
    {
        $this->dataInputs = ["userId", "documentName", "documentUrl", "documentType", "_updatedAt"];
        parent::__construct(__CLASS__);
        $this->load->database();
    }
}
