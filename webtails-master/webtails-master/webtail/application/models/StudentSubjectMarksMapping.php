<?php
// INSERT INTO `StudentSubjectMarksMapping` (`_id`, `studentId`, `subjectId`, `marks`, `isDeleted`, `_createdAt`, `_updatedAt`) VALUES (NULL, '1', '2', '11', '0', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), (NULL, '2', '1', '111', '0', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

class StudentSubjectMarksMapping extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $dataInputs = ['studentId', 'subjectId', 'marks', 'isDeleted'];
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

    public function update(array $dataToUpdate)
    {
         return $this->db->update(__CLASS__, $dataToUpdate);
        //  return $this;
    }

    public function insert(array $dataToUpdate)
    {
        return $this->db->insert(__CLASS__, $dataToUpdate);
        // return $this;
    }

    public function where($where)
    {
        $this->db->where($where);
        return $this;
    }
}
