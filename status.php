<?php
	include_once('php/config/database.php');
	include_once('php/config/session.php');
	// retrieve all statuses ordered by the published time.
	$statuses = $database->select(
		"status",
		["id", "text", "published_at"],
		[
			"ORDER" => [
			"published_at" => "DESC"
			]
		]);
	
	// set the directory where the templates are located.
	$loader = new Twig_Loader_Filesystem("templates");

	// create a Twig environment with the given loader.
	$twig = new Twig_Environment($loader);

	// load a desired template.
	$template = $twig->load('status.html');

	// ask the template to render itself with the supplied data.
	echo $template->render([
		// supplying data.
		// send the value of session named "loggedIn" to the template.
		"loggedIn" => $_SESSION["loggedIn"],
 		"loggedInUser" => $_SESSION["loggedInUser"],
		// the targeted template would recognize that statuses
		// is an array of status (retrieved with medoo).
		"statuses" => $statuses
	]);
?>