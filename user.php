<?php
require_once('model/user_model.php');

if (isset($_GET['data']))
{
	switch ($_GET['data'])
	{
		case "user-list":
			$user_model = new User_model();
			$users = $user_model->get_users();
			header('Content-type: application/json');
			echo parse_users_to_json($users);
			break;
		default:
			header("HTTP/1.0 404 Not Found");
			die();
	}
}

function parse_users_to_json($users)
{
	$json_users = array();
	foreach($users as $user)
	{
		array_push($json_users, $user->to_json());
	}
	return json_encode($json_users);
}


?>