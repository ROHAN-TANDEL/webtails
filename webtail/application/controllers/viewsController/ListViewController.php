<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//http://localhost:81/webtails/index.php/students/StudentSubjectMarksMappingController/listMapCursor/2000/0

final class ListViewController extends CI_Controller {
    private $domain;
    public function __construct()
    {
        $this->domain = $_SERVER['HTTP_HOST'];
        
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper( ['inputs', 'joins','students','output','apisCall'] );
        $this->load->controller( ['students\StudentSubjectMarksMappingController']);
    }

    public function index()
    {
        $mapList = $this->StudentSubjectMarksMappingController->listMapCursor("123", "0","internal");
        $deleteAPI = 'ListViewController' . '/' . 'delete' . '/';
        $header = ['studentName'=>'hidden-xs-down','subjectname'=>'','marks'=>'hidden-xs-down'];
        $data = $mapList['output'];
        $viewData = ['header'=>$header,'data'=>$data, 'deleteAPI'=>$deleteAPI];
        $this->load->view('headerView');
        $this->load->view('listView', ['viewData' => $viewData]);
        $this->load->view('footerView');
    }

    public function loadViews()
    {
        $mapList = $this->StudentSubjectMarksMappingController->listMapCursor("2000", "0","internal");
 
        $deleteAPI = 'ListViewController' . '/' . 'delete' . '/';
        $header = ['studentName'=>'hidden-xs-down','subjectname'=>'','marks'=>'hidden-xs-down'];

        $data = $mapList['output'];
        $viewData = ['header'=>$header,'data'=>$data, 'deleteAPI'=>$deleteAPI];
 
        $this->load->view('headerView');
 
        switch ($viewName) {
            case "filter":
            $this->load->view('filter');
            break;
            case 'editForm':
            $this->load->view('popUp');
            break;
            case 'login':
            $this->load->view('login');
            break;
        }
        $this->load->view('listView', ['viewData' => $viewData]);
        $this->load->view('footerView');
    }

    public function delete($id)
    {
        $this->StudentSubjectMarksMappingController->deleteMapById($id);
        $mapList = $this->StudentSubjectMarksMappingController->listMapCursor("123", "0","internal");
        $deleteAPI = 'ListViewController' . '/' . 'delete' . '/';
        $header = ['studentName'=>'hidden-xs-down','subjectname'=>'','marks'=>'hidden-xs-down'];
        $data = $mapList['output'];
        $viewData = ['header'=>$header,'data'=>$data, 'deleteAPI'=>$deleteAPI];
        $this->load->view('headerView');
        $this->load->view('listView', ['viewData' => $viewData]);
        $this->load->view('footerView');

        header("Location:". API_PATH . 'viewsController/' .__CLASS__); 
    }
}