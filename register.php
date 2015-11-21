<?php

require_once('template.php');
require_once('model/connection.php');
require_once('model/user_model.php');

class Register extends Template
{
	protected function renderBody() 
	{
		if (! empty($_POST)) 
		{
			$errors =  $this->validate_first_name(isset($_POST['first-name']) ? $_POST['first-name'] : "");
			$errors .= $this->validate_last_name(isset($_POST['last-name']) ? $_POST['last-name'] : "");
			$errors .= $this->validate_username(isset($_POST['username']) ? $_POST['username'] : "");
			$errors .= $this->validate_password(isset($_POST['password']) ? $_POST['password'] : "");
			$errors .= $this->validate_graduation_year(isset($_POST['graduation-year']) ? $_POST['graduation-year'] : "");

			if ($errors)
			{
				$this->render_register_form($errors);
			}
			else 
			{
				$user = array('first_name' => $_POST['first-name'], 'last_name' => $_POST['last-name'],
							  'username' => $_POST['username'], 'password' => $_POST['password'], 
							  'graduation_year' => $_POST['graduation-year']);

				$conn = Connection::get_instance();
				$user_model = new User_model($conn->get_connection());

				if ($user_model->store_user($user) == false)
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
		return array("validation.js");
	}

	private function render_register_form($error_message = null) 
	{
		echo "<p id='error-message'>$error_message</p>
			  <form action='alumni.php?page=register' method='post' onsubmit='return validateRegisterForm(this);'>
			    <label>First name</label>
			    <input type='text' name='first-name' class='form-control' placeholder='First name'>
				
			    <label>Last name</label>
			    <input type='text' name='last-name' class='form-control' placeholder='Last name'>

			    <label>Graduation year</label>
			    <input type='text' name='graduation-year' class='form-control' placeholder='graduation-year'>
				
			    <label>Username</label>
			    <input type='text' name='username' class='form-control' placeholder='username'>

			    <label>Password</label>
			    <input type='password' name='password' class='form-control' placeholder='password'>

				<button type='submit' class='btn btn-default'>Register</button>
			  </form>";
	}

	private function validate_first_name($first_name)
	{
		return ($first_name == "") ? "First name cannot be empty!<br />" : null;
	}

	private function validate_last_name($last_name)
	{
		return ($last_name == "") ? "Last name cannot be empty!<br />" : null;
	}

	private function validate_username($username)
	{
		return ($username == "") ? "Username cannot be empty!<br />" : null;
	}

	private function validate_password($password)
	{
		return ($password == "") ? "Password cannot be empty!<br />" : null;
	}

	private function validate_graduation_year($graduation_year)
	{
		return ($graduation_year == "") ? "Graduation year cannot be empty!<br />" : null;	
	}

}
?>