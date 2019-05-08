<?php 
// On ce connecte a la base de données créer pour l'espace membres
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', ''); // Connection a la base de données
// Si le formulaire et remplie
if(isset($_POST['forminscription'])) {
    // On empeche l'injection de code dans les variable pseudo, et mail
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp = $_POST['mdp'];
    $mdp2 = $_POST['mdp2'];
    // Si une variable n'est pas définie
    if(!empty($_POST['pseudo']) && !empty($_POST['mail']) && !empty($_POST['mail2']) && !empty($_POST['mdp']) && !empty($_POST['mdp2'])) {
        // On récupere la longueur du pseudo
        $pseudolength = strlen($pseudo);
        // Si le pseudo fait moins de 255 caractères
        if($pseudolength <= 255) {  
            // Si le mail et identique a la vérification
           if($mail == $mail2) {  
               // On filtre l'email pour s'assurer qu'il et valide
               if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                   // On selectionne les email dans la bdd 
                   $reqmail = $bdd->prepare("SELECT * FROM membres WHERE email = ?");
                   $reqmail->execute(array($mail));
                   // On compte le nombre d'email
                   $mailexist = $reqmail->rowCount();
                   // On vérifie que l'email n'existe pas
                   if($mailexist == 0) {
                    // Si le mot de passe et égal a la confirmation de mot de passe
                    if($mdp === $mdp2) {
                        // On sécurise le mot de passe
                        $mdp = password_hash($mdp,PASSWORD_DEFAULT);
                        // On prepare et insere le membre dans la base de données
                        $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, pass, email) VALUES(?, ?, ?)");
                        $insertmbr->execute(array($pseudo,$mdp, $mail));
                        $erreur = "Votre compte a bien été créer <a href=\"index.php\">Se connecter</a>";
                        // On redirige alors vers la page de connection
                        header('Location: index.php');
                        
                } else {
                    $erreur = "Les mots de passe ne correspondent pas !";
                }
            } else {
                $erreur = 'Adresse email déja utilisé';
            }
            } else {
                $erreur = "Votre adresse mail n'est pas valide ! ";
            }

           } else {
               $erreur = "Les adresse email ne correspondent pas !";
           }
        } else {
            $erreur = "Le nom d'utilisateur ne doit pas dépasser 255 caractéres";
        }
    } else {
        $erreur = "Tout les champs doivent être remplie";
    }
}
?>
<!-- Pas besoin de commenter ici c'est un formulaire des plus basique -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/app.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class='container'>
<div class='flex'>
<form method='post' action=''>
    
    <label for="pseudo">Identifiant:</label>
    <input type="text" placeholder='Votre identifiant' id='pseudo' name='pseudo' value="<?php if(isset($pseudo)) { echo $pseudo;} ?>">
    
    <label for="mail">Mail:</label>
    <input type="email" placeholder='Votre adresse email' id='mail' name='mail' value="<?php if(isset($mail)) { echo $mail;} ?>">
    
    <label for="mail2">Confirmation du mail:</label>
    <input type="email" placeholder='Votre adresse email' id='mail2' name='mail2' value="<?php if(isset($mail2)) { echo $mail2;} ?>">
    
    <label for="mdp">Mot de passe:</label>
    <input type="password" id='mdp' name='mdp'>
    
    <label for="mdp2">Confirmation du mot de passe:</label>
    <input type="password" id='mdp2' name='mdp2'>
    <input type='submit' name='forminscription' value="S'inscire" class='button'>
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

