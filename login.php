<?php

require_once('template.php');
require_once('model/connection.php');
require_once('model/user_model.php');

class Login extends Template
{
	protected function render_body() 
	{
		if (!isset($_SESSION['username']))
		{
			echo "<h1>Log in</h1>";
			if (! empty($_POST)) 
			{
				$user = new User();
				$user->set_username(isset($_POST['username']) ? $this->sanitize_string($_POST['username']) : "");
				$user->set_password(isset($_POST['password']) ? $this->sanitize_string($_POST['password']) : "");


				$errors =  $user->validate_username();
				$errors .= $user->validate_password();

				if ($errors)
				{
					$this->render_login_form($errors);
				}	
				else
				{
					$user_model = new User_model();
					$user = $user_model->get_user_by_username_and_password($user->get_username(), $user->get_password());
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
		else
		{
			echo "<p>User is already logged in. In order to log in, you first need to <a href='alumni.php?page=logout'>Log out</a>!</p>";
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

}

?>