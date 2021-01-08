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
	} 
	$addedFruit = $_POST["added_fruit"]; 
 
if(!array_key_exists($addedFruit, $cart)){
	$cart[$addedFruit] = 0;
} 

$cart[$addedFruit]++; 
$_SESSION["cart"] = $cart; 

// redirect to another page
header("Location: shop.php");
exit;

?>