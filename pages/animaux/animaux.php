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
                <h4>Admin</h4>
            </div>
        </div>


<!-- Formulaire ajout animal-->
        <div class="container">
            <h3>Ajouter un animal</h3>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group mt-3">
                    <label for="prenomAnimal">Prénom de l'animal</label>
                    <input type="text" class="form-control" id="prenomAnimal"  name="prenomAnimal" required>
                </div>
                <div class="form-group mt-3">
                    <label for="raceAnimal">Race de l'animal</label>
                    <input type="text" class="form-control" id="raceAnimal"  name="raceAnimal" required>
                </div>
                <div class="form-group mt-3">
                    <label for="habitatAnimal">Example select</label>
                    <select class="form-control" id="habitatAnimal" name="habitatAnimal" required>
                    <option>Savane</option>
                    <option>Jungle</option>
                    <option>Marais</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary mt-3">Ajouter l'animal</button>
            </form>

            <br>
            <a href="/pages/admin-emp-vet/accueil-admin.php">Retour - Espace Administrateur</a>
            <br>
            <a href="/index.php">Retour à l'accueil</a>

        </div>



        <!-- Envoi ANIMAL BDD-->
        <?php
            ///On vérifie si les champs ne sont pas vides
            if (isset($_POST["prenomAnimal"]) && !empty($_POST["prenomAnimal"]) && isset($_POST["raceAnimal"]) && !empty($_POST["raceAnimal"]) && isset($_POST["habitatAnimal"]) && !empty($_POST["habitatAnimal"]))  {

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
                    $pre = htmlspecialchars($_POST["prenomAnimal"]);
                    $rac = htmlspecialchars($_POST["raceAnimal"]);
                    $hab = htmlspecialchars($_POST["habitatAnimal"]);
                    $sql = "INSERT INTO animaux2 (id, prenom, race, habitat) VALUES (NULL, :prenom, :race, :habitat)";
                    $sth = $cx->prepare($sql);
                    $sth->execute(array(":prenom"=>$pre, ":race"=>$rac, ":habitat"=>$hab));

                    // Redirection vers la page de confirmation
                    header("Location: animaux.php");
                    exit();


                } catch (PDOException $e) {
                    echo "Erreur est survenue lors de la connexion : " . $e->getMessage() . "</br>";
                    die();
                }
            }
            ?>



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
                ?>


<!-- Tableau Voir les animaux -->
        <div class="container">
            <h3 class="mt-5">Voir les animaux</h3>

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
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($animaux as $animal) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($animal['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($animal['race']); ?></td>
                            <td><?php echo htmlspecialchars($animal['habitat']); ?></td>
                            <td><?php echo htmlspecialchars($animal['etat']); ?></td>
                            <td><?php echo htmlspecialchars($animal['nourriture_proposee']); ?></td>
                            <td><?php echo htmlspecialchars($animal['grammage_propose']); ?></td>
                            <td><?php echo htmlspecialchars($animal['passage_vet']); ?></td>
                            <td><?php echo htmlspecialchars($animal['detail_etat']); ?></td>
                            <td><?php echo htmlspecialchars($animal['nourriture_donnee']); ?></td>
                            <td><?php echo htmlspecialchars($animal['grammage_donnee']); ?></td>
                            <td><?php echo htmlspecialchars($animal['passage_emp']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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