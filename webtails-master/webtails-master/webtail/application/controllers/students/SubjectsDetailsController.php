<?php
defined('BASEPATH') OR exit('No direct script access allowed');

final class SubjectsDetailsController extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SubjectsDetails');
    }

    public function read()
    {
       print_r($this->SubjectsDetails->read());
    }
}
