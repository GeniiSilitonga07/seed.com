<?php
	include_once('php/config/database.php');
	include_once('php/config/session.php'); 
 	if(!$_SESSION["loggedIn"]){
 	// redirect to another page
 		header("Location: login.php");
 		exit;
 	} 

 	$cart = [];
 	if(isset($_SESSION["cart"])){
 		$cart = $_SESSION["cart"];
 	} $fruitIds = array_keys($cart);

 	$fruits = $database->select("fruit","*",
 		["id" => $fruitIds,
 		"ORDER" => ["name" => "ASC"]
 	]); 

 	$summary = ["qty" => 0,"price" => 0.0 ];

 	foreach($fruits as $k=>$v){
 		$fruits[$k]["qty"] = $cart[$v["id"]];
 		if($fruits[$k]["qty"] <= $fruits[$k]["stock"]){
 			$fruits[$k]["ready"] = $fruits[$k]["qty"];
 		} else if ($fruits[$k]["stock"] == 0){
 			$fruits[$k]["ready"] = 0;
 		} else if ($fruits[$k]["qty"] > $fruits[$k]["stock"]){
 			$fruits[$k]["ready"] = $fruits[$k]["stock"];
 		}   $fruits[$k]["ready_str"] = "{$fruits[$k]['ready']} of {$fruits[$k]['qty']}";
 		$fruits[$k]["total_price"] = $fruits[$k]["price"] * $fruits[$k]["ready"];
 		$summary["qty"] += $fruits[$k]["qty"];
 		$summary["price"] += $fruits[$k]["total_price"];
 	} 

 	// do some debugging to understand the steps. 
 	//echo("<pre>"); 
 	//print_r($cart); 
 	//print_r($fruits); 
 	//print_r($summary); 
 	//die; 

 	$loader = new Twig_Loader_Filesystem("templates");
 	$twig = new Twig_Environment($loader);
 	$template = $twig->load('cart.html'); 

 	echo $template->render([
 		"loggedIn" => $_SESSION["loggedIn"],
 		"loggedInUser" => $_SESSION["loggedInUser"],
 		"fruits" => $fruits,
 		"summary" => $summary 
 	]);
 ?>