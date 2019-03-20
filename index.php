<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', ''); // Connection a la base de données

if(isset($_POST['formconnection'])) {
    
    $mailconnect = htmlspecialchars($_POST['mailconnect']);
    $mdpconnect = htmlspecialchars($_POST['mdpconnect']);

    
    if(!empty($mailconnect) && !empty($mdpconnect)) 
    {
         $requser = $bdd->prepare("SELECT * FROM membres WHERE email = ?");
         $requser->execute(array($mailconnect));
         $userexist = $requser->fetch();
         if(password_verify($_POST['mdpconnect'], $userexist['pass'])) 
         {
            $_SESSION['id'] = $userexist['id'];
            $_SESSION['pseudo'] = $userexist['pseudo'];
            $_SESSION['mail'] = $userexist['mail'];
            header('Location: profil.php?id='.$_SESSION['id']);
         }
         else 
         {
             $erreur = 'Les mot de passes ne correspondent pas !';
         }
        //  var_dump($userexist);
        //  die;
        //  if($userexist == 1)
        //  {
        //      $userinfo = $requser->fetch();
        //      $_SESSION['id'] = $userinfo['id'];
        //      $_SESSION['pseudo'] = $userinfo['pseudo'];
        //      $_SESSION['mail'] = $userinfo['mail'];
        //      header('Location: profil.php?id='.$_SESSION['id']);
        //  }
        //  else {
        //      $erreur = 'Idenfiant ou mot de passe incorect';
        //  }
    } 
    else 
    {
        $erreur = 'Tout les champs doivent être complétés !';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connection</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class='container'>
<div class='flex'>
<form method='post' action=''>

<input type="email" name="mailconnect" placeholder="Adresse Email">
<input type="password" name="mdpconnect" placeholder="Mot de passe">
<input type="submit" name="formconnection" value="Se connecter">
<a href="inscription.php">S'inscrire</a>


</form>

<?php 

if(isset($erreur)) {
    echo "<font color='red'>".$erreur."</font>";
}

?>
</div>
</div>
</body>
</html>

