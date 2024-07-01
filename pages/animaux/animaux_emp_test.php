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

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

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


<!-- Contenu-->
    <main>

    <!-- Hero Scene -->
        <div class="hero-scene text-center text-white">
            <div class="hero-scene-content">
                <h1>Espace Employé</h1>
                <h4>Liste des animaux</h4>
            </div>
        </div>

        <div class="container">
        <br>
            <a href="/pages/admin-emp-vet/accueil-emp.php">Retour - Espace Employé</a>
            <br>
            <a href="/index.php">Retour à l'accueil</a>
        </div>


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

        // Initialisation des variables
        $habitat = isset($_GET['habitat']) ? $_GET['habitat'] : '';
        $animaux = [];

        // Requête pour récupérer les animaux selon l'habitat sélectionné
        if ($habitat) {
            $sql = "SELECT * FROM animaux2 WHERE habitat = :habitat ORDER BY prenom";
            try {
                $sth = $cx->prepare($sql);
                $sth->execute([':habitat' => $habitat]);
                $animaux = $sth->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Erreur lors de la récupération des données : " . $e->getMessage());
            }
        }

        // Mise à jour des informations de l'animal
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $nourriture_donnee = $_POST['nourriture_donnee'];
            $grammage_donnee = $_POST['grammage_donnee'];
            $passage_emp = date('Y-m-d H:i:s');
            $update_emp = date('Y-m-d H:i:s');

        $sql_update = "UPDATE animaux2 SET nourriture_donnee = ?, grammage_donnee = ?, passage_emp = ?, update_emp = ? WHERE id = ?";
        try {
            $sth_update = $cx->prepare($sql_update);
            $sth_update->execute([$nourriture_donnee, $grammage_donnee, $passage_emp, $update_emp, $id]);
            echo "Informations mises à jour avec succès.";
        } catch (PDOException $e) {
            die("Erreur lors de la mise à jour des données : " . $e->getMessage());
        }

        // Recharger les données après la mise à jour
        if ($habitat) {
            $sth->execute([':habitat' => $habitat]);
            $animaux = $sth->fetchAll(PDO::FETCH_ASSOC);
        }
}
?>


    <div class="container">
        
        <div class="btn-group mt-3 btn-primary" role="group" aria-label="Basic example">
            <a href="?habitat=Marais" class="btn btn-primary">Marais</a>
            <a href="?habitat=Jungle" class="btn btn-primary">Jungle</a>
            <a href="?habitat=Savane" class="btn btn-primary">Savane</a>
        </div>

        <?php if ($habitat): ?>
            <h3 class="mt-5">Animaux dans l'habitat: <?php echo htmlspecialchars($habitat); ?></h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Prénom</th>
                        <th>Race</th>
                        <th>Actions</th>
                        <th>Mise à jour</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($animaux as $animal): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($animal['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($animal['race']); ?></td>
                            <td>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#updateModal<?php echo $animal['id']; ?>">Mettre à jour</button>
                            </td>
                            <td><?php echo htmlspecialchars($animal['update_emp']); ?></td>
                        </tr>

                        <!-- Modal pour mettre à jour l'animal -->
                        <div class="modal fade" id="updateModal<?php echo $animal['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?php echo $animal['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel<?php echo $animal['id']; ?>">Mettre à jour l'animal: <?php echo htmlspecialchars($animal['prenom']); ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" action="">
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?php echo $animal['id']; ?>">
                                            <div class="form-group">
                                                <label for="nourriture_donnee">Nourriture donnée</label>
                                                <input type="text" class="form-control" name="nourriture_donnee" value="<?php echo htmlspecialchars($animal['nourriture_donnee']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="grammage_donnee">Grammage donné</label>
                                                <input type="text" class="form-control" name="grammage_donnee" value="<?php echo htmlspecialchars($animal['grammage_donnee']); ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="passage_emp">Passage - Emp</label>
                                                <input type="datetime-local" class="form-control" name="passage_emp" value="<?php echo date('Y-m-d\TH:i', strtotime($animal['passage_emp'])); ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>



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



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
                    
    <!-- Inclusion Bootstrap -->                                        
    <script src="/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


    









