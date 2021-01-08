<?php
	include_once("vendor/autoload.php");
	use Medoo\Medoo;
	// this variable will be globally accessible once the configuration
	// in included (linked).
	$database = new Medoo([
 		'database_type' => 'mysql',
 		'server' => 'localhost',
 		'database_name' => 'wirosableng',
 		'username' => 'wshero',
 		'password' => 'wasweswos'
	]);
?>