<?php

class User
{
	private $first_name;
	private $last_name;
	private $username;
	private $password;
	private $academic_year;
	private $term;
	private $major;
	private $level_code;
	private $degree;
	private $profile_photo;
	
	public function get_first_name() 
	{
		return $this->first_name;
	}

	public function get_last_name() 
	{
		return $this->last_name;
	}

	public function get_username() 
	{
		return $this->username;
	}

	public function get_password() 
	{
		return $this->password;
	}

	public function get_academic_year() 
	{
		return $this->academic_year;
	}

	public function get_term() 
	{
		return $this->term;
	}

	public function get_major() 
	{
		return $this->major;
	}

	public function get_level_code() 
	{
		return $this->level_code;
	}

	public function get_degree() 
	{
		return $this->degree;
	}

	public function get_profile_photo() 
	{
		return $this->profile_photo;
	}

	public function set_first_name($first_name) 
	{
		$this->first_name = $first_name;
	}

	public function set_last_name($last_name) 
	{
		$this->last_name = $last_name;
	}

	public function set_username($username) 
	{
		$this->username = $username;
	}

	public function set_password($password) 
	{
		$this->password = $password;
	}

	public function set_academic_year($academic_year) 
	{
		$this->academic_year = $academic_year;
	}

	public function set_term($term) 
	{
		$this->term = $term;
	}

	public function set_major($major) 
	{
		$this->term = $major;
	}

	public function set_level_code($level_code) 
	{
		$this->level_code = $level_code;
	}

	public function set_degree($degree) 
	{
		$this->degree = $degree;
	}

	public function set_profile_photo($profile_photo) 
	{
		$this->profile_photo = $profile_photo;
	}

	public function to_json() {
        return json_encode(array(
            'first-name' 		=> $this->first_name,
            'last-name' 		=> $this->last_name,
            'username'  		=> $this->username,
            'password'  		=> $this->password,
            'academic-year'  	=> $this->academic_year,
            'term'  			=> $this->term,
            'major'  			=> $this->major,
            'level-code'  		=> $this->level_code,
            'degree'  			=> $this->degree,
            'profile-photo'  	=> $this->profile_photo
        ));
    }
}

?>