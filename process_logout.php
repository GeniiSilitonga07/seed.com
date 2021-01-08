<?php
	include_once("php/config/session.php");
	// set the value of session named "loggedIn" to FALSE.
	// it means that the system resets the value to its default.
	$_SESSION["loggedIn"] = false;
	// redirect to another page
	header("Location: index.php");
	exit;
?>