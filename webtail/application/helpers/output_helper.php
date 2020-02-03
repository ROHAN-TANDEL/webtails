<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('output'))
{
    function output($output, $status='success', $statusCode='200', $message='', $returnType='api')
    {
        $CI = get_instance();
        switch($returnType) {
            case 'internal':
                return ['output'=> $output, 'status'=>$status, 'code'=>$statusCode, 'message'=>$message];
            break;
            case 'browser':
                $CI->output->set_output($output, $status, $statusCode, $message);
            break;
            case 'void':
            break;
            case 'api':
                $CI->output->set_content_type('application/json')
                            ->set_status_header(200)
                            ->set_output(json_encode($output), $status, $statusCode, $message);
            break;
            default:
            $CI->output->set_output($output, $status, $statusCode, $message);
        }
    }
}