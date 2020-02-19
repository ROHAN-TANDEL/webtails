<?php
defined('BASEPATH') OR exit('No direct script access allowed');

final class StudentsDetailsController extends CI_Controller {
 
    /**
     * construct function
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['UserDetails','RoleDetails','ContactDetails']);
        $this->load->helper( ['inputs', 'joins','students','output','apisCall'] );
    }

    /**
     * studentList function 
     * read user data based on role ID default student
     */
    public function studentList()
    {
        echo "<pre>";
       print_r($this->UserDetails->where(["roleId"=>$this->getUserRoleId()])->read());
       output(readByJoins($this),'success','SM001');
    }

    /**
     * studentList function 
     * read user data based on role ID default student
     */
    public function userDetail()
    {
        $json = json_decode(trim(file_get_contents('php://input')), true);
        if(!empty($json)) {
            $_POST = $json;
        }
        $username = $this->input->post('username');
        $username = json_decode($username);
        inputs([
            'userName'=>['type'=>'array','value'=>json_decode($userName)]
            ], $this);
       $userDetails = $this->UserDetails->where(["roleId"=>$this->getUserRoleId()])->where_in( "userName",$this->inputs['userName'])->read();
       $contactDetails = $this->getContactDetails([$userDetails[0]['_id']]);
       print_r($userDetails);
       print_r($contactDetails);
       exit();

       print_r($this->UserDetails->distinct()->where(["userName"=> $userName, "roleId"=>$this->getUserRoleId()])->read());
    }

    /**
     * parentList function 
     * read user data based on role ID by passing parent
     */
    public function parentList()
    {
        echo "<pre>";
       print_r($this->UserDetails->where(["roleId"=>$this->getUserRoleId('parent')])->read());
    }

    /**
     * getUserRoleId function
     * connect roles for user details based on user role student, parent ...etc
     */
    public function getUserRoleId($type="student", $filter=true)
    {
        $roleArray = $this->RoleDetails->where(["role"=>$type])->read();
        if($filter===true) {
            if(!empty($roleArray[0]['_id'])) {
                return $roleArray[0]['_id'];
            } else {
                return "role not found";
            }
        }
    }

    public function getContactDetails($userIdList, $key='userId')
    {
        return $state = $this->ContactDetails->where_in($key, $userIdList)->read();
    }
}
