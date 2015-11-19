<?php

require_once('model.php');
require_once('user.php');

class User_model extends Model
{

	// Store the user, if exists - return false otherwise return true
	public function store_user($user_data)
	{
		$user = $this->get_user_instance($user_data);
		if ($this->get_user_by_username($user->get_username()))
		{
			return false;
		}
		else
		{
			$first_name 		= $user->get_first_name();
			$last_name 			= $user->get_last_name();
			$username 			= $user->get_username();
			$password 			= $this->create_password($user->get_username(), $user->get_password());
			$d_o_b 				= $user->get_d_o_b();
			$graduation_year 	= $user->get_graduation_year();
			$profile_photo 		= $user->get_profile_photo();
			$about 				= $user->get_about();

			$query  = "INSERT INTO users VALUES('$first_name', '$last_name', '$username', '$password', '$graduation_year', '$d_o_b', '$profile_photo', '$about')";
  			$result = $this->conn->query($query);
  			if (! $result) 
  			{
  				die ("Database access failed: " . $this->conn->error);
  			}
  			return true;
  		}
	}

	// Get all users
	public function get_users()
	{
		$query = "SELECT * FROM users";
		$result = $this->conn->query($query);
		if (! $result)
		{
			die ("Database access failed: " . $this->conn->error);
		}
		$users = array();
		for ($i=0; $i<$result->num_rows; $i++)
		{
			$result->data_seek($i);
			$users[$i] = get_user_instance($result->fetch_assoc());
		}
		return $users;

	}


	// Get user by username
	public function get_user_by_username($username)
	{
		$username = $this->sanitize_string($username);
		$query = "SELECT * FROM users WHERE username='$username' LIMIT 1";

		$result = $this->conn->query($query);
		if (! $result) 
		{
			die ("Database access failed: " . $this->conn->error);
		}

		if ($result->num_rows > 0)
		{
			$result->data_seek(0);
			return $this->get_user_instance($result->fetch_assoc());
		}
		else
		{
			return null;
		}
	}

	private function get_user_instance($array)
	{
		$user = new User();
		$user->set_first_name(isset($array['first-name']) ? $this->sanitize_string($array['first-name']) : null);
		$user->set_last_name(isset($array['last-name']) ? $this->sanitize_string($array['last-name']) : null);
		$user->set_username(isset($array['username']) ? $this->sanitize_string($array['username']) : null);
		$user->set_password(isset($array['password']) ? $this->sanitize_string($array['password']) : null);
		$user->set_d_o_b(isset($array['d-o-b']) ? $this->sanitize_string($array['d-o-b']) : null);
		$user->set_graduation_year(isset($array['graduation-year']) ? $this->sanitize_string($array['graduation-year']) : null);
		$user->set_profile_photo(isset($array['profile-photo']) ? $this->sanitize_string($array['profile-photo']) : null);
		$user->set_about(isset($array['about']) ? $this->sanitize_string($array['about']) : null);
		return $user;
	}

	private function create_password($username, $plain_password)
	{
		$salt = "%(*_Dw)#";
		return hash('ripemd128', $salt . $username . $plain_password);
	}
}

?>