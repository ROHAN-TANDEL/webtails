<?php

// CREATE TABLE `students`.`SubjectsDetails` ( `_id` INT NOT NULL , `subjectName` VARCHAR(50) NULL , `_createdAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `_updatedAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`_id`), UNIQUE (`subjectName`)) ENGINE = InnoDB;
// INSERT INTO `SubjectsDetails` (`_id`, `subjectName`, `_createdAt`, `_updatedAt`) VALUES (NULL, 'endology', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'oncology', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

class SubjectsDetails extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $dataInputs = ['subjectName'];
    }

    public function read()
    {
        $query = $this->db->get(__CLASS__);
        return $query->result_array();   
    }

    public function readCursor($start=0, $limit=1)
    {
        $this->db->limit($limit, $start);        
        $this->read();        
    }

    public function where(array $where)
    {
        $this->db->where($where);
        return $this;
    }
}
