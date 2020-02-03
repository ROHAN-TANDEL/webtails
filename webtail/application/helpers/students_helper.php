
<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('readByJoins'))
{
    function readByJoins($thisClass)
    {
        if(is_array($thisClass->where)) {
            $where = $thisClass->where + ["isDeleted"=>0];
        } else {
            $where = ["isDeleted"=>0];
        }

        $group = null;

        $joinsArray = [
                [
                    'joinType'=> 'right',
                    'table'=>'StudentsDetails',
                    'tableJoin'=>'StudentsDetails._id=StudentSubjectMarksMapping.studentId'
            ],
                [
                    'joinType'=> 'inner',
                    'table'=>'SubjectsDetails',
                    'tableJoin'=>'SubjectsDetails._id=StudentSubjectMarksMapping.subjectId'
                ]
            ];

        return $result_set = joins(
                                '*, StudentSubjectMarksMapping._id as _id','StudentSubjectMarksMapping',
                                'result', $joinsArray, $where, 
                                $group,
                                $thisClass->cursor
                            );
    }
}