<?php
	include_once("vendor/autoload.php");
	include_once("php/classes/Security.php");
	include_once("php/config/database.php");
	include_once("php/config/session.php");

	use Medoo\Medoo;
	use web\Security;

	$database = new Medoo([
		'database_type' => 'mysql',
		'server' => 'localhost',
		'database_name' => 'wirosableng',
		'username' => 'wshero',
		'password' => 'wasweswos' 
	]);

	$data = $database->insert("testimony",
		[
			"id" => Security::random(64),
			"full_name" => $_POST["full_name"],
			"email" => $_POST["email"],
			"image" => $_POST["image"],
			"text" => $_POST["text"],
			// create a date with PHP function
			"published_at" => date("Y-m-d H:i:s")
	]); 

	header("Location: testimonials.php");
	exit; 
?>