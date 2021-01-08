<?php
	include_once('php/config/database.php');
	include_once('php/config/session.php');

	$cart = [];
	if(isset($_SESSION["cart"])){
		$cart = $_SESSION["cart"];
	}

	$fruits = $database->select(
		"fruit",
		"*",
		[
			"ORDER" => [
				"added_at" => "ASC"
			]
		]
	);

	foreach ($fruits as $k => $v) {
		$votes = $database->count(
			"fuit_voting",
			[
				"voted_fruit" => $v["id"]
			]
		);

		$fruits[$k]["votes"] = $votes;
		$fruits[$k]["in_cart"] = 0;

		if(array_key_exists($v["id"], $cart)){
			$fruits[$k]["in_cart"] = $cart[$v["id"]];
		}
	}

	$mostVotedFruit = $database
		->query("
			SELECT voted_fruit AS 'id', count(id) AS 'votes'
			FROM fruit_voting
			GROUP BY voted_fruit
			ORDER BY count(id) DESC
			LIMIT 1")
		->fetch(PDO::FETCH_ASSOC); 

 	if($mostVotedFruit){
 		$mostVotedFruit = $mostVotedFruit['id'];
 	} else {
 		$mostVotedFruit = "";
 	} 

 	$loader = new Twig_Loader_Filesystem("templates");
 	$twig = new Twig_Environment($loader);
 	$template = $twig->load('shop.html'); 

	echo $template->render([
		"loggedIn" => $_SESSION["loggedIn"],
		"loggedInUser" => $_SESSION["loggedInUser"],
		"fruits" => $fruits,
		"mostVotedFruit" => $mostVotedFruit ]
	);
?>