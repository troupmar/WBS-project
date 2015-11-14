<?php

require_once('login.php');
require_once('register.php');

if (isset($_GET['page']))
{
	switch ($_GET['page'])
	{
		case "login":
			$page = new Login();
			$page->render('Log in');
			break;
		case "register":
			$page = new Register();
			$page->render('Register');
			break;
		default:
			header("HTTP/1.0 404 Not Found");
			die();
	}
}

?>