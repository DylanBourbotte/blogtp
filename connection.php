<?php 
// On démare une session( Regardez sur la doc ce que fait session_start ;) ) 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', ''); // Connection a la base de données
// Si le formulaire de connection et remplie
if(isset($_POST['formconnection'])) {
    // On empeche l'injection de code dans les champs id, et mdp
    $mailconnect = htmlspecialchars($_POST['mailconnect']);
    $mdpconnect = htmlspecialchars($_POST['mdpconnect']);

    // Si les variables ne sont pas définie
    if(!empty($mailconnect) && !empty($mdpconnect)) 
    {
        // Dans la table membres ou est l'email ? 
         $requser = $bdd->prepare("SELECT * FROM membres WHERE email = ?");
         $requser->execute(array($mailconnect));
         $userexist = $requser->fetch();
         // Si l'utilisateur existe
         if(password_verify($_POST['mdpconnect'], $userexist['pass'])) 
         {
            $_SESSION['id'] = $userexist['id'];
            $_SESSION['pseudo'] = $userexist['pseudo'];
            $_SESSION['mail'] = $userexist['mail'];
            // On redirige vers le profil
            header('Location: profil.php?id='.$_SESSION['id']);
         }
         // Sinon ..
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
    <link rel="stylesheet" href="css/app.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<div class='container'>
<div class='flex'>

<div id="container">

<div class='col-12'>

	<ul class="tabs">
		<li class="tab-link current" data-tab="tab-1">Login</li>
	</ul>

	<div id="tab-1" class="login tab-content current">

    <form method='post' action=''>

			<div class="form-section">
				<span class="fa fa-user-o input-icon"></span>
				<input type="text" name="mailconnect" placeholder="Adresse Email">
			</div>
			<div class="form-section">
				<span class="fa fa-unlock-alt input-icon"></span>
				<input type="password" name="mdpconnect" placeholder="Mot de passe">
			</div>
			<div class="form-section btn-container">
				<input type="submit"  name="formconnection" value="Connection">
			</div>
		</form>

		</form>
	</div>
</div>
</div>
<?php 

if(isset($erreur)) {
    echo "<font color='red'>".$erreur."</font>";
    echo "<font color='red' class='text-center'> Veuillez réessayer ou vous <a href='inscription.php'>inscrire</a></font>";
}

?>
</div>
</div>
</body>
</html>

