<?php
	include_once("vendor/autoload.php"); 
	include_once("php/config/session.php"); 
	include_once("php/config/database.php");

	$get_fruit = $database->get("fruit",
		["name", "latin", "color", "image"],
		["ORDER" => [       
            "added_at" => "ASC"     
        ]
    ]);

	$loader = new Twig_Loader_Filesystem("templates");
	$twig = new Twig_Environment($loader); 
	$template = $twig->load("fruit_almanac.html");
	echo $template->render(
		[
			"get_fruit" => $get_fruit,
            "loggedIn" => $_SESSION["loggedIn"],
 			"loggedInUser" => $_SESSION["loggedInUser"]
        ]); 
?>