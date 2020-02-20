<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class StudentsDetailsController
 * Author: Rohan Tandel
 * API Versions: V1
 */
final class DocumentDetailsController extends CI_Controller {

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
        //         {"userId": 2,"classId":1, "subjectId": 1, "documentName":"as", "documentType": "png", "documentUrl":"/Asset/as.pgn"},
        //         {"userId": 2, "classId":1, "subjectId": 1, "documentName":"twos", "documentType": "png", "documentUrl":"/Asset/as.pgn"}
        //         ]
        // }
        inputs([
            'dataDetails'=>[
                        'type'=>"array",
                        'value'=>$this->input->post('dataDetails'), 
                        'validation'=>"required|notEmpty"]
        ], $this);

        if($this->DocumentDetails->insert_batch($this->inputs['dataDetails'])) {
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
