<?php
	include_once('php/config/database.php');
	include_once('php/config/session.php'); 
 	$errorMessage = ""; $errorAccount = []; 
 	if(isset($_SESSION["error_registration_message"])){
 		$errorMessage = $_SESSION["error_registration_message"];
 		unset($_SESSION["error_registration_message"]);
 	} 

	if(isset($_SESSION["error_registration_account"])){
		$errorAccount = $_SESSION["error_registration_account"];
		unset($_SESSION["error_registration_account"]);
	} 

 	$loader = new Twig_Loader_Filesystem("templates");
 	$twig = new Twig_Environment($loader);
 	$template = $twig->load('register.html'); 
 echo $template->render([
 	"loggedIn" => $_SESSION["loggedIn"],
 	"message" => $errorMessage,
 	"account" => $errorAccount
 ]);