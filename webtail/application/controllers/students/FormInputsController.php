<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class ContactDetailsController
 * Author: Rohan Tandel
 * API Versions: V1
 */
final class FormInputsController extends CI_Controller {

    /**
     * construct function
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['SubjectsDetails', 'UserDetails','RoleDetails','ContactDetails', 'DocumentDetails','ClassDetails','Mapping']);
        $this->load->helper(['inputs', 'joins','students','output','Exit_helper']);
    }

    public function upsertUserData()
    {
        inputs([
            'firstName'=>[
                'type'=>"string",
                'value'=>$this->input->post('firstName'), 
                'validation'=>"required|notEmpty|Name"],
            'lastName'=>[
                'type'=>"string",
                'value'=>$this->input->post('lastName'), 
                'validation'=>"required|notEmpty|Name"],
            'userName'=>[
                'type'=>"string",
                'value'=>$this->input->post('userName'), 
                'validation'=>"required|notEmpty|Name"],
            'parentName'=>[
                'type'=>"string",
                'value'=>$this->input->post('parentName'), 
                'validation'=>"required|notEmpty|Name"],
            'phoneNumber'=>[
                'type'=>"int",
                'value'=>$this->input->post('phoneNumber'), 
                'validation'=>"required|notEmpty|length|15"],
            'class'=>[
                'type'=>"int",
                'value'=>$this->input->post('class'), 
                'validation'=>"required|notEmpty|max|10|min|1|length|11"],
            'subject'=>[
                'type'=>"string",
                'value'=>$this->input->post('subject'), 
                'validation'=>"required|notEmpty|length|11"],
            'email'=>[
                'type'=>"string",
                'value'=>$this->input->post('email'), 
                'validation'=>"required|notEmpty|email|length|30"]
        ], $this);
        
        $isFailed = false;
        $message = "success";
        // getting role Id to be inserted in userDetails
        $parentRole = $this->RoleDetails->where(["role"=>"parent"])->read();
        $studentRole = $this->RoleDetails->where(["role"=>"student"])->read();

        $myRole = $studentRole;

        if(!empty($studentRole) && !empty($parentRole)) {
            
            if($this->inputs['userName'] !== $this->inputs['parentName']) {

                $studentDetails = $this->UserDetails->upsert(["username"=>$this->inputs['userName']], [
                    'firstName'=>$this->inputs['firstName'],
                    'lastName' => $this->inputs['lastName'],
                    'userName' =>$this->inputs['userName'],
                    'isDeleted' => 0
                ]);

                $parentDetails = $this->UserDetails->upsert(["username"=>$this->inputs['parentName']], [
                    'firstName'=> $this->inputs['parentName'],
                    'lastName' => $this->inputs['parentName'],
                    'userName' => $this->inputs['parentName'],
                    'isDeleted' => 0
                ]);
                
                // check if user is mapped else map it
                $mappingData = ['userId'=>$studentDetails[0]['_id'], 'roleId'=> $myRole[0]['_id'],'parentId'=> $parentDetails[0]['_id']];
                $mappingDetails = $this->Mapping->upsert($mappingData, $mappingData);

                // contact details for user
                $contactData = [ 'userId'=>$studentDetails[0]['_id'], 'phoneNumber'=>$this->inputs['phoneNumber'], 'email'=>$this->inputs['email']];
                $contactDetails = $this->ContactDetails->upsert($contactData, $contactData);

                //class updates mapping
                $classDetails = $this->ClassDetails->upsert(['standard'=>$this->inputs['class']],['standard'=>$this->inputs['class']]);

                $mappingData = ['userId'=>$studentDetails[0]['_id'], 'classId'=> $classDetails[0]['_id']];
                $mappingDetails = $this->Mapping->upsert($mappingData, $mappingData);

                // subject updates mapping
                $subjectsDetails = $this->SubjectsDetails->upsert(['subjectName'=>$this->inputs['subject']], ['subjectName'=>$this->inputs['subject']]);

                $mappingData = ['userId'=>$studentDetails[0]['_id'], 'subjectId'=> $subjectsDetails[0]['_id']];
                $mappingDetails = $this->Mapping->upsert($mappingData, $mappingData);

                $buildFilePath = $this->fileUploadfilter();

                if(!empty($buildFilePath)) {

                    for($i=0; $i<count($buildFilePath); $i++) {
                        //Upload the file into the temp dir
                        if(move_uploaded_file($buildFilePath[$i]['tmpFilePath'], $buildFilePath[$i]['newFilePath'])) {
                            //Handle other code here
                            $documentData = ['userId'=> $studentDetails[0]['_id'],'classId'=> $classDetails[0]['_id'],'subjectId'=> $subjectsDetails[0]['_id'],'documentName'=>$buildFilePath[$i]['documentName'],'documentUrl'=>$buildFilePath[$i]['documentUrl'],'documentType'=>$buildFilePath[$i]['documentType']];
                            $documentDetails = $this->DocumentDetails->insert($documentData);
                        } else {
                            $isFailed = true;
                            $message = 'file upload failed';
                        }
                    }
                } else {
                    
                    // parent and student can not be same;
                    $isFailed = true;
                    $message = 'file upload failed';
                }

            } else {
                // parent and student can not be same;
                $isFailed = true;
                $message = 'parent and student can not be same';
            }   
        } else {
            // role ids not found
            $isFailed = true;
            $message = 'role ids not found';
        }

        if($isFailed === true) {
            output($message,'failed','401',"failed","api");
        } else {
            output($message,'success','SS200',"success","api");
        }
    }

    public function fileUploadfilter()
    {
        //$files = array_filter($_FILES['upload']['name']); //something like that to be used before processing files.
        if(!empty($_FILES['document'])) {
                    // Count # of uploaded files in array
        $total = count($_FILES['document']['name']);
        

        // Loop through each file
        for( $i=0 ; $i < $total ; $i++ ) {

            //Get the temp file path
            $tmpFilePath = $_FILES['document']['tmp_name'][$i];
            $documentName = $_FILES['document']['name'][$i];

            //Make sure we have a file path
            if ($tmpFilePath != "") {
                
                $type = mime_content_type($tmpFilePath);

                inputs([
                    'document'=>[
                        'type'=>"file",
                        'value'=>$documentName, 
                        'validation'=>"required|notEmpty|ext|png,jpg,jpeg,pdf|length|50"]
                    ], $this);

                //Setup our new file path
                $newFilePath = FILE_PATH . $_FILES['document']['name'][$i];//"./uploadFiles/" . $_FILES['document']['name'][$i];
                
                $temparray['newFilePath'] = $newFilePath;
                $temparray['tmpFilePath'] = $tmpFilePath;
                $temparray['documentName'] = $this->inputs['document'];
                $temparray['documentUrl'] = $newFilePath;
                $temparray['documentRelativeUrl'] = API_PATH. '/Asset/'. $this->inputs['document'];
                $temparray['documentType'] = pathinfo($this->inputs['document'], PATHINFO_EXTENSION);

                $buildFilePath[] = $temparray;
            } 
        }

        $return =  $buildFilePath;
        } else {
            $return = [];
        }
        return $return;
    }
}
