<?php

require_once('model/model.php');
require_once('model/user.php');

class User_model extends Model
{

	// Store the user, if exists - return false otherwise return true
	public function store_user($user_data, $register = false)
	{
		$user_data = $this->sanitize_array($user_data);
		$user = $this->get_user_instance($user_data);
		if ($register)
		{
			if ($this->get_user_by_username($user->get_username()))
			{
				return false;
			}
		}
		
		$first_name 		= $user->get_first_name();
		$last_name 			= $user->get_last_name();
		$username 			= $user->get_username();
		$password 			= $this->create_password($user->get_username(), $user->get_password());
		$academic_year	 	= $user->get_academic_year();
		$term			 	= $user->get_term();
		$major			 	= $user->get_major();
		$level_code 		= $user->get_level_code();
		$degree		 		= $user->get_degree();
		$profile_photo 		= $user->get_profile_photo();
		$visibility			= $user->get_visibility();
		

		$query  = "INSERT INTO users VALUES('$first_name', '$last_name', '$username', '$password', '$academic_year', '$term', 
			'$major', '$level_code', '$degree', '$profile_photo', '$visibility')";
			$result = $this->conn->query($query);
			if (! $result) 
			{
				die ("Database access failed: " . $this->conn->error);
			}
		return true;
	}

	// Get all users
	public function get_users()
	{
		$query = "SELECT * FROM users";
		$result = $this->conn->query($query);
		$this->handle_db_result_error($result);

		return $this->get_users_from_table($result);
	}

	// Get all users sorted by surname - parameter order: ASC | DESC
	public function get_users_sort_by_name($order)
	{
		return $this->get_sorted_users('last_name', $order);
	}

	// Get all users sorted by graduation year - parameter order: ASC | DESC
	public function get_users_sort_by_academic_year($order)
	{
		return $this->get_sorted_users('academic_year', $order);
	}

	// Get all users sorted by given parameter and in given order: ASC | DESC
	private function get_sorted_users($param, $order)
	{
		$query = null;
		switch ($order)
		{
			case 'ASC':
				$query = "SELECT * FROM users ORDER BY $param";
				break;
			case 'DESC':
				$query = "SELECT * FROM users ORDER BY $param DESC";
				break;
		}
		
		if ($query)
		{
			$result = $this->conn->query($query);
			$this->handle_db_result_error($result);
			$users = $this->get_users_from_table($result);
			return $users;
		}
		return null;
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

	// Get user by username & password
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

	// Get table of users from a database and transform it to the array of User objects
	private function get_users_from_table($table)
	{
		$users = array();
		for ($i=0; $i<$table->num_rows; $i++)
		{
			$table->data_seek($i);
			$users[$i] = $this->get_user_instance($table->fetch_assoc());
		}
		return $users;
	}

	// Get a row from a database representing a user and transform it to User object
	private function get_user_instance($array)
	{
		$user = new User();
		$user->set_first_name(isset($array['first_name']) ? $array['first_name'] : null);
		$user->set_last_name(isset($array['last_name']) ? $array['last_name'] : null);
		$user->set_username(isset($array['username']) ? $array['username'] : null);
		$user->set_password(isset($array['password']) ? $array['password'] : null);
		$user->set_academic_year(isset($array['academic_year']) ? $array['academic_year'] : null);
		$user->set_term(isset($array['term']) ? $array['term'] : null);
		$user->set_major(isset($array['major']) ? $array['major'] : null);
		$user->set_level_code(isset($array['level_code']) ? $array['level_code'] : null);
		$user->set_degree(isset($array['degree']) ? $array['degree'] : null);
		$user->set_profile_photo(isset($array['profile_photo']) ? $array['profile_photo'] : null);
		$user->set_visibility(isset($array['visibility']) ? $array['visibility'] : 0);
		return $user;
	}

	// Create password, using ripemd128 hash and static salt
	private function create_password($username, $plain_password)
	{
		$salt = "%(*_Dw)#";
		return hash('ripemd128', $salt . $username . $plain_password);
	}
}

?>