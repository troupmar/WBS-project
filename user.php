<?php
require_once('model/user_model.php');

if (isset($_GET['data']))
{
	switch ($_GET['data'])
	{
		case "users":
			$user_model = new User_model();
			$users = $user_model->get_users();
			header('Content-type: application/json');
			echo parse_users_to_json($users);
			break;
		case "users-sorted-by-last-name":
			if (isset($_GET['order']))
			{
				$user_model = new User_model();
				$users = $user_model->get_users_sorted_by_last_name($_GET['order']);
				header('Content-type: application/json');
				echo parse_users_to_json($users);
			}
			break;
		case "users-sorted-by-academic-year":
			if (isset($_GET['order']))
			{
				$user_model = new User_model();
				$users = $user_model->get_users_sorted_by_academic_year($_GET['order']);
				header('Content-type: application/json');
				echo parse_users_to_json($users);
			}
			break;
		case "users-filtered-by-first-name":
			if (isset($_GET['filter'])) 
			{
				$user_model = new User_model();
				$users = $user_model->get_users_filtered_by_first_name($_GET['filter']);
				header('Content-type: application/json');
				echo parse_users_to_json($users);
			}
			break;
		case "users-filtered-by-last-name":
			if (isset($_GET['filter'])) 
			{
				$user_model = new User_model();
				$users = $user_model->get_users_filtered_by_last_name($_GET['filter']);
				header('Content-type: application/json');
				echo parse_users_to_json($users);
			}
			break;
		case "users-filtered-by-academic-year":
			if (isset($_GET['filter'])) 
			{
				$user_model = new User_model();
				$users = $user_model->get_users_filtered_by_academic_year($_GET['filter']);
				header('Content-type: application/json');
				echo parse_users_to_json($users);
			}
			break;
		default:
			header("HTTP/1.0 404 Not Found");
			die();
	}
}

function parse_users_to_json($users)
{
	if ($users)
	{
		$json_users = array();
		foreach($users as $user)
		{
			array_push($json_users, $user->to_json());
		}
		return json_encode($json_users);
	}
	return null;
}


?>