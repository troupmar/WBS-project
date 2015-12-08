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
	private $visibility;
	
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

	public function get_visibility() 
	{
		return ($this->visibility == null ? 2 : $this->visibility);
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
		$this->major = $major;
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

	public function set_visibility($visibility) 
	{
		$this->visibility = $visibility;
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
            'profile-photo'  	=> $this->profile_photo,
            'visibility'		=> $this->visibility
        ));
    }

   	public function validate_first_name()
	{
		return ($this->first_name == "") ? "First name cannot be empty!<br />" : null;
	}

	public function validate_last_name()
	{
		return ($this->last_name == "") ? "Last name cannot be empty!<br />" : null;
	}

	public function validate_username()
	{
		return ($this->username == "") ? "Username cannot be empty!<br />" : null;
	}

	public function validate_password()
	{
		return ($this->password == "") ? "Password cannot be empty!<br />" : null;
	}

	public function validate_academic_year()
	{
		if ($this->academic_year == "") 
		{
			return "Gradudation year input cannot be empty!<br />";
		}
	
		if (! preg_match("/^[0-9]{4}-[0-9]{2}$/", $this->academic_year))
		{
			return "Academic year wrong format! Correct input i.e. 2003-04.<br />";
		}
		$years = explode("-", $this->academic_year);
		$next_year = $years[0] + 1;
		//echo $years[0] . " " . $years[1] . " " . date("Y") . " " . $academic_year; die;
		if ($years[0] < 1900 || $years[1] > date("Y") || $years[1] != substr($next_year, 2)) {
			return "Academic year must be between 1900 and " . date("Y") . "<br />";
		} 

		return null;
	}

	public function validate_term()
	{
		if (!$this->term) return null;
		if (!preg_match("/^[0-9]{6}$/", $this->term))
		{
			return "Term wrong format! Correct input should consist of 6 digits.<br />";
		}
		return null;
	}

	public function validate_major()
	{
		if (!$this->major) return null;
		if (!preg_match("/^[A-Z]{2,6}$/", $this->major))
		{
			return "Major wrong format! Correct input should consist of 2-6 capital letters.<br />";
		}
		return null;
	}

	public function validate_level_code()
	{
		if (!$this->level_code) return null;
		if (!preg_match("/^[A-Z]{2,6}$/", $this->level_code))
		{
			return "Level code wrong format! Correct input should consist of 2-6 capital letters.<br />";
		}
		return null;
	}

	public function validate_degree()
	{
		if (!$this->degree) return null;
		if (!preg_match("/^[A-Z]{2,6}$/", $this->degree))
		{
			return "Level code wrong format! Correct input should consist of 2-6 capital letters.<br />";
		}
		return null;
	}

	public function validate_profile_photo($file_name, $size)
	{
		$file_type = pathinfo($file_name, PATHINFO_EXTENSION);
		if (strcasecmp($file_type, "jpg") != 0 && strcasecmp($file_type, "png") != 0 && strcasecmp($file_type, "jpeg") != 0) 
		{
    		return "Only JPG, JPEG & PNG are allowed for a profile photo!<br />";
    	}
    	if ($size > 500000) {
	    	return "A file cannot be larger than 500 000 B!<br />";
	    }

    	return null;
	}
}

?>