<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('joins'))
{
    function joins(
        $field=NULL, $table=NULL, $type=NULL, $joinsArray=NULL,
        $where=NULL, $group=NULL, $limit=NULL, $like=NULL
    )
    {

        $CI = get_instance();
        $CI->db->select($field);
        $CI->db->from($table);
        
        if(!empty($joinsArray)) {
        foreach($joinsArray as $joinRow):
            if(!empty($joinRow['joinType'])) {
                $CI->db->join($joinRow['table'],$joinRow['tableJoin'],$joinRow['joinType']);
            } else { 
                $CI->db->join($joinRow['table'],$joinRow['tableJoin']);
            }  
        endforeach;
        }

        if(!empty($where)) {  
            $CI->db->where($where);   
        }
        if(!empty($like))   {  
            $CI->db->like($like);   
        }
        if(!empty($group))  {  
            $CI->db->GROUP_BY($group); 
        }
        
        if(!empty($limit))  {
            $CI->db->limit($limit['limit'],$limit['start']); 
        }

        $result =    $CI->db->get();
        if($type == "result") {
            $return = $result->result_array();
        }

        if($type == 'row')  {   
            $return = $result->row();   
        }
        return $return;
    }
}