<?php

ob_start();
session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once('main.php');
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
		case "logout":
			$_SESSION = array();
			setcookie(session_name(), '', time() - 2592000, '/');
			session_destroy();
			$page = new Main();
			$page->render('alumni.php');
			break;
		default:
			header("HTTP/1.0 404 Not Found");
			die();
	}
}
else
{
	$page = new Main();
	$page->render('alumni.php');
}

?>