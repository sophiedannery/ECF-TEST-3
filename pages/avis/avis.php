<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Inclusion Bootstrap -->
    <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- Inclusion Bootstrap Icon -->
    <link rel="stylesheet" href="/node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Inclusion CSS -->
    <link rel="stylesheet" href="/scss/main.css">

    <title>Arcadia</title>

</head>



<body>

<!-- Nav Bar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Arcadia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Disabled</a>
                </li>
                </ul>
            </div>
        </nav>
    </header>


<!-- Contenu-->
    <main>

        <div class="hero-scene text-center text-white">
            <div class="hero-scene-content">
                <h1>Votre avis nous intéresse</h1>
            </div>
        </div>

<!-- Formulaire Avis-->
        <div class="container mt-5">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" required class="form-control mt-3">
                </div>
                <div class="form-group">
                    <label for="message">Commentaire</label>
                    <textarea name="commentaire" cols="30" rows="5" required id="" class="form-control mt-3"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" value="envoyer" class="btn btn-primary mt-3">
                </div>
            </form>
        </div>

        <div class="container mt-5">
            <a href="/index.php">Retour à l'accueil</a>
        </div>
        

            <!-- Envoi AVIS BDD-->
            <?php
            ///On vérifie si les champs ne sont pas vides
            if (isset($_POST["nom"]) && !empty($_POST["nom"]) && isset($_POST["commentaire"]) && !empty($_POST["commentaire"]))  {

            //Création des variables pour la connexion à la bdd
                $user = "root";
                $pwd = "nouveau_mot_de_passe";
                $db = "mysql:host=localhost;dbname=arcadia_avis_test4";

            //Tentative de connexion avec un try catch
                try {
                    $cx = new PDO($db, $user, $pwd) or die();
                    $cx ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    echo "Erreur est survenue lors de la connexion : " . $e->getMessage() . "</br>";
                    die();
                }


                try{
                    $nom = htmlspecialchars($_POST["nom"]);
                    $com = htmlspecialchars($_POST["commentaire"]);
                    $sql = "INSERT INTO commentaires (id, nom, commentaire, date_creation, etat) VALUES (NULL, :nom, :commentaire, NOW(), 0)";
                    $sth = $cx->prepare($sql);
                    $sth->execute(array(":nom"=>$nom, ":commentaire"=>$com));
                } catch (PDOException $e) {
                    echo "Erreur est survenue lors de la connexion : " . $e->getMessage() . "</br>";
                    die();
                }
            }
            ?>



    </main>


<!-- Footer -->
    <footer>
    <div class="container">
        <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-5 border-top">

          <div class="col mb-3">
            <a href="/" class="d-flex align-items-center mb-3 link-body-emphasis text-decoration-none">
              Arcadia
            </a>
            <p class="text-body-secondary">&copy; 2024</p>
          </div>
      
          <div class="col mb-3">
              <ul class="list-unstyled d-flex">
                <li class="ms-3"><a class="link-body-emphasis" href="#"><i class="bi bi-instagram"></i></a></li>
                <li class="ms-3"><a class="link-body-emphasis" href="#"><i class="bi bi-facebook"></i></a></li>
                <li class="ms-3"><a class="link-body-emphasis" href="#"><i class="bi bi-threads"></i></a></li>
              </ul>
          </div>
      
          <div class="col mb-3">
            <h5>Section</h5>
            <ul class="nav flex-column">
              <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
              <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
              <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
              <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
              <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
            </ul>
          </div>
      
          <div class="col mb-3">
            <h5>Section</h5>
            <ul class="nav flex-column">
              <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
              <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
              <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
              <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
              <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
            </ul>
          </div>
      
          <div class="col mb-3">
            <h5>Section</h5>
            <ul class="nav flex-column">
              <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Home</a></li>
              <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
              <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
              <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
              <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">About</a></li>
            </ul>
          </div>
        </footer>
      </div>
    </footer>






<!-- Inclusion Bootstrap -->
    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>