<?php
	if(!isset($_SESSION["loggedInUser"]))
		{ $_SESSION["loggedInUser"] = [
			"email" => NULL,
			"full_name" => NULL,
			"description" => NULL,
			"owner" => NULL,
			"last_login" => NULL
			];
		}

	if(!isset($_SESSION["loggedIn"])){
		$_SESSION["loggedIn"] = false;
	}
?>