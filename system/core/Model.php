<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {

	/**
	 * Constructor
	 *
	 * @access public
	 */
	function __construct()
	{
		log_message('debug', "Model Class Initialized");
	}

	/**
	 * __get
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string
	 * @access private
	 */
	function __get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}

	function set($array){
		foreach ($array as $key => $value) {
			$this->{$key} = $value;
		}
	}

	function get_list($limit = false, $order = "desc", $where = false){
		$this->db->order_by("id", $order);
		if($limit != false){
			$this->db->limit($limit);
		}
		
		if($where != false){
			$this->db->where($where);
		}

		return $this->db->get(get_class($this))->result_array();

	}

	function update($array){
		if($this->id == ""){
			return false;
		}
		$this->db->where("id", $this->id);
		$this->db->update(get_class($this), $array);
		return $this->db->affected_rows();
	}

	function get_item($where = false){
		if($where == false){
			if($this->id == ""){
				return false;
			}
			$this->db->where("id", $this->id);	
		}else{
			$this->db->where($where);
		}

		$sql = $this->db->get(get_class($this))->result_array();
		return $sql[0];
	}
}
// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */