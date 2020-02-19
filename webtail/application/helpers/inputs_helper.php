<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('inputs'))
{
    function inputs(array $data, $thisClass, $isFailed = false)
    {
        foreach($data as $keyName=>$KeyDetails)
        {
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
                            $isFailed = true; 
                        }
                    } else {
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
                            $isFailed = true; 
                        }
                    } else {
                        $isFailed = true;
                    }
                break;
                case 'array':
                    if(is_array($KeyDetails['value'])) {
                        $thisClass->inputs[$keyName] = (array)$KeyDetails['value'];
                    } else {    
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
                        $isFailed = true;
                    }
                default:
            }
        }
        if($isFailed === true) {
            $output = 'error in paramenter not matchinng min req';
            $thisClass->output->set_output('','faiiled','401','error in paramenter not matchinng min req');

        } 
        if(!empty($d['validation'])) {
            
            $find = explode('|',$d['validation']);
            
            if(in_array('required', $find)) {
                
                if(!isset($d['value'])) {
                $isFailed = true;
                $message = "value not set";
                }
            }

            if(in_array('notEmpty',$find)) {
                if(empty($d['value'])){
                $isFailed = true;
                $message = "value empty";
                } 
            }

            if($key = array_search('max',$find))  {
                if( $d['value'] > $find[$key+1]) {
                $isFailed = true;
                $message = "value is more than the limit";
                }
            }
   
            if($key = array_search('min',$find))  {
                if( $d['value'] < $find[$key+1]) {
                $isFailed = true;
                $message = "value is less than the limit";
                } else {
                    echo "fale";
                }
            }

            if($key = array_search('only',$find))  {
                $onlyVals = explode(",", $find[$key+1]);                    
                if(!in_array($d['value'], $onlyVals)) {
                $isFailed = true;
                $message = "value is not matching defaults";                          
                }
            }
        }
        if($isFailed === true) {
            $output = 'error in paramenter not matchinng min req';
            $thisClass->output->set_output('','faiiled','401',$message);
        }
    }
}
