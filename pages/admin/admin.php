<?php


//connexion à la BDD
$servername = "localhost";
$username = "root";
$password = "nouveau_mot_de_passe";
$dbname = "arcadia_avis_test4";

try{
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Erreur : " .$e->getMessage();
    exit();
}

//Vérifier la connexion du user
if(isset($_COOKIE['email']) && isset($_COOKIE['token'])) {
    $email = $_COOKIE['email'];
    $token = $_COOKIE['token'];

    if($token){
        $req = $bdd->prepare("SELECT * FROM users WHERE email = :email AND token = :token");
        $req->execute(['email' => $email, 'token' => $token]);
        $rep = $req->fetch();

        if($rep && $rep['email']){
            header("Location: /index.php");
            exit();
        } else {
            echo "Connexion échouée";
        }
}
} else {
    header("Location: /pages/connexion/connexion.php");
    exit();
}
?>

<a href="/index.php">Accueil</a>