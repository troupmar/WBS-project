<?php

require_once('template.php');

class Main extends Template
{
	protected function render_body() 
	{
		echo "<h1>Alumni</h1>
			  Sort alumni
			  <select id='sort-alumni'>
			   <option selected disabled>Choose here</option>
		       <option value='last-name-asc'>By last name in ascending order</option>
		       <option value='last-name-desc'>By last name in descending order</option>
		  	   <option value='academic-year-asc'>By academic year in ascending order</option>
		  	   <option value='academic-year-desc'>By academic year in descending order</option>
			  </select>
			  <table id='alumni-list'>
			   <tr>
			   	<th>Name</th>
			   	<th>Academic year</th>
			   </tr>";
		$user_model = new User_model();
		$users = $user_model->get_users();
		foreach ($users as $user)
		{

			$username = $user->get_username();
			echo "<tr>
				   <td><a href='alumni.php?page=profile&username=$username'</a>" . 
				   $user->get_first_name() . " " . $user->get_last_name() . "</td>
				   <td>" . $user->get_academic_year() . "</td>
				  </tr>";
		}
		echo "</table>";


	}

	protected function get_js_files()
	{
		$js_files = parent::get_js_files();
		array_push($js_files, 'main.js');
		return $js_files;
	}
}

?>