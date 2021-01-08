<?php
	include_once("vendor/autoload.php");
	include_once("php/config/database.php");
	include_once("php/config/session.php");
	use Medoo\Medoo;

	$database = new Medoo([   
    	'database_type' => 'mysql',   
    	'server' => 'localhost',   
    	'database_name' => 'wirosableng',   
    	'username' => 'wshero',   
    	'password' => 'wasweswos' 
	]);

	$testimonials = $database->select("testimony", 
        ["text", "full_name", "image"], 
        ["ORDER" => [       
            "published_at" => "DESC"     
        ]],
        [
        	"LIMIT"=>3
        ]
    );
	
	$loader = new Twig_Loader_Filesystem("templates");
	$twig = new Twig_Environment($loader); 
	$template = $twig->load('testimonials.html');
	echo $template->render(
		[
			"testimonials" => $testimonials,
			"loggedIn" => $_SESSION["loggedIn"],
 			"loggedInUser" => $_SESSION["loggedInUser"]
		]); 
?>