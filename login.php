<?php

require_once('template.php');
require_once('model/connection.php');
require_once('model/user_model.php');

class Login extends Template
{
	protected function renderBody() 
	{
		echo "<h1>Log in</h1>";
		if (! empty($_POST)) 
		{
			if (! empty($_POST['username']) && ! empty($_POST['password']))
			{	
				$conn = Connection::get_instance();
				$user_model = new User_model($conn->get_connection());
				$user = $user_model->get_user_by_username($_POST['username']);
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
						// redirect to the main page
						$host  = $_SERVER['HTTP_HOST'];
						$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
						$page = 'alumni.php'; 
						header("Location: http://$host$uri/$page");
					}
					ob_flush();
				}
				else 
				{
					echo "<p class='error'>Invalid username or password.</p>";
					$this->render_login_form();	
				}
			}
			else
			{
				echo "<p class='error'>Invalid username or password.</p>";
				$this->render_login_form();	
			}
		}
		else
		{
			$this->render_login_form();
		}
	}

	private function render_login_form()
	{
		echo "<form action='alumni.php?page=login' method='post'>
			     <label>Username</label>
			     <input type='text' name='username'placeholder='username'>
	
			     <label>Password</label>
			     <input type='password' name='password' placeholder='password'>

				<button type='submit'>Log in</button>
			  </form>";
	}

}

?>