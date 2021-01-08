<?php
    include_once('php/config/database.php');
    include_once('php/config/session.php');
    
    // if the $_SESSION variable stores a session named loggedIn"
    // and the value of that session is TRUE, then accessing this page
    // is a mistake.
    // hence, move the user to another page, say index.php.
    if($_SESSION["loggedIn"]){
        // redirect to another page
        header("Location: index.php");
        exit;
    }
    // load the template
    $loader = new Twig_Loader_Filesystem("templates");
    $twig = new Twig_Environment($loader);
    $template = $twig->load("login.html");
    // render the template.
    echo $template->render();
?>