<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class RoleDetailsController
 * Author: Rohan Tandel
 * API Versions: V1
 */
final class RoleDetailsController extends CI_Controller {

    /**
     * construct function
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['UserDetails','RoleDetails','ContactDetails', 'DocumentDetails','ClassDetails']);
        $this->load->helper(['inputs', 'joins','students','output','Exit_helper']);
    }

    public function insert($dataDetails=[])
    {
        
        // API req
        inputs([
            'dataDetails'=>[
                        'type'=>"array",
                        'value'=>$this->input->post('dataDetails'), 
                        'validation'=>"required|notEmpty"]
        ], $this);

        if($this->RoleDetails->insert_batch($this->inputs['dataDetails'])) {
            return output("true","success","SS200", "document inserstion successful","api");
        } else {
            return output("true","failed","SS401", "document inserstion not successful","api");;
        }
    }

    public function read()
    {
        inputs([
            'valueList'=>[
                        'type'=>"array",
                        'value'=>$this->input->post('valueList'), 
                        'validation'=>"required|notEmpty"],
            'key'=>[
                'type'=>"string",
                'value'=>$this->input->post('key'), 
                'validation'=>"required|notEmpty"],
        ], $this);
        $state = $this->RoleDetails->where_in($this->inputs['key'], $this->inputs['valueList'])->read();
        return output($state, "success","SS200","api call success","");
    }

}
