<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('./PHPExcel/Classes/PHPExcel.php');
require_once('../model/user.php');
require_once('../model/user_model.php');

if (empty($argv[1]))
{
	die("Program requires a xlsx file to be included as a parameter.\n");
}
if (! preg_match('/.xlsx$/', $argv[1])) 
{
	die("Wrong parameter type - it has to be a xlsx file!\n");
}
else
{
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$objPHPExcel = $objReader->load($argv[1]);

	$i = 0;
	foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
	    $worksheets[$i++] = $worksheet->toArray();
	}

	$worksheet = $worksheets[0];

	$offset = 4;

	for ($i=$offset; $i<count($worksheet); $i++)
	{
		$user_row = $worksheet[$i];
		$user = [];
		$user['first_name'] = $user_row[3];
		$user['last_name'] = $user_row[2];
		$user['username'] = substr($user_row[3], 0, 2) . substr($user_row[2], 0, 2) . rand(pow(10, 4-1), pow(10, 4)-1);
		$user['password'] = substr($user_row[3], 0, 2) . substr($user_row[2], 0, 2) . rand(pow(10, 4-1), pow(10, 4)-1);;
		$user['academic_year'] = $user_row[0];
		$user['term'] = $user_row[1];
		$user['major'] = $user_row[4];
		$user['level_code'] = $user_row[5];
		$user['degree'] = $user_row[6];
		
		$user_model = new User_Model();
		$user_model->store_user($user, false, true);
	}
}



?>