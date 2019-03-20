<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', ''); // Connection a la base de données

if(isset($_GET['id']) && $_GET['id'] > 0) {

    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ? ');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class='container'>
<div class='flex'>
<h1>Profil de <?php echo $userinfo['pseudo'] ?></h1>
<p>Pseudo: <?php echo $userinfo['pseudo'] ?></p>
<p>Email: <?php echo $userinfo['email'] ?></p>

<?php 

if(isset($_SESSION['id']) && $userinfo['id'] == $_SESSION['id']) {
?>
<a href="edition.php">Editer mon profil</a>
<a href="deconnexion.php">Se deconnecter</a>
<?php
}
?>

</div>
</div>
</body>
</html>
<?php
}
else 
{
    echo "<h1>Nous n'avons pas trouver de profil avec cette id</h1>";
}
?>

