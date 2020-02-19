<?php
defined('BASEPATH') OR exit('No direct script access allowed');

final class StudentsDetailsController extends CI_Controller {
 
    /**
     * construct function
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('StudentsDetails');
    }

    /**
     * read function 
     * read data from backend
     */
    public function read()
    {
       print_r($this->StudentsDetails->read());
    }
}
