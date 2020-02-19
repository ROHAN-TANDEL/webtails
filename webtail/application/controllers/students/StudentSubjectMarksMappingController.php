<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// CREATE TABLE `students`.`StudentSubjectMarksMapping` ( `_id` INT NOT NULL AUTO_INCREMENT , `studentId` INT NULL DEFAULT NULL , `subjectId` INT NULL DEFAULT NULL , `marks` INT NULL DEFAULT NULL , PRIMARY KEY (`_id`), INDEX `studentId` (`studentId`), INDEX `subjectid` (`subjectId`), INDEX `marks` (`marks`)) ENGINE = InnoDB;
// ALTER TABLE `StudentSubjectMarksMapping` ADD `isDeleted` BOOLEAN NOT NULL DEFAULT FALSE AFTER `marks`, ADD `_createdAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `isDeleted`, ADD `_updatedAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `_createdAt`;

final class StudentSubjectMarksMappingController extends CI_Controller {
    
    /**
     * $where variable
     *
     * @var array
     */
    public $where;
    
    /**
     * $cursor variable
     *
     * @var array
     */
    public $cursor;

    /**
     * $inputs variable
     *
     * @var array
     */    
    public $inputs;
   
    /**
     * construct function
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('StudentSubjectMarksMapping');

            $output = $this->StudentSubjectMarksMapping
        ->where(['_id'=>1])
        ->update(['isDeleted'=>1]);


        $this->load->helper( ['inputs', 'joins','students','output','apisCall'] );
        $this->cursor = ['limit'=>2000,'start'=>0];
        return $this;
    }

    /**
     * deletedList function
     *  to get list of deleted mappings
     * @return void
     */
    public function deletedList()
    {
        $this->where = ['isDeleted'=>1]; 
        output(readByJoins($this),'success','SM001');
    }

    /**
     * DeleteMapById 
     *  to delete mapping of student subject and marks soft delete
     *  changes flag isDelete to true
     *
     * @param string $id -  map id to be soft deleted
     * @return void
     */
    public function deleteMapById(string $id)
    {
        inputs([
            'id'=>['type'=>'int','value'=>$id]
        ],$this);

        $output = $this->StudentSubjectMarksMapping
                        ->where(['_id'=>$id])
                        ->update(['isDeleted'=>1]);

        $status = 'success';
        $code = 'SM001';
        if($output === true) {
            $message = 'data deleted';
        } else {
            $message = 'data not deleted';
        }

        $output = [ [ 'id' => $id ] ];
        output($output, $status, $code, $message);
    }

    /**
     * specificMapById function
     *  to get map details by its id
     * @param string $id - map id
     * @return void
     */
    public function specificMapById(string $id)
    {
        inputs([
            'id'=>['type'=>'int','value'=>$id, 'validation'=> 'required|unique|max:10000|min:0' ]
        ],$this);

        $this->where = ['isDeleted'=>0, 'StudentSubjectMarksMapping._id'=>$this->inputs['id']];
        output(readByJoins($this),'success','SM001');
    }

    /**
     * listCursor function
     *  to list map data using cursor
     *  reads data for studentsubjectMarksmapping  
     *  by unit blocks using limit and and start 
     *
     * @param string $limit - total docs/row to be returned 
     * @param string $skip - start of doc/row number from where it should return
     * 
     * @return array
     */
    public function listMapCursor($limit, $skip, $callType='browser')
    {
        inputs([
                'limit'=>['type'=>'int','value'=>$limit],
                'skip'=>['type'=>'int','value'=>$skip]
        ], $this);

        $this->where = ['isDeleted' => 0];
        $this->cursor =  ['limit'=>$this->inputs['limit'],'start'=>$this->inputs['skip']];
        return output(readByJoins($this),'success','SM001','',$callType);
    }

    /**
     * UpdateOrCreateMap
     * update mapping table with marks for student and subject specific  
     * else inserts a new record
     * get student details and subject details
     *
     * @param string $studentName
     * @param string $subjectName
     * @param string $marks
     * @return void
     */
    public function UpdateOrCreateMap(string $studentName, string $subjectName, string $marks)
    {
        inputs([
            'studentName'=>['type'=>'string','value'=>$studentName],
            'subjectName'=>['type'=>'string','value'=>$subjectName],
            'marks'=>['type'=>'int','value'=>$marks]
        ],$this);

        $status = 'success';
        $code = 'SM001';
        
        $student = externalAPIs('StudentsDetails', ['studentName' => $studentName]);
        $subject = externalAPIs('SubjectsDetails', ['subjectName' => $subjectName]);

        if(isset($student[0]['_id']) && isset($subject[0]['_id'])) {

            $marksMap = $this->StudentSubjectMarksMapping
                        ->where(['isDeleted'=>0, 'studentId' => (int)$student[0]['_id'], 'subjectId' => (int)$subject[0]['_id']])
                        ->read();

            if(isset($marksMap[0]['_id'])) {

                $marksMap[0]['marks'] = $marksMap[0]['marks'] + $marks;
                
                $output = $this->StudentSubjectMarksMapping
                                ->where(['_id'=>$marksMap[0]['_id']])
                                ->update($marksMap[0]);

                if($output === true) {
                    $message = 'data updated';
                    $code = 'SM001';       
                } else {
                    $status = 'failed';
                    $message = 'data not updated';
                    $code = 'SM002';
                }

            } else {
                $data = [
                        'studentId' => (int)$student[0]['_id'], 
                        'subjectId' => (int)$subject[0]['_id'],
                        'marks' => (int) $marks
                ];
                $output = $this->StudentSubjectMarksMapping
                               ->insert($data);
                if($output === true) {
                    $message = 'data inserted';
                    $code = 'SM001';
        
                } else {
                    $status = 'failed';
                    $message = 'data not updated';
                    $code = 'SM002';
                }
            }
        } else {
            $output = [];
            $status = 'failed';
            $message = 'data not updated';
            $code = 'SM002';
        }
        output($output,$status,$code,$message);
    }
}
