<?php
//  Configuration de la BDD
$dbhost = 'localhost';
$dbusername = 'root';
$dbpasswd = '';
$database_name = 'domotheque';

// Script de connexion à la BDD
$connection = mysql_connect("$dbhost","$dbusername","$dbpasswd") or die ("Impossible de se connecter au serveur de BDD.");
$db = mysql_select_db("$database_name", $connection) or die("Impossible de sélectionner la BDD.");
?>