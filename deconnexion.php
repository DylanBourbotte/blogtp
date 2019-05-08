<?php 
session_start();
// On retourne la session dans un tableau
$_SESSION = array();
// On détruit la session actif
session_destroy();
header('Location: connection.php')

?>