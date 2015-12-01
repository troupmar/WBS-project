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
			  </select><br />
			  
			  <p id='error-message'></p>
			  Filter alumni
			  <select id='filter-alumni'>
			   <option selected disabled>Choose here</option>
		       <option value='year'>By year</option>
		       <option value='first-name'>By first name</option>
		       <option value='last-name'>By last name</option>
			  </select>

			  <div id='filter-alumni-form'>
			   <input id='filter-alumni-text' type='text'></input>
			   <button id='alumni-filter-button'>Filter</button>
			   <button id='alumni-all-button'>Get All</button>
			  </div>


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
		array_push($js_files, 'validation.js', 'main.js');
		return $js_files;
	}

	protected function get_css_files()
	{
		$js_files = parent::get_css_files();
		array_push($js_files, 'main.css');
		return $js_files;
	}

}

?>