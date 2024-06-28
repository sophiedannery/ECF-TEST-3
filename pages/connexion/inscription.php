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
                <h1>Inscription</h1>
            </div>
        </div>

        <!-- Formulaire de connexion -->
        <div class="container">

            <form method="POST" action="traitement.php">
                <div class="form-group mt-3">
                    <label for="signin-mail">Identifiant</label>
                    <input type="email" class="form-control" id="signin-mail" placeholder="Adresse Email" name="signiinmail" required>
                </div>
                <div class="form-group mt-3">
                    <label for="signin-pwd">Mot de passe</label>
                    <input type="password" class="form-control" id="signin-pwd" placeholder="" name="signiinpwd" required>
                </div>
                <div class="form-group mt-3">
                    <label for="signin-conf-pwd">Confirmation du mot de passe</label>
                    <input type="password" class="form-control" id="signin-conf-pwd" placeholder="" name="signiinconfmail" required>
                </div>
                <div class="form-group mt-3">
                    <label for="signin-role">Rôle</label>
                    <select class="form-control" id="signin-role" name="signiinrole">
                        <option>Vétérinaire</option>
                        <option>Employé</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-3" value="Inscription" name="ok">Créer un nouveau compte</button>

            </form>

            </br>
            <a href="/index.php">Retour à l'accueil</a>
</br>
            <a href="/pages/connexion/connexion.php">Vous avez déjà un compte ? Connectez-vous ici.</a>


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