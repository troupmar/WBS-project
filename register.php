<?php

require_once('template.php');
require_once('model/connection.php');
require_once('model/user_model.php');

class Register extends Template
{
	protected function render_body() 
	{
		if (!empty($_POST)) 
		{
			$user = new User();
			$user->set_first_name(isset($_POST['first-name']) ? $this->sanitize_string($_POST['first-name']) : "");
			$user->set_last_name(isset($_POST['last-name']) ? $this->sanitize_string($_POST['last-name']) : "");
			$user->set_username(isset($_POST['username']) ? $this->sanitize_string($_POST['username']) : "");
			$user->set_password(isset($_POST['password']) ? $this->sanitize_string($_POST['password']) : "");
			$user->set_academic_year(isset($_POST['academic-year']) ? $this->sanitize_string($_POST['academic-year']) : "");
 
			$errors  = $user->validate_first_name();
			$errors .= $user->validate_last_name();
			$errors .= $user->validate_username();
			$errors .= $user->validate_password();
			$errors .= $user->validate_academic_year();

			if ($errors)
			{
				$this->render_register_form($errors);
			}
			else 
			{
				$user_model = new User_model();

				if ($user_model->store_user($user, true, false, false) == false)
				{
					$this->render_register_form('Username already exists.');
				}
				else
				{
					$this->redirect_to_main_page();
				}
			}
		}
		else
		{
			$this->render_register_form();
		}
	}

	protected function get_js_files() 
	{
		$js_files = parent::get_js_files();
		array_push($js_files, "validation.js");
		return $js_files;
	}

	private function render_register_form($error_message = null) 
	{
		echo "<p id='error-message'>$error_message</p>
			  <form action='alumni.php?page=register' method='post' onsubmit='return validateRegisterForm(this);'>
			    <label>First name</label>
			    <input type='text' name='first-name' class='form-control' placeholder='First name'>
				
			    <label>Last name</label>
			    <input type='text' name='last-name' class='form-control' placeholder='Last name'>

			    <label>Academic year</label>
			    <input type='text' name='academic-year' class='form-control' placeholder='academic-year'>
				
			    <label>Username</label>
			    <input type='text' name='username' class='form-control' placeholder='username'>

			    <label>Password</label>
			    <input type='password' name='password' class='form-control' placeholder='password'>

				<button type='submit' class='btn btn-default'>Register</button>
			  </form>";
	}

}
?>