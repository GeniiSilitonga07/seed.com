<?php

include_once("vendor/autoload.php");

use Medoo\Medoo;
$database = new Medoo([
'database_type' => 'mysql',
'server' => 'localhost',
'database_name' => 'wirosableng',
'username' => 'wshero',
'password' => 'wasweswos'
]);

$fruit_voting_list = $database->select(
    "fruit",
    ["[><]fruit_voting" => ["fruit.id" => "voted_fruit"]],
    [
        "fruit.id",
        "fruit.name",
        "fruit.latin", 
        "fruit.color", 
        "fruit.description", 
        "fruit.image",
        "vote" => Medoo::raw('COUNT(<fruit_voting.voted_fruit>)'),
    ],
    [
        "GROUP" => "fruit.id"
    ]
);

    $loader = new Twig_Loader_Filesystem("templates");
    $twig = new Twig_Environment($loader);
    $template = $twig->load('fruit_voting.html');
    echo $template->render(
    [
        "view" => $fruit_voting_list,
        "loggedIn" => $_SESSION["loggedIn"],
        "loggedInUser" => $_SESSION["loggedInUser"]
    ]);
?>

                    