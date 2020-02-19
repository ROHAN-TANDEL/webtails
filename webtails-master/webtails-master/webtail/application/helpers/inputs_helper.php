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
    }
}