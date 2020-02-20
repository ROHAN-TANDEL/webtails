<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('inputs'))
{
    function inputs(array $data, $thisClass, $isFailed = false)
    {
        $CI = get_instance();
        $CI->load->helper(['output','Exit']);
        $message = '';
        foreach($data as $keyName=>$KeyDetails)
        {
            $find = explode('|',$KeyDetails['validation']);
                
            if(in_array('required', $find)) {
                if(!isset($KeyDetails['value'])) {
                $isFailed = true;
                $message = " value not set";
                }
            }

            if(in_array('notEmpty',$find)) {
                if(empty($KeyDetails['value'])){
                $isFailed = true;
                $message = $message . " value empty";
                } 
            }

            if($key = array_search('max',$find))  {
                if( $KeyDetails['value'] > $find[$key+1]) {
                $isFailed = true;
                $message = $message . " value is more than the limit";
                }
            }
   
            if($key = array_search('min',$find))  {
                if( $KeyDetails['value'] < $find[$key+1]) {
                    $isFailed = true;
                    $message = $message . " value is less than the limit";
                }
            }

            if($key = array_search('ext',$find))  {
                $onlyVals = explode(",", $find[$key+1]);
                $ext = pathinfo($KeyDetails['value'], PATHINFO_EXTENSION);
                if(!in_array($ext, $onlyVals)) {
                $isFailed = true;
                $message = $message . " mime is not matching defaults ";
                }
            }

            if($key = array_search('type',$find))  {
                $onlyVals = explode(",", $find[$key+1]);
                if(!in_array($KeyDetails['value'], $onlyVals)) {
                $isFailed = true;
                $message = $message . " type is not matching defaults ";
                }
            }

            if($key = array_search('only',$find))  {
                $onlyVals = explode(",", $find[$key+1]);
                if(!in_array($KeyDetails['value'], $onlyVals)) {
                $isFailed = true;
                $message = $message . " value is not matching defaults";
                }
            }

            if($key = array_search('length',$find))  {
                $onlyVals = explode(",", $find[$key+1]);
                $c = (int)$find[$key+1];

                if($KeyDetails['type'] == 'int' || $KeyDetails['type'] == 'string') {
                
                $va = (int)strlen($KeyDetails['value']);
                    if($va > $c) {
                        $isFailed = true;
                        $message = $message . " length is not matching min req please set or below". $find[$key+1];
                    }
                } elseif($KeyDetails['type'] == 'array') {
                    $array = (array)$KeyDetails['value'];
                    if(count($array) > $c) {
                        $isFailed = true;
                        $message = $message . " length is not matching min req please set or below". $find[$key+1];
                    }
                } else {
                    $va = (int)strlen($KeyDetails['value']);
                    if($va > $c) {
                        $isFailed = true;
                        $message = $message . " length is not matching min req please set or below". $find[$key+1];
                    }   
                }
            }

            if($key = array_search('email',$find))  {
                if(0 && !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $KeyDetails['value'])){
                    $isFailed = true;
                    $message = $message . " value is not matching defaults sample water@water.water";                          
                }
            } elseif($key = array_search('file',$find)) {

            } else {
                #echo "avoid";
            }

            if($isFailed === true) {
                $CI->error=true;
                 output($keyName . $message,'failed','401',"failed","api");
                 failed();

            } elseif(!empty($KeyDetails['validation'])) {
                switch ($KeyDetails['type']) {
                    case 'int':
                        $value = (int)$KeyDetails['value'];
                        if(is_int($value) && 
                            filter_var($value, FILTER_VALIDATE_INT) === 0 || 
                            !filter_var($value, FILTER_VALIDATE_INT) === false) {
                            $value = (string)trim($value);
                            $num_length = strlen($value);
                            if($num_length < 16) {
                                $thisClass->inputs[$keyName] = (int)$value;
                            } else {
                                $message = "not an integer";
                                $isFailed = true; 
                            }
                        } else {
                            $message = "not an integer";
                            $isFailed = true;
                        }
                    break;
                    case 'string':
                        if(is_string($KeyDetails['value'])) {
                            $value = stripslashes(trim($KeyDetails['value']));
                            $num_length = strlen($value);
                            if($num_length < 257) {
                                $thisClass->inputs[$keyName] = $value;
                            } else {
                                $message = "not a string";
                                $isFailed = true; 
                            }
                        } else {
                            $message = "not a string";
                            $isFailed = true;
                        }
                    break;
                    case 'array':
                        if(is_array($KeyDetails['value'])) {
                            $thisClass->inputs[$keyName] = (array)$KeyDetails['value'];
                        } else {
                            $message = $KeyDetails[$keyName] . "not an array";
                            $isFailed = true; 
                        }
                    break;
                    case 'date':
                        $thisClass->inputs[$keyName] = $KeyDetails['value'];
                    break;
                    case 'boolean':
                        $value = (boolean) $KeyDetails['value'];
                        if(filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
                            $thisClass->inputs[$keyName] = $value;
                        } else {
                            $message = "not a boolean";
                            $isFailed = true;
                        }
                    break;
                    case 'file':
                        $thisClass->inputs[$keyName] = $KeyDetails['value'];
                    default:
                }

            } else {
                if($isFailed === true) {
                    output($message,'faiiled','401',"failed","api");
                    failed();
                }
            }
        }
    }
}
