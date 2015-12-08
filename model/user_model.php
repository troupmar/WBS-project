<?php


require_once(__DIR__ . '/model.php');
require_once(__DIR__ . '/user.php');

class User_model extends Model
{

	// Store the user, if exists - return false otherwise return true
	public function store_user($user, $register = false, $import = false, $update = false)
	{
		if ($register)
		{
			if ($this->get_user_by_username($user->get_username()))
			{
				return false;
			}
		}
		if ($import)
		{
			if ($this->identify_user($user))
			{
				return false;
			}
		}
		
		$first_name 		= $user->get_first_name();
		$last_name 			= $user->get_last_name();
		$username 			= $user->get_username();
		$password 			= $user->get_password();
		$password 			= $this->create_password($username, $password);
		$academic_year	 	= $user->get_academic_year();
		$term			 	= $user->get_term();
		$major			 	= $user->get_major();
		$level_code 		= $user->get_level_code();
		$degree		 		= $user->get_degree();
		$profile_photo 		= $user->get_profile_photo();
		$visibility			= $user->get_visibility();

		if ($update) 
		{
			$query = "UPDATE users SET first_name='$first_name', last_name='$last_name', academic_year='$academic_year',
				term='$term', major='$major', level_code='$level_code', degree='$degree', profile_photo='$profile_photo',
				visibility='$visibility' WHERE username='$username'";
		}
		else
		{
			$query  = "INSERT INTO users VALUES('$first_name', '$last_name', '$username', '$password', '$academic_year', '$term', 
				'$major', '$level_code', '$degree', '$profile_photo', '$visibility')";
		}	
		$result = $this->conn->query($query);
		$this->handle_db_result_error($result);

		return true;
	}

	// Get all users
	public function get_users()
	{
		$query = "SELECT * FROM users";
		$result = $this->conn->query($query);
		$this->handle_db_result_error($result);

		return $this->get_objects_from_table($result);
	}

	// Get all users sorted by given parameter and in given order: ASC | DESC
	private function get_sorted_users($param, $order)
	{
		$param = $this->sanitize_string($param);
		$query = "SELECT * FROM users ORDER BY $param";
		if ($order == "DESC")
		{
			$query .= " DESC";
		}
		
		$result = $this->conn->query($query);
		$this->handle_db_result_error($result);
		$users = $this->get_objects_from_table($result);
		return $users;
	}

	// Get all users sorted by last name - parameter order: ASC | DESC
	public function get_users_sorted_by_last_name($order)
	{
		return $this->get_sorted_users('last_name', $order);
	}

	// Get all users sorted by graduation year - parameter order: ASC | DESC
	public function get_users_sorted_by_academic_year($order)
	{
		return $this->get_sorted_users('academic_year', $order);
	}

	// Get all users filtered by given field with given value
	private function get_filtered_users($field, $filter)
	{
		$field = $this->sanitize_string($field);
		$filter = $this->sanitize_string($filter);

		$query = "SELECT * FROM users WHERE $field='$filter'";
		$result = $this->conn->query($query);
		$this->handle_db_result_error($result);
		$users = $this->get_objects_from_table($result);
		return $users;
	}

	// Get all users filtered by academic year
	public function get_users_filtered_by_academic_year($filter)
	{
		return $this->get_filtered_users('academic_year', $filter);
	}

	// Get all users filtered by first name
	public function get_users_filtered_by_first_name($filter)
	{
		return $this->get_filtered_users('first_name', $filter);
	}

	// Get all users filtered by last name
	public function get_users_filtered_by_last_name($filter)
	{
		return $this->get_filtered_users('last_name', $filter);
	}

	// Get user by username
	public function get_user_by_username($username)
	{
		$query = "SELECT * FROM users WHERE username='$username' LIMIT 1";

		$result = $this->conn->query($query);
		return $this->get_single_object_from_result($result);
	}

	// Get user by username & password
	public function get_user_by_username_and_password($username, $password)
	{
		$user = $this->get_user_by_username($username);
		if (! $user)
		{
			return null;
		}
		if ($this->create_password($username, $password) === $user->get_password())
		{
			return $user;
		}
		return null;
	}

	// Get user by first name, last name and academic year
	public function identify_user($user)
	{
		$first_name 	= $user->get_first_name();
		$last_name 		= $user->get_last_name();
		$academic_year 	= $user->get_academic_year();
		$term 			= $user->get_term();
		$major 			= $user->get_major();
		$degree 		= $user->get_degree();
		$query = "SELECT * FROM users WHERE first_name='$first_name' AND last_name='$last_name' AND academic_year='$academic_year'
			AND term='$term' AND major='$major' AND degree='$degree'";
		$result = $this->conn->query($query);
		return $this->get_single_object_from_result($result);
	}

	// Get single row as an object from the result
	private function get_single_object_from_result($result)
	{
		$this->handle_db_result_error($result);

		if ($result->num_rows > 0)
		{
			$result->data_seek(0);
			return $this->get_object($result->fetch_assoc());
		}
		else
		{
			return null;
		}
	}

	// Get a row from a database representing a user and transform it to User object
	protected function get_object($array)
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
		$user->set_visibility(isset($array['visibility']) ? $array['visibility'] : 2);
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