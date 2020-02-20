<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {

	/**
	 * Class constructor
	 *
	 * @link	https://github.com/bcit-ci/CodeIgniter/issues/5332
	 * @return	void
	 */
	public function __construct($class=false) {
		if($class !== false) {
			$this->class = $class;
		}
//		return $this;
	}

	/**
	 * __get magic
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string	$key
	 */
	public function __get($key)
	{
		// Debugging note:
		//	If you're here because you're getting an error message
		//	saying 'Undefined Property: system/core/Model.php', it's
		//	most likely a typo in your model code.
		return get_instance()->$key;
	}

	public function read()
    {
        $query = $this->db->get($this->class);
        return $query->result_array();
    }

    public function readCursor($start=0, $limit=1, $result=false)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get($this->class);
        if($result === true){
            return $query->result_array();   
        } else {
            return $this;
        }
    }

    public function limit($start=0, $limit=1)
    {
        $this->db->limit($limit, $start);
        return $this;        
    }

    public function where(array $where)
    {
        $this->db->where($where);
        return $this;
    }

    public function update(array $dataToUpdate, $result=false)
    {
		$value = $this->db->update($this->class, $dataToUpdate);
        if($result === true) {
			return $value->result_array();
		} else {
            return $this;
        }
    }

    public function delete(array $dataToUpdate, $result=false) {
		$value = $this->db->update($this->class, $dataToUpdate);
        if($result === true) {
			return $value->result_array();
		} else {
            return $this;
        }
    }

	public function insert_batch(array $dataToUpdate, $result=false)
    {
		$value =  $this->db->insert_batch($this->class, $dataToUpdate);
        if($result===true) {
			return $value->result_array();
		} else {
            return $this;
        }
	}

    public function insert(array $dataToUpdate, $result=false)
    {
		$value =  $this->db->insert($this->class, $dataToUpdate);
        if($result===true) {
			return $value->result_array();
		} else {
            return $this->where(["_id"=>$this->db->insert_id()])->read();
        }
	}

	public function upsert(array $cond, array $dataToUpdate, $result=false)
    {
		$data = $this->where($cond)->read();
		if(empty($data)) {
			$data = $this->insert($dataToUpdate, $result);
		}
		return $data;
	}
	
	public function where_in($key, array $dataToUpdate, $result=false)
	{
		$value = $this->db->where_in($key, $dataToUpdate);
		if($result===true) {
			return $value; 
        } else {
            return $this;
        }
	}

	public function where_not_in($key, array $dataToUpdate, $result=false)
	{
		$value = $this->db->where_not_in($key, $dataToUpdate);
		if($result===true) {
			return $value; 
        } else {
            return $this;
        }
	}

	public function distinct()
	{
		$this->db->distinct();
		return $this;
	}

}
