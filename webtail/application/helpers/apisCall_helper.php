<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('externalAPIs'))
{
  
// @TODO - shift to helper
    function externalAPIs(string $apiName, array $data = [])
    {
        $CI = get_instance($apiName);
        $CI->load->model($apiName);
        return $CI->$apiName
                    ->where($data)
                    ->read();
    }
}

if ( ! function_exists('externalAPI'))
{

    function externalAPI($cName, $methodName, $params=[])
    {
        $CI = get_instance($cName);
        $data = $CI->$methodName(111,0);
        print_r($data);
    }
}

function listMapCursor()
{
    echo "call helper";die;
    echo "asdasd -- 1";
        exit(0);
        inputs([
                'limit'=>['type'=>'int','value'=>$limit],
                'skip'=>['type'=>'int','value'=>$skip]
        ], $this);

        $this->where = ['isDeleted' => 0];
        $this->cursor =  ['limit'=>$this->inputs['limit'],'start'=>$this->inputs['skip']];
        output(readByJoins($this),'success','SM001');
}