
<!-- Traitement des données de création de compte -->

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


// Vérifier si on récupère bien les données puis récupérer les données et les mettre en variable
if(isset($_POST['signiinmail']) && isset($_POST['signiinpwd']) && isset($_POST['signiinrole'])){
    $signiinmail = $_POST['signiinmail'];
    $signiinpwd = $_POST['signiinpwd'];
    $signiinrole = $_POST['signiinrole'];

//Envooyer les données dans la BDD
    try{
        $requete = $bdd->prepare("INSERT INTO users (email, mdp, role) VALUES(:email, :mdp, :role)");
        $requete->execute(
            array(
                "email" => $signiinmail, 
                "mdp" => $signiinpwd,
                "role" => $signiinrole
            )
        );

// Redirection vers la page de confirmation
        header("Location: inscription_confirmation.php");
        exit();

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
    
}


?>