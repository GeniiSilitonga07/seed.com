<?php
	include_once('php/classes/Security.php');
	include_once('php/config/database.php');
	include_once('php/config/session.php'); 
 	use web\Security; 

 	if(!$_SESSION["loggedIn"]){
 		// redirect to another page
 		header("Location: login.php");
 		exit;
 	} 

 	$cart = [];
 	if(isset($_SESSION["cart"])){
 		$cart = $_SESSION["cart"];
 	}

 	$fruitIds = array_keys($cart); 
 	$fruits = $database->select("fruit","*",
 		[
 			"id" => $fruitIds,
 			"ORDER" => ["name" => "ASC"]
 		]); 

 	$summary = ["qty" => 0,   "price" => 0.0 ]; 
 	foreach($fruits as $k=>$v){
 		$fruits[$k]["qty"] = $cart[$v["id"]];
 		if($fruits[$k]["qty"] <= $fruits[$k]["stock"]){
 			$fruits[$k]["ready"] = $fruits[$k]["qty"];
 		} else if ($fruits[$k]["stock"] == 0){
 			$fruits[$k]["ready"] = 0;
 		} else if ($fruits[$k]["qty"] > $fruits[$k]["stock"]){
 			$fruits[$k]["ready"] = $fruits[$k]["stock"];
 		}
 		$fruits[$k]["ready_str"] = "{$fruits[$k]["ready"]} of {$fruits[$k]["qty"]}";
 		$fruits[$k]["total_price"] = $fruits[$k]["price"] * $fruits[$k]["ready"];
 		$summary["qty"] += $fruits[$k]["qty"];
 		$summary["price"] += $fruits[$k]["total_price"];
 	} 

 	if($summary["qty"] && $summary["price"]){
 		$purchasing = [
 			"id" => Security::random(64),
 			"buyer" => $_SESSION["loggedInUser"]["email"],
 			"total" => $summary["price"],
 			"issued_at" => date("Y-m-d H:i:s"),
 			"payed_at" => date("Y-m-d H:i:s")
 		];
 		if(isset($_POST['action'])){
 		$database->insert("purchasing", $purchasing);
 		foreach($fruits as $fruit){
 			$purchasingDetail = [
 				"purchasing" => $purchasing["id"],
 				"fruit" => $fruit["id"],
 				"amount" => $fruit["ready"],
 				"price" => $fruit["total_price"],
 				"placed_at" => date("Y-m-d H:i:s")
 			];
 			$database->insert("purchasing_detail",
 				$purchasingDetail);
 			$database->update(
 				"fruit",[
 					"stock" => $fruit["stock"] - $fruit["ready"]
 				],
 				["id" => $fruit["id"]]
 			); 
 	 	}
 	 	}	
 	 	unset($_SESSION["cart"]); 
 	 }
 

	 header("Location: cart.php");
	 exit; 
?>