<?php

require_once('model/user_model.php');

class Profile extends Template 
{
	private $user;

	public function __construct($username)
	{
		parent::__construct();
		$user_model = new User_model();
		$username = $this->sanitize_string($username);
		$this->user = $user_model->get_user_by_username($username);
	}


	protected function render_body() 
	{
		if (($this->user->get_visibility() == 1 && isset($_SESSION['username'])) || $this->user->get_visibility() == 2 || 
			(isset($_SESSION['username']) && $_SESSION['username'] == $this->user->get_username()))
		{
			echo "<h1>" . $this->user->get_first_name() . " " . $this->user->get_last_name() . "</h1>";
			$images_dir = "./public/profile_images/";
			if ($this->user->get_profile_photo())
			{
				$photo_path = $images_dir . $this->user->get_profile_photo();
				echo "<img src='$photo_path' alt='Profile image' height='200' width='200'>";	
			} 
			else
			{
				$photo_path = $images_dir . "placeholder.jpg";
				echo "<img src='$photo_path' alt='Profile image' height='200' width='200'>";
			}

			$username 	 	= $this->user->get_username();
			$academic_year 	= $this->user->get_academic_year();
			$term 			= $this->user->get_term();
			$major 			= $this->user->get_major();
			$level_code 	= $this->user->get_level_code();
			$degree 		= $this->user->get_degree();

			echo "<ul>
				   <li><b>Username:</b> $username</li>
				   <li><b>Academic year:</b> $academic_year</li>
				   <li><b>Term:</b> $term</li>
				   <li><b>Major:</b> $major</li>
				   <li><b>Level code:</b> $level_code</li>
				   <li><b>Degree:</b> $degree</li>
				  </ul>";
		}
		else 
		{
			echo "<p>Sorry, you are not authorized to see this profile. You can try to <a href='alumni.php?page=login'>Log in</a>!</p>"; 
		}
		
	}
}

?>