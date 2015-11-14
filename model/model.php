<?php

abstract class Model
{
	protected $conn;

	public function __construct($conn) 
	{
		$this->conn = $conn;
	}
	
	public function sanitize_string($string)
	{
		$string = stripcslashes($string);
		$string = $this->conn->real_escape_string($string);
		return htmlentities($string);
	}

}

?>