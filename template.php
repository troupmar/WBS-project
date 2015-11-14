<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

abstract class Template
{
	public function __construct() 
	{
		ob_start();
		session_start();

	}

	public function render($title) 
	{
		echo "
			<html>
			 <head>
			  <title>$title</title>
			 </head>
			 <body>
			  <ul class='navigation'>
			   <li class='main-logo'><a href=''>Alumni.edu</a></li>
			   <li><a href=''>Store</a></li>
			   <li><a href=''>Edit profile</a></li>
			   <li><a href=''>Communicate</a></li>
			   ";
			   if (isset($_POST['username']) && isset($_POST['password']))
			   {
				   	echo "
				   <li><a href=''>Register</a></li>
				   <li><a href=''>Log in</a></li>
				   ";
				} 
				else
				{
					echo "
				   <li><a href=''>Log out</a></li>
				   ";
				}
				echo "
			  </ul>
			  <div class='content'>
			  ";
		 $this->renderBody();
		 echo "
		 	  </div>
			 </body>
			</html>
			";
	}

	abstract protected function renderBody();
}

?>