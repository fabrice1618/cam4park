<?php
require_once("autoload.php");

date_default_timezone_set('Europe/Paris');

if ( !isset($_SERVER['DOCUMENT_ROOT'])) {
    throw new \Exception("Fatal error: This application must be run in a web environnement.", 1);
}

$sBasepath=$_SERVER['DOCUMENT_ROOT'].'/';   // Chemin de la base de l'application avec un slash final

$aRequest = getPost();  // chargement des parametres dans body requete

$sRequestURI = $_SERVER['REQUEST_URI'];
$sRequestMethod = $_SERVER['REQUEST_METHOD'];
$sRequestHTTP_authorisation = $_SERVER['HTTP_HTTP_AUTHORIZATION'] ?? "";

# Routeur
if ($sRequestMethod == "POST" && $sRequestURI == "/movement") {
    $oController = new MovementController($aRequest, $sRequestHTTP_authorisation);
    $oController->run();
    $oController->response();    
} elseif ($sRequestMethod == "GET" && $sRequestURI == "/remaining_place") {
    $oController = new RemainingPlacesController();
    $oController->run();
    $oController->response();    
} else {
    $oController = new HTTP404Controller($sRequestURI, $sRequestMethod);
    $oController->response();    
}


///////// Fonctions

function getPost()
{
    if(!empty($_POST)) {
        // when using application/x-www-form-urlencoded or multipart/form-data as the HTTP Content-Type in the request
        // NOTE: if this is the case and $_POST is empty, check the variables_order in php.ini! - it must contain the letter P
        return $_POST;
    }

    // when using application/json as the HTTP Content-Type in the request 
    $post = json_decode(file_get_contents('php://input'), true);
    if(json_last_error() == JSON_ERROR_NONE) {
        return $post;
    }

    return [];
}
