<?php

class User
{
	private $first_name;
	private $last_name;
	private $username;
	private $password;
	private $graduation_year;
	private $d_o_b;
	private $profile_photo;
	private $about;
	
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

	public function get_graduation_year() 
	{
		return $this->graduation_year;
	}

	public function get_d_o_b() 
	{
		return isset($this->d_o_b) ? $this->d_o_b : null;
	}

	public function get_profile_photo() 
	{
		return $this->profile_photo;
	}

	public function get_about() 
	{
		return $this->about;
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

	public function set_graduation_year($graduation_year) 
	{
		$this->graduation_year = $graduation_year;
	}

	public function set_d_o_b($d_o_b) 
	{
		$this->d_o_b = $d_o_b;
	}

	public function set_profile_photo($profile_photo) 
	{
		$this->profile_photo = $profile_photo;
	}

	public function set_about($about) 
	{
		$this->about = $about;
	}
}

?>