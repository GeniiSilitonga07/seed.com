<?php
include_once "php\classes\Security.php";
use web\Security;

// use the Security component to generate a random string
$id = Security::random(64);
// get the id of the voted fruit.
// the index used here is the name of the input element
$voted_fruit = $_POST["voted_fruit"];

// credential
$servername = "localhost";
$dbname = "wirosableng";
$username = "wshero";
$password = "wasweswos";

try {
	// create a new database connection
	$conn = new PDO(
		"mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// prepare an insertion statement
	$stmt = $conn->prepare("INSERT INTO fruit_voting(id, voted_fruit)
		VALUES (:id, :voted_fruit)");
	// binding parameters
	$stmt->bindParam(':id', $id);
	$stmt->bindParam(':voted_fruit', $voted_fruit);
	$stmt->execute();
} catch (PDOException $e) {
	echo "Error: " . $e->getMessage();
}
$stmt = null;
$conn = null;

// redirect to another page
header("Location: fruit_voting.php");
exit;