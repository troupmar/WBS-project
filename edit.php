<?php

require_once('template.php');
require_once('model/connection.php');
require_once('model/user_model.php');

class Edit extends Template 
{
	private $username;

	public function __construct($username)
	{
		parent::__construct();
		$this->username = $this->sanitize_string($username);

	}

	protected function render_body()
	{
		if (isset($_SESSION['username']) && $_SESSION['username'] == $this->username) 
		{
			$user_model = new User_model();
			$user = $user_model->get_user_by_username($this->username);

			if (!empty($_POST)) 
			{
				// CSRF protection
				if ($_POST['session-id'] == $_COOKIE["PHPSESSID"]) {
					$user->set_first_name(isset($_POST['first-name']) ? $this->sanitize_string($_POST['first-name']) : "");
					$user->set_last_name(isset($_POST['last-name']) ? $this->sanitize_string($_POST['last-name']) : "");
					$user->set_academic_year(isset($_POST['academic-year']) ? $this->sanitize_string($_POST['academic-year']) : "");
					$user->set_term(isset($_POST['term']) ? $this->sanitize_string($_POST['term']) : "");
					$user->set_major(isset($_POST['major']) ? $this->sanitize_string($_POST['major']) : "");
					$user->set_level_code(isset($_POST['level-code']) ? $this->sanitize_string($_POST['level-code']) : "");
					$user->set_degree(isset($_POST['degree']) ? $this->sanitize_string($_POST['degree']) : "");
					$user->set_visibility(isset($_POST['visibility']) ? $this->sanitize_string($_POST['visibility']) : "");

					$errors  = $user->validate_first_name();
					$errors .= $user->validate_last_name();
					$errors .= $user->validate_academic_year();
					$errors .= $user->validate_term();
					$errors .= $user->validate_major();
					$errors .= $user->validate_level_code();
					$errors .= $user->validate_degree();

					if (!empty($_FILES['profile-photo']['name'])) 
					{
						$errors .= $user->validate_profile_photo($_FILES['profile-photo']['name'], $_FILES['profile-photo']['size']);
					}

					if ($errors)
					{
						$this->render_edit_form($user, $errors);
					}
					else
					{
						$this->handle_file_upload($user, $_FILES['profile-photo']);
						$user_model = new User_model();
						$user_model->store_user($user, false, false, true);
						header('Location: alumni.php?page=profile&username=' . $this->username);
					}
				}
					
			}
			else
			{
				$this->render_edit_form($user);
			}
			
		}
		else
		{
			echo "<p>Sorry, you are not authorized to edit this profile. You can try to <a href='alumni.php?page=logout'>Log out</a>
				and try to Log in for a different user!</p>"; 
		}
	}

	private function handle_file_upload(&$user, $new_profile_photo)
	{
		$images_dir = "./public/profile_images/";
		if (!empty($new_profile_photo['name'])) 
		{
			if ($user->get_profile_photo()) 
			{
				unlink($images_dir . $user->get_profile_photo());	
			}
			$user->set_profile_photo($new_profile_photo['name']);
			$file_target = $images_dir . $new_profile_photo['name'];
			move_uploaded_file($new_profile_photo["tmp_name"], $file_target);

		} 
		else
		{
			// if user did not fill a profile photo input and had a profile image set before -> delete it
			if ($user->get_profile_photo()) 
			{
				unlink($images_dir . $user->get_profile_photo());
				$user->set_profile_photo(null);
			}
		}
	}

	private function render_edit_form($user, $error_message = null) 
	{
		$username		= $user->get_username();
		$first_name 	= $user->get_first_name();
		$last_name 		= $user->get_last_name();
		$academic_year 	= $user->get_academic_year();
		$term 			= $user->get_term();
		$major 			= $user->get_major();
		$level_code 	= $user->get_level_code();
		$degree 		= $user->get_degree();
		$visibility		= $user->get_visibility();

		$visibility_selected = array();
		for ($i=0; $i<3; $i++) {
			if ($visibility == $i)
			{
				$visibility_selected[$i] = "selected";
			}
			else
			{
				$visibility_selected[$i] = "";
			}
		}

		echo "<p id='error-message'>$error_message</p>
			  <form action='alumni.php?page=edit&username=$username' method='post' enctype='multipart/form-data' 
			  	onSubmit='return validateEditForm(this);'>

			  	<label>Select profile visibility</label>
			    <select name='visibility'>
			     <option value='0' $visibility_selected[0]>Nobody can see the profile</option>
  				 <option value='1' $visibility_selected[1]>Only logged in users can see the profile</option>
  			     <option value='2' $visibility_selected[2]>Everybody can see the profile</option>
  				</select>

			    <label>First name</label>
			    <input type='text' name='first-name' class='form-control' value='$first_name'>
				
			    <label>Last name</label>
			    <input type='text' name='last-name' class='form-control' value='$last_name'>

			    <label>Academic year</label>
			    <input type='text' name='academic-year' class='form-control' value='$academic_year'>

			    <label>Term</label>
			    <input type='text' name='term' class='form-control' value='$term'>

			    <label>Major</label>
			    <input type='text' name='major' class='form-control' value='$major'>

			    <label>Level code</label>
			    <input type='text' name='level-code' class='form-control' value='$level_code'>

			    <label>Degree</label>
			    <input type='text' name='degree' class='form-control' value='$degree'>

			    <label>Profile photo</label>
			    <input type='file' name='profile-photo' id='profile-photo'>

			    <input type='hidden' name='session-id' id='session-id' value=''>

				<button type='submit' class='btn btn-default'>Edit profile</button>
			  </form>";
	}

	protected function get_js_files() 
	{
		$js_files = parent::get_js_files();
		array_push($js_files, "edit.js");
		array_push($js_files, "validation.js");
		return $js_files;
	}
}

?>