<?php

require_once('template.php');

class Main extends Template
{
	protected function renderBody() 
	{
		echo "<h1>Alumni</h1>
			  Sort alumni
			  <select id='sort-alumni'>
			   <option selected disabled>Choose here</option>
		       <option value='last-name-asc'>By last name in ascending order</option>
		       <option value='last-name-desc'>By last name in descending order</option>
		  	   <option value='grad-date-asc'>By graduation year in ascending order</option>
		  	   <option value='grad-date-desc'>By graduation year in descending order</option>
			  </select>
			  <table id='alumni-list'>
			   <tr>
			   	<th>Name</th>
			   	<th>Graduation Year</th>
			   </tr>";
		$user_model = new User_model();
		$users = $user_model->get_users();
		foreach ($users as $user)
		{
			echo "<tr>
				   <td>" . $user->get_first_name() . " " . $user->get_last_name() . "</td>
				   <td>" . $user->get_graduation_year() . "</td>
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