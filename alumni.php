<?php

ob_start();
session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once('main.php');
require_once('profile.php');
require_once('login.php');
require_once('register.php');
require_once('communicate.php');

if (isset($_GET['page']))
{
	switch ($_GET['page'])
	{
		case "profile":
			if (! isset($_GET['username']))
			{
				header("HTTP/1.0 404 Not Found");
				die();
			}
			$page = new Profile($_GET['username']);
			$page->render('Profile');
			break;
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
		case "communicate":
			$page = new Communicate();
			$page->render('Communicate');
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