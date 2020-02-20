<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('exitCall'))
{
    function exitCall($Int=0)
    {
        exit($Int);
    }
}