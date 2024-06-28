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
              <a class="navbar-brand" href="/index.php">Arcadia</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ms-auto">
                      <li class="nav-item active">
                          <a class="nav-link" href="/index.php">Accueil</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="/pages/services/services.php">Services</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="/pages/habitats/habitats.php">Habitats</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="/pages/contact/contact.php">Contact</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="/pages/connexion/connexion.php">Connexion</a>
                      </li>
                  </ul>
              </div>
          </nav>
    </header>


    <!-- Contenu -->
    <main>

    <!-- Hero Scene -->
        <div class="hero-scene text-center text-white">
            <div class="hero-scene-content">
                <h1>Connexion</h1>
            </div>
        </div>

        <!-- PHP Gestion - Formulaire de connexion -->
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

          $error_msg = "";

          //Vérifier si formulaire de connexion est bien en POST puis création variables
         if($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['signupemail'];
            $password = $_POST['signuppwd'];
            
            if($email != "" && $password != ""){
              //connexion à la bdd pour vérifier si mail et mdp correspondent
              $req = $bdd->prepare("SELECT * FROM users WHERE email = :email AND mdp = :password");
              $req->execute([
                'email' => $email,
                'password' => $password
              ]);
              $rep = $req->fetch();

              if($rep) {
                  // c'est ok, demarre une session pour l'user connecté (création de cookie)
                  setcookie("username", $email, time() + 3600);
                  setcookie("password", $password, time() + 3600);

                  //redirigier vers la page d'acceuil
                  header("Location: /index.php");
                  exit();
              } else {
                //message erreur
                $error_msg = "Email ou mot de passe incorect.";
              }
            } else {
              $error_msg = "Tous les champs ne sont pas remplis.";
            }
         }
        ?>

        <!-- Formulaire de connexion -->
        <div class="container">

          <form method="POST" action="">
                <div class="form-group mt-3">
                    <label for="c">Identifiant</label>
                    <input type="email" class="form-control" id="signupemail"  placeholder="Adresse Email" name="signupemail" required>
                </div>
                <div class="form-group mt-3">
                    <label for="signuppwd">Mot de passe</label>
                    <input type="password" class="form-control" id="signuppwd" placeholder="" name="signuppwd" required>
                </div>
                <button type="submit" value="Connexion" name="ok" class="btn btn-primary mt-3">Connexion</button>
          </form>

          <!-- affichage du message d'erreur créé plus haut -->
          <?php
          if($error_msg) {
            echo "<p class='text-danger'>$error_msg</p>";
          }
          ?>

          </br>
          <a href="/index.php">Retour à l'accueil</a>
          </br>
          <a href="/pages/connexion/inscription.php">Vous n'avez pas de compte ? Inscrivez-vous ici.</a>

        </div>

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



</body>
</html>