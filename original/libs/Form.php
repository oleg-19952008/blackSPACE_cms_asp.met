<?php

/**
 *
 * - Fill out a form
 * - POST to PHP
 * - Sanitize
 * - Validate
 * - Return Data
 * - Write to Database
 * 
 */

require "Form/Val.php";

class Form
{
	

	/** The imediately posted item - @var array $_currentItem */
	private $_currentItem = null;

	/** Store the posted data - @var array $_postData */
	private $_postData = array();

	/** The validator object - @var object $_postData */
	private $_val = array();

	/** Holds the current forms errors - @var array $_error */
	private $_error = array();

	/** 
	* The constructor - Instantaniese the validator
	*/
	function __construct()  
	{
		$this->_val = new Val();
	}

	
	public function convertToNumericEntities($string) {
	    $convmap = array(0x80, 0x10ffff, 0, 0xffffff);
	    return mb_encode_numericentity($string, $convmap, "UTF-8");
	}

	/**
	 * post - This is to run $_POST
	 *
	 * @param string $field - The html fieldname to post
	 */

	public function post($field)
	{
		$this->_postData[$field] = $this->convertToNumericEntities(htmlentities($_POST[$field]));
		$this->_currentItem = $field;
		return $this;
	}


	/**
	 * fetch - Return the posted data
	 * 
	 * @param  mixed $fieldName
	 * @return mixed string or array
	 */
	public function fetch($fieldName = false)
	{
		if($fieldName)
		{
			if (isset($this->_postData[$fieldName]))
			{
				return $this->_postData[$fieldName];
			}
			else
			{
				return false;
			}
		}
		else 
		{
			return $this->_postData;
		}

	}

	/**
	 * val - This is to validate
	 *
	 * @param string $typeofValidator A method from the Form/Val class
	 * @param string $arg A property to validate against
	 */
	public function val($typeofValidator, $arg = null)
	{
		if ($arg == null) 
		{
			$error = $this->_val->{$typeofValidator}($this->_postData[$this->_currentItem]);
		}
		else
		{
			$error = $this->_val->{$typeofValidator}($this->_postData[$this->_currentItem], $arg);
		}

		if ($error) {
			$this->_error[$this->_currentItem] = $error;
		}

		return $this;
	}

	/**
	 * submit - Handles the form, and throws an exception upon error.
	 *
	 * @return boolean
	 *
	 * @throws Exception
	 */
	public function submit()
	{
		if (empty($this->_error))
		{
			return true;
		}
		else
		{
			$str = json_encode($this->_error);
			throw new Exception($str);
		}
	}
}

?>