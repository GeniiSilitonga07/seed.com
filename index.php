<?php
include_once ('php/classes/Status.php');
include_once ('vendor/autoload.php');
use Medoo\Medoo;
use web\Status;


$database = new Medoo([   
    'database_type' => 'mysql',   
    'server' => 'localhost',   
    'database_name' => 'wirosableng',   
    'username' => 'wshero',   
    'password' => 'wasweswos' 
]); 

$statuses = $database->get("status", 
        ["text", "published_at"], 
        ["ORDER" => [       
            "published_at" => "DESC"     
        ]],
        ["LIMIT" => 1]);

$result = $database->select(
    "fruit",
    ["[>]fruit_voting" => ["fruit.id" => "voted_fruit"]],
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
        "GROUP" => "fruit.id",
    ]
);

$last_added = $database->get("fruit", 
        ["name", "latin", "color", "image"], 
        ["ORDER" => [       
            "added_at" => "DESC"     
        ]],
        ["LIMIT" => 1]
);

$max = 0;
$most_voted = null;

foreach ($result as $res) {
    if($res["vote"] > $max) {
        $max = $res["vote"];
        $most_voted = $res;
    }
}
 
 $loader = new Twig_Loader_Filesystem("templates"); 
  
 $twig = new Twig_Environment($loader); 

 $template = $twig->load('index.html'); 
 

 echo $template->render([
    "loggedIn" => $_SESSION["loggedIn"],
    "loggedInUser" => $_SESSION["loggedInUser"],
    "last_added" => $last_added,
    "most_voted" => $most_voted,
    "statuses" => $statuses
 ]); 
?>
    