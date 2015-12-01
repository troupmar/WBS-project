<?php

require_once(__DIR__ . '/connection.php');

abstract class Model
{
	protected $conn;

	public function __construct() 
	{
		$connection = Connection::get_instance();
		$this->conn = $connection->get_connection();
	}

	public function sanitize_string($string)
	{
		$string = stripcslashes($string);
		$string = $this->conn->real_escape_string($string);
		return htmlentities($string);
	}
	
	public function sanitize_array($array) 
	{
		$sanitized_array = array();
		foreach($array as $key => $value)
		{
			$sanitized_array[$key] = $this->sanitize_string($value);
		}
		return $sanitized_array;
	}

	protected function handle_db_result_error($result)
	{
		if (! $result)
		{
			die ("Database access failed: " . $this->conn->error);
		}
	}

	// Get appropriate table and transform it to an array of appropriate objects
	protected function get_objects_from_table($table_rows)
	{
		$users = array();
		for ($i=0; $i<$table_rows->num_rows; $i++)
		{
			$table_rows->data_seek($i);
			$users[$i] = $this->get_object($table_rows->fetch_assoc());
		}
		return $users;
	}

	abstract protected function get_object($array);
}

?>