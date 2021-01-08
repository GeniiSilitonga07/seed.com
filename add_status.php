<?php
	include_once("vendor/autoload.php");
	include_once("php/classes/Security.php");
	use Medoo\Medoo;
	use web\Security;
	$database = new Medoo([
		'database_type' => 'mysql',
		'server' => 'localhost',
		'database_name' => 'wirosableng',
		'username' => 'wshero',
		'password' => 'wasweswos' 
	]);
	
	$status = [
	"id" => Security::random(64),
	"text" => $_POST["text"],
	// create a date with PHP function
	"published_at" => date("Y-m-d H:i:s")
	]; 

	$database->insert("status", $status); 
	// redirect to another page 
	header("Location: status.php");
	exit; 
?>