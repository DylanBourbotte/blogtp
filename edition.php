<?php 
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', ''); // Connection a la base de données

if(isset($_SESSION['id'])) 
{
    $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ? ");
    $requser->execute(array($_SESSION['id']));
    $user = $requser->fetch();

    if(isset($_POST['newpseudo']) && !empty($_POST['newpseudo']) && $_POST['newpseudo'] != $user['pseudo']) 
    {
        // On met a jours en fonction de ce qui et rentré dans les champs 
        $newpseudo = htmlspecialchars($_POST['newpseudo']);
        $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
        $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']);
    }

    if(isset($_POST['newmail']) && !empty($_POST['newmail']) && $_POST['newmail'] != $user['email']) 
    {
        $newmail = htmlspecialchars($_POST['newmail']);
        $insertmail = $bdd->prepare("UPDATE membres SET email = ? WHERE id = ?");
        $insertmail->execute(array($newmail, $_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']);
    }

    if(isset($_POST['newmdp1']) && !empty($_POST['newmdp1']) && isset($_POST['newmdp2']) && !empty($_POST['newmdp2']))
    {
        

        if($_POST['newmdp1'] === $_POST['newmdp2'])
        {
            $mdp1 = password_hash($_POST['newmdp1'], PASSWORD_DEFAULT);
            $insertmdp = $bdd->prepare('UPDATE membres SET pass = ? WHERE id = ?');
            $insertmdp->execute(array($mdp1, $_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
        }
        else 
        {
            $msg = "Vos deux mot de passe ne correspondent pas";
        }
        
      
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edition de mon profil</title>
    <link rel="stylesheet" href="css/app.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class='container'>
<div class='flex'>
    <h1>Edition de mon profil</h1>
        <form method='post' action=''>
            <label>Pseudo : </label>
            <input type="text" name='newpseudo' placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>">
        
            <label>Adresse Mail : </label>
            <input type="email" name='newmail' placeholder="Nouveau mail" value="<?php echo $user['email']; ?>">
        
            <label>Mot de passe : </label>
            <input type="password" name='newmdp1' placeholder="Nouveau mot de passe">
        
            <label>Confirmation - Mot de passe : </label>
            <input type="password" name='newmdp2' placeholder="Confirmation nouveau mot de passe">
        
            <input type="submit" value="Mettre a jour mon profil">



    </form>
    <?php 
        if(isset($msg)) { echo $msg; }
    ?>

</div>
</div>
</body>
</html>
<?php
}
else 
{
    header('Location: index.php');
}
?>

