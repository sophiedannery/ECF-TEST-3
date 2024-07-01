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
            <h1>Liste des animaux</h1>
            <h4>Vétérinaire</h4>
        </div>
    </div>

    <br>
    <a href="/pages/admin-emp-vet/accueil-vet.php">Retour - Espace Vétérinaire</a>
    <br>
    <a href="/index.php">Retour à l'accueil</a>

    <!-- Voir les animaux -->

    <!-- Afficher les animaux de la BDD -->
    <?php
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "nouveau_mot_de_passe";
    $dbname = "arcadia_avis_test4";

    try {
        $cx = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $cx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur est survenue lors de la connexion : " . $e->getMessage());
    }

    // Requête pour récupérer les animaux triés par habitat
    $sql = "SELECT * FROM animaux2 ORDER BY habitat";
    try {
        $sth = $cx->prepare($sql);
        $sth->execute();
        $animaux = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la récupération des données : " . $e->getMessage());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des données envoyées via POST pour l'update
        $id = $_POST['id'];
        $etat = $_POST['etat'];
        $nourriture_proposee = $_POST['nourriture_proposee'];
        $grammage_propose = $_POST['grammage_propose'];
        $passage_vet = $_POST['passage_vet'];
        $detail_etat = $_POST['detail_etat'];

        // Reformater la date et l'heure dans le format MySQL
        $passage_vet_mysql = date('Y-m-d H:i:s', strtotime($passage_vet));


        // Requête de mise à jour
        $sql_update = "UPDATE animaux2 SET etat = ?, nourriture_proposee = ?, grammage_propose = ?, passage_vet = ?, detail_etat = ? WHERE id = ?";
        try {
            $sth_update = $cx->prepare($sql_update);
            $sth_update->execute([$etat, $nourriture_proposee, $grammage_propose, $passage_vet, $detail_etat, $id]);
            echo "Animal mis à jour avec succès.";
        } catch (PDOException $e) {
            die("Erreur lors de la mise à jour des données : " . $e->getMessage());
        }

        // Recharger les données après la mise à jour
        $sth->execute();
        $animaux = $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    ?>

    <!-- Tableau Voir les animaux -->
    <div class="container">
        <h3 class="mt-5">Voir les animaux</h3>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Prénom</th>
                        <th>Race</th>
                        <th>Habitat</th>
                        <th>État</th>
                        <th>Nourriture Proposée</th>
                        <th>Grammage Proposé</th>
                        <th>Passage - Vet</th>
                        <th>Détail de l'État</th>
                        <th>Nourriture donnée</th>
                        <th>Grammage donné</th>
                        <th>Passage - Emp</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($animaux as $animal) { ?>
                        <tr>
                            <form method="post" action="">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($animal['id']); ?>">
                                <td><?php echo htmlspecialchars($animal['prenom']); ?></td>
                                <td><?php echo htmlspecialchars($animal['race']); ?></td>
                                <td><?php echo htmlspecialchars($animal['habitat']); ?></td>
                                <td><input type="text" name="etat" value="<?php echo htmlspecialchars($animal['etat']); ?>"></td>
                                <td><input type="text" name="nourriture_proposee" value="<?php echo htmlspecialchars($animal['nourriture_proposee']); ?>"></td>
                                <td><input type="text" name="grammage_propose" value="<?php echo htmlspecialchars($animal['grammage_propose']); ?>"></td>
                                <td><input type="datetime-local" name="passage_vet" value="<?php echo htmlspecialchars($animal['passage_vet']); ?>"></td>                            <td><input type="text" name="detail_etat" value="<?php echo htmlspecialchars($animal['detail_etat']); ?>"></td>
                                <td><?php echo htmlspecialchars($animal['nourriture_donnee']); ?></td>
                                <td><?php echo htmlspecialchars($animal['grammage_donnee']); ?></td>
                                <td><?php echo htmlspecialchars($animal['passage_emp']); ?></td>
                                <td><button type="submit" class="btn btn-primary">Mettre à jour</button></td>
                            </form>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        
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