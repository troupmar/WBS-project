<?php

require_once('template.php');
require_once('model/connection.php');
require_once('model/user_model.php');

class Login extends Template
{
	protected function render_body() 
	{
		echo "<h1>Log in</h1>";
		if (! empty($_POST)) 
		{
			$errors =  $this->validate_username(isset($_POST['username']) ? $_POST['username'] : "");
			$errors .= $this->validate_password(isset($_POST['password']) ? $_POST['password'] : "");

			if ($errors)
			{
				$this->render_login_form($errors);
			}	
			else
			{
				$conn = Connection::get_instance();
				$user_model = new User_model($conn->get_connection());
				$user = $user_model->get_user_by_username_and_password($_POST['username'], $_POST['password']);
				if (isset($user))
				{
					$_SESSION['username'] = $user->get_username();
					$_SESSION['password'] = $user->get_password();
					if (isset($_SESSION['redirect']))
					{
						// redirect to previous page if set to session
						header("Location: " . $_SESSION['redirect']);
					}
					else
					{
						$this->redirect_to_main_page();
					}
					ob_flush();
				}
				else 
				{
					$this->render_login_form('Invalid username or password.');	
				}
			}
		}
		else
		{
			$this->render_login_form();
		}
	}

	protected function get_js_files() 
	{
		$js_files = parent::get_js_files();
		array_push($js_files, "validation.js");
		return $js_files;
	}

	private function render_login_form($error_message = null)
	{
		echo "<p id='error-message'>$error_message</p>
			  <form action='alumni.php?page=login' method='post' onsubmit='return validateLoginForm(this);'>
			     <label>Username</label>
			     <input type='text' name='username' placeholder='username'>
	
			     <label>Password</label>
			     <input type='password' name='password' placeholder='password'>

				<button type='submit'>Log in</button>
			  </form>";
	}

	private function validate_username($username)
	{
		return ($username == "") ? "Username cannot be empty!<br />" : null;
	}

	private function validate_password($password)
	{
		return ($password == "") ? "Password cannot be empty!<br />" : null;
	}

}

?>