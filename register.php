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
			if (! empty($_POST['first-name']) && ! empty($_POST['last-name']) 
				&& ! empty($_POST['username']) && ! empty($_POST['password']) && ! empty($_POST['graduation-year']))
			{	
				$user = array('first-name' => $_POST['first-name'], 'last-name' => $_POST['last-name'],
							  'username' => $_POST['username'], 'password' => $_POST['password'], 
							  'graduation-year' => $_POST['graduation-year']);


				$conn = Connection::get_instance();
				$user_model = new User_model($conn->get_connection());

				if ($user_model->store_user($user) == false)
				{
					echo "<p class='error'>Username already exists.</p>";
					$this->render_register_form();
				}
				else
				{
					echo "<p class='success'>User was succesfully registered!</p>";
				}
			}
			else
			{
				echo "<p class='error'>All fields must be filled.</p>";
				$this->render_register_form();	
			}
		}
		else
		{
			$this->render_register_form();
		}
	}


	private function render_register_form() 
	{
		echo "<form action='alumni.php?page=register' method='post'>
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

}
?>