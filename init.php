<?php
//--------- BDD
$mysqli = new mysqli("localhost", "root", "31mars2003", "site");
if ($mysqli->connect_error) die('Un problème est survenu lors de la tentative de connexion : ' . $mysqli->connect_error);
// $mysqli->set_charset("utf8");
 
//--------- SESSION
session_start();
 
//--------- CHEMIN
define("RACINE_SITE","/site1/");
 
//--------- VARIABLES
$contenu = '';
 
//--------- AUTRES INCLUSIONS
require_once("fonction.php");
?>