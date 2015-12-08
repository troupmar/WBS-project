<?php

require_once(__DIR__ . '/model/connection.php');

abstract class Template
{
	protected $conn;

	public function __construct() 
	{
		$connection = Connection::get_instance();
		$this->conn = $connection->get_connection();
	}

	public function render($title) 
	{
		echo "
			<html>
			 <head>
			  <title>$title</title>
			  ";
		foreach ($this->get_css_files() as $css_path)
		{
			echo "<link rel='stylesheet' type='text/css' href='./include/css/" . $css_path ."'>";
		}
		foreach ($this->get_js_files() as $js_path)
		{
			echo "<script src='./include/js/" . $js_path . "'></script>";
		}
		echo "
			 </head>
			 <body>
			  <ul class='navigation'>
			   <li class='main-logo'><a href='alumni.php'>Alumni.edu</a></li>
			   <li><a href=''>Store</a></li>
			   <li><a href='alumni.php?page=communicate'>Communicate</a></li>
			   <li><a href='alumni.php?page=register'>Register</a></li>
			   ";
			    if (isset($_SESSION['username']) && isset($_SESSION['password']))
			    {
			    	$username = $_SESSION['username'];
					echo "
				   <li>$username</li>
				   <li><a href='alumni.php?page=edit&username=$username'>Edit profile</a></li>
				   <li><a href='alumni.php?page=logout'>Log out</a></li>
				   ";
			    } 
			    else
				{
					echo "
				   <li><a href='alumni.php?page=login'>Log in</a></li>
				   ";
				}
				echo "
			  </ul>
			  <div class='content'>
			  ";
		 $this->render_body();
		 echo "
		 	  </div>
			 </body>
			</html>
			";
	}

	abstract protected function render_body();

	protected function get_css_files() 
	{
		return array();
	}

	protected function get_js_files()
	{
		return array('jquery1.11.3.min.js');
	}

	protected function redirect_to_main_page()
	{
		// redirect to the main page
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$page = 'alumni.php'; 
		header("Location: http://$host$uri/$page");
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
}

?>