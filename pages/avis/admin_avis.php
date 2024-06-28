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
                <ul class="navbar-nav mr-auto">
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


    <main>

         <div class="hero-scene text-center text-white">
            <div class="hero-scene-content">
                <h1>Admin Avis</h1>
            </div>
        </div>


    

<div class="container mt-5">
    <h3 class="mt-5">Gestion des Avis</h3>
    <button class="btn btn-primary" onclick="toggleAvis('pending')">Avis en attente</button>
    <button class="btn btn-primary" onclick="toggleAvis('approved')">Avis validés</button>

    <!-- Section des avis en attente -->
    <div id="avis-pending" class="avis-section">
        <?php
            $user = "root";
            $pwd = "nouveau_mot_de_passe";
            $db = "mysql:host=localhost;dbname=arcadia_avis_test4";

            try {
                $cx = new PDO($db, $user, $pwd);
                $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "SELECT * FROM commentaires WHERE etat = 0 ORDER BY id DESC";
                $sth = $cx->prepare($sql);
                $sth->execute();
                $result = $sth->fetchAll();

                foreach($result as $commentaire) {
                    $date_creation = date("d/m/Y", strtotime($commentaire["date_creation"]));
                    $etat = $commentaire["etat"] ? "Validé" : "En attente";

                    echo "
                    <div><h5 class='text-center mt-5'>Avis en attente :</h5></div>
                    <div class='commentaire card m-5'>
                        <div class='commentaire-text card-body'>
                            <h3 class='commentaire-nom card-title'>" . $commentaire["nom"] . "</h3>
                            <p class='commentaire-date card-subtitle'> Posté le $date_creation - État : $etat</p>
                            <p class='commentaire-message card-text pt-3'>" . $commentaire["commentaire"] . "</p>
                        </div>

                        <div class='admin-options text-center'>
                            <form action='/pages/avis/admin_avis.php' method='post'>
                                <input type='hidden' name='commentaire_id' value='" . $commentaire["id"] . "'>
                                <label for='valider'>Valider</label>
                                <input type='checkbox' name='valider' id='valider' value='1' " . ($commentaire["etat"] ? "checked" : "") . ">
                                <input type='submit' value='Enregistrer' class='btn btn-primary'>
                            </form>

                            <form action='/pages/avis/admin_avis.php' method='post' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer ce commentaire ?\");'>
                                <input type='hidden' name='delete_commentaire_id' value='" . $commentaire["id"] . "'>
                                <input type='submit' value='Supprimer' class='btn btn-danger m-4'>
                            </form>
                        </div>
                    </div>";
                }

                // Traitement de la suppression de commentaire
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_commentaire_id"])) {
                    $delete_commentaire_id = $_POST["delete_commentaire_id"];

                    $sql_delete = "DELETE FROM commentaires WHERE id = :id";
                    $sth_delete = $cx->prepare($sql_delete);
                    $sth_delete->execute(array(':id' => $delete_commentaire_id));

                    // Rafraîchir la page après suppression
                    echo "<script>window.location.replace('/pages/avis/admin_avis.php');</script>";
                }

                // Traitement de la validation de commentaire
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["commentaire_id"])) {
                    $commentaire_id = $_POST["commentaire_id"];
                    $valider = isset($_POST["valider"]) ? 1 : 0;

                    $sql_update = "UPDATE commentaires SET etat = :etat WHERE id = :id";
                    $sth_update = $cx->prepare($sql_update);
                    $sth_update->execute(array(':etat' => $valider, ':id' => $commentaire_id));

                    // Rafraîchir la page après validation
                    echo "<script>window.location.replace('/pages/avis/admin_avis.php');</script>";
                }

            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage() . "</br>";
                die();
            }
        ?>
    </div>

    <!-- Section des avis validés -->
    <div id="avis-approved" class="avis-section" style="display: none;">
        <?php
            try {
                $sql = "SELECT * FROM commentaires WHERE etat = 1 ORDER BY id DESC";
                $sth = $cx->prepare($sql);
                $sth->execute();
                $result = $sth->fetchAll();

                foreach($result as $commentaire) {
                    $date_creation = date("d/m/Y", strtotime($commentaire["date_creation"]));

                    echo "
                    <div><h5 class='text-center mt-5'>Avis validés :</h5></div>
                    <div class='commentaire card m-5'>
                        <div class='commentaire-text card-body'>
                            <h3 class='commentaire-nom card-title'>" . $commentaire["nom"] . "</h3>
                            <p class='commentaire-date card-subtitle'> Posté le $date_creation</p>
                            <p class='commentaire-message card-text pt-3'>" . $commentaire["commentaire"] . "</p>
                        </div>

                        <div class='admin-options text-center'>
                            <form action='/pages/avis/admin_avis.php' method='post' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer ce commentaire ?\");'>
                                <input type='hidden' name='delete_commentaire_id' value='" . $commentaire["id"] . "'>
                                <input type='submit' value='Supprimer' class='btn btn-danger m-4'>
                            </form>
                        </div>
                    </div>";
                }

            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage() . "</br>";
                die();
            }
        ?>
    </div>

    </br>
    <a href="/index.php" class="mt-5">Retour à l'accueil</a>
</div>


</main>


<!-- Footer-->
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






<!-- Inclusion JavaScript-->
<script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script JS toggle boutons avis vérifiés, avis à valider -->
<script>
    function toggleAvis(type) {
        var pendingSection = document.getElementById('avis-pending');
        var approvedSection = document.getElementById('avis-approved');

        if (type === 'pending') {
            pendingSection.style.display = 'block';
            approvedSection.style.display = 'none';
        } else if (type === 'approved') {
            pendingSection.style.display = 'none';
            approvedSection.style.display = 'block';
        }
    }
</script>

</body>
</html>
