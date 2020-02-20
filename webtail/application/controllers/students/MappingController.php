<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class StudentsDetailsController
 * Author: Rohan Tandel
 * API Versions: V1
 */
final class MappingController extends CI_Controller {

    /**
     * construct function
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['UserDetails','RoleDetails','ContactDetails', 'DocumentDetails','ClassDetails']);
        $this->load->helper(['inputs', 'joins','students','output','Exit_helper']);
    }

    /**
     * studentList function 
     * read user data based on role ID default student
     */
    public function studentList()
    {
        return output($this->UserDetails->where(["roleId"=>$this->getUserRoleId()])->read(),'success','SM001');
    }

    /**
     * studentList function 
     * read user data based on role ID default student
     * @param $userName string 
     */
    public function userDetail()
    {
        inputs([
            'userName'=>[
                        'type'=>"array",
                        'value'=>$this->input->post('username'), 
                        'validation'=>"required|notEmpty"]
        ], $this);

        $userDetails = $this->UserDetails->where(["roleId"=>$this->getUserRoleId()]);
        if(!in_array("ALL", $this->inputs['userName'])) {
            $this->UserDetails->where_in( "userName",$this->inputs['userName']);
        } else {
            $this->UserDetails->where_not_in( "userName",$this->inputs['userName']);
        }
        $userDetails = $this->UserDetails->read();
       
        foreach($userDetails as $key=>$userDetail) {
            $contactDetails = $this->getContactDetails([$userDetail['_id']]);    

            if(!empty($contactDetails)) {
                $userDetails[$key]['contact'] = $contactDetails;
            }
            $documentDetails = $this->getDocumentDetails([$userDetail['_id']]);

            if(!empty($documentDetails)) {
                $userDetails[$key]['document'] = $documentDetails; 
            }
        }
        return output($userDetails,'success','SM001','api call success',"");
    }

    /**
     * parentList function 
     * read user data based on role ID by passing parent
     */
    public function parentList()
    {
       return output($this->UserDetails->where(["roleId"=>$this->getUserRoleId('parent')])->read(),'success','SM001','',"");
    }

    /**
     * getUserRoleId function
     * connect roles for user details based on user role student, parent ...etc
     */
    protected function getUserRoleId($type="student", $filter=true)
    {
        $return = '';
        $roleArray = $this->RoleDetails->where(["role"=>$type])->read();
        if($filter===true) {
            if(!empty($roleArray[0]['_id'])) {
                $return = $roleArray[0]['_id'];
            }
        }
        return $return;
    }

    /**
     * getContactDetails function
     * get contact details based on user Id 1 or N
     */
    protected function getContactDetails($userIdList, $key='userId')
    {
        return $state = $this->ContactDetails->where_in($key, $userIdList)->read();
    }

    /**
     * getContactDetails function
     * get contact details based on user Id 1 or N
     */
    protected function getDocumentDetails($userIdList, $key='userId')
    {
        return $state = $this->DocumentDetails->where_in($key, $userIdList)->read();
    }

}
