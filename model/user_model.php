<?php

require_once('model/model.php');
require_once('model/user.php');

class User_model extends Model
{

	// Store the user, if exists - return false otherwise return true
	public function store_user($user_data)
	{
		$user_data = $this->sanitize_array($user_data);
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
			$users[$i] = $this->get_user_instance($result->fetch_assoc());
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

	public function get_user_by_username_and_password($username, $password)
	{
		$user = $this->get_user_by_username($username);
		if (! $user)
		{
			return null;
		}
		if ($this->create_password($user->get_username(), $password) === $user->get_password())
		{
			return $user;
		}
		return null;
	}

	private function get_user_instance($array)
	{
		$user = new User();
		$user->set_first_name(isset($array['first_name']) ? $array['first_name'] : null);
		$user->set_last_name(isset($array['last_name']) ? $array['last_name'] : null);
		$user->set_username(isset($array['username']) ? $array['username'] : null);
		$user->set_password(isset($array['password']) ? $array['password'] : null);
		$user->set_d_o_b(isset($array['d_o_b']) ? $array['d_o_b'] : null);
		$user->set_graduation_year(isset($array['graduation_year']) ? $array['graduation_year'] : null);
		$user->set_profile_photo(isset($array['profile_photo']) ? $array['profile_photo'] : null);
		$user->set_about(isset($array['about']) ? $array['about'] : null);
		return $user;
	}

	private function create_password($username, $plain_password)
	{
		$salt = "%(*_Dw)#";
		return hash('ripemd128', $salt . $username . $plain_password);
	}
}

?>