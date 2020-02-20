<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class ContactDetailsController
 * Author: Rohan Tandel
 * API Versions: V1
 */
final class ContactDetailsController extends CI_Controller {

    /**
     * construct function
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function insert($dataDetails=[])
    {
        
        // API req
        // {
        //     "dataDetails": [
        //         {"userId": 2,"email":"as@dd.com", "phoneNumber": "192468161", "address":"xyz"},
        //         {"userId": 2,"email":"as@dd.com", "phoneNumber": "192468161",  "address":"xyz"}
        //         ]
        // }
        inputs([
            'dataDetails'=>[
                        'type'=>"array",
                        'value'=>$this->input->post('dataDetails'), 
                        'validation'=>"required|notEmpty"]
        ], $this);

        if($this->ContactDetails->insert_batch($this->inputs['dataDetails'])) {
            return output("true","success","SS200", "document inserstion successful","api");
        } else {
            return output("true","failed","SS401", "document inserstion not successful","api");;
        }
    }

    public function read()
    {        
        // API call req
        // {
        //     "userIdList": [1],
        //     "key":"userId"
        // }
        inputs([
            'userIdList'=>[
                        'type'=>"array",
                        'value'=>$this->input->post('userIdList'), 
                        'validation'=>"required|notEmpty"],
            'key'=>[
                'type'=>"string",
                'value'=>$this->input->post('key'), 
                'validation'=>"required|notEmpty"],
        ], $this);
        $state = $this->DocumentDetails->where_in($this->inputs['key'], $this->inputs['userIdList'])->read();
        return output($state, "success","SS200","api call success","");
    }
}
