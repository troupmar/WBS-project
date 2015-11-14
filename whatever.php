<?php

require_once('template.php');

class Whatever extends Template
{
	protected function renderBody() 
	{
		echo "<h1>Log in</h1>";
	}
}

?>