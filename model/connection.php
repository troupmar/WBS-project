<?php

require_once(__DIR__ .'/database_credentials.php');

class Connection
{
	private static $instance;
	private $conn;

	// Constructor connects the database
	private function __construct()
	{
		$creds = get_local_database_credentials();
		//$creds = get_server_database_credentials();
		$this->conn = new mysqli($creds['host'], $creds['username'], 
			$creds['password'], $creds['database']);
  		if ($this->conn->connect_error) 
  		{
  			die($this->conn->connect_error);
  		}
	}

	public static function get_instance()
    {
        if (static::$instance === null) {
            static::$instance = new Connection();
        }
        return static::$instance;
    }

    public function get_connection()
	{
		return $this->conn;
	}
}

?>