<?php

// CREATE TABLE `students`.`StudentsDetails` ( `id` INT(10) NOT NULL AUTO_INCREMENT , `studentName` VARCHAR(50) NOT NULL , `_createdAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `_updatedAt` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`), UNIQUE (`studentName`)) ENGINE = InnoDB;
// INSERT INTO `StudentsDetails` (`id`, `studentName`, `_createdAt`, `_updatedAt`) VALUES (NULL, 'Jack.Sparrow', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, 'Jack.Reacher', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)
// ALTER TABLE `StudentsDetails` CHANGE `id` `_id` INT(10) NOT NULL AUTO_INCREMENT;

class StudentsDetails extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $dataInputs = ['studentName'];
    }

    public function read()
    {
        $query = $this->db->get(__CLASS__);
        return $query->result_array();
    }

    public function readCursor($start=0, $limit=1)
    {
        $query = $this->db->limit($limit, $start);        
        $query = $this->db->get(__CLASS__);
        return $query->result_array();   
    }

    public function where(array $where)
    {
        $this->db->where($where);
        return $this;
    }

}
