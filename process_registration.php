<?php 
	include_once('php/classes/Security.php');
	include_once('php/config/database.php');
	include_once('php/config/session.php'); 
 	use web\Security; 
 
 	$nextPage = "register.php";
 	$message = ""; 
 	// get the user inputs. 
 	$account = [
 		"email" => trim($_POST["email"]),
 		"full_name" => trim($_POST["full_name"]),
 		"password" => "",
 		"description" => $_POST["description"],
 		"image" => addslashes('images\default.jpg'),
 		"last_login" => date("Y-m-d H:i:s") ]; 

 	// full name is required. 
 	if(!strlen($account["full_name"])){   
 		$message .= "Full name is required."; 
 	}

 	// email is required. 
 	if(!strlen($message) && !strlen($account["email"])){
 		$message .= "Email is required.";
 	} 

 	// check if the email is already in use. 
 	if(!strlen($message) &&$database->has("account",
 		["email" => $account["email"]]))
 		{  
 			$message .= "Email has been taken.";
 		} 

 	// password is required. 
	if(!strlen($message) && !strlen($_POST["password"])){
		$message .= "Password is required.";
	} 

 	// the password must be repeated. 
 	if(!strlen($message) && $_POST["password"] != $_POST["repassword"]){
 		$message .= "Password does not match.";
 	} 

 	// when there is a 'message' there is an error.
  	if(strlen($message)) {   
  		// removing the password from the array fro security reason.   
 		unset($account["password"]);   
  		// put things in the session.   
  		// these sessions will be used to display error message   
  		// & the already filled form input fields.   
  		$_SESSION["error_registration_account"] = $account;
  		$_SESSION["error_registration_message"] = $message;
  	} else {   
  		// when there is no error message.   
  		// convert the password with a hashed.   
  		$account["password"] = Security::hashPassword($_POST["password"]);      
  		// store the image file.   
  		if ($_FILES["image"]["size"] <= 20480) { 
  		// 20KB     $imagePath = "images" . 
  		$_FILES["image"]["name"];
  		$uploaded = move_uploaded_file(
  			$_FILES["image"]["tmp_name"],
  			$imagePath); 
    	if($uploaded){       
     		$account["image"] = $imagePath;
     		}
		}
		// save the new account.   
     	$database->insert("account", $account);   
     	// send the new user to the login form.   
     	$nextPage = "login.php"; 
    }      
     
 	// redirect to another page 
    header("Location: {$nextPage}"); 
    exit; 