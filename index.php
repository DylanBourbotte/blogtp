<?php 
require('config.php')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class='container'>
<div class='flex'>
<form method='post' action=''>
    <label for="pseudo">Identifiant:</label>
    <input type="text" placeholder='Votre identifiant' id='pseudo' name='pseudo'>
    <label for="mail">Mail:</label>
    <input type="text" placeholder='Votre adresse email' id='mail' name='mail'>
    <label for="mail2">Confirmation du mail:</label>
    <input type="text" placeholder='Votre adresse email' id='mail2' name='mail2'>
    <label for="mdp">Mot de passe:</label>
    <input type="password" id='mdp' name='mdp'>
    <label for="mdp2">Confirmation du mot de passe:</label>
    <input type="password" id='mdp2' name='mdp2'>
</form>
</div>
</div>
</body>
</html>

