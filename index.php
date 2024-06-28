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


<!-- Contenu-->
    <main>

    <!-- Hero Scene -->
        <div class="hero-scene text-center text-white">
            <div class="hero-scene-content">
                <p>Bienvenue au parc animalier</p>
                <h1>Arcadia</h1>
            </div>
        </div>


        <section>
            <article>
                <div class="container p-4">
                    <h2 class="text-center text-primary">Bienvenue à Arcadia</h2>
                    <div class="row row-cols-2 align-items-center">
                        <div class="col text-justify">
                            <p>Niché près de la forêt enchantée de Brocéliande en Bretagne, France, le Zoo Arcadia est un sanctuaire pour la faune et un havre de paix pour les visiteurs depuis 1960. Sous la direction dévouée de notre directeur, José, nous nous efforçons de créer un environnement sûr et accueillant pour nos animaux, tout en offrant une expérience inoubliable à nos invités.</p>
                        </div>
                        <div class="col image-container-homepage">
                            <img class="w-100 rounded img-homepage" src="/Média/bg-avis.jpg" alt="">
                        </div>
                    </div>
                    <div class="text-center pt-4">
                        <a href="" class="btn btn-primary">Visiter le parc</a>
                    </div>
                </div>
            </article>

            <article class="bg-black text-white">
                <div class="container p-4">
                    <h2 class="text-center text-primary">Nos animaux</h2>
                    <div class="row row-cols-2 align-items-center">
                        <div class="col image-container-homepage">
                            <img class="w-100 rounded img-homepage" src="/Média/lajungleV2.jpg" alt="">
                        </div>
                        <div class="col text-justify">
                            <p>Le Zoo Arcadia abrite une diversité d'animaux, soigneusement répartis en trois habitats distincts qui imitent leur environnement naturel : la Savane, la Jungle et les Marais. Chaque habitat offre un aperçu unique de la vie de ses résidents, des majestueux éléphants et girafes élancées de la savane aux singes malicieux et oiseaux tropicaux colorés de la jungle, en passant par les crocodiles discrets et flamants roses élégants des marais.</p>
                        </div>
                    </div>
                    <div class="text-center pt-4">
                        <a href="/galerie" class="btn btn-primary">Voir les habitats</a>
                    </div>
                </div>
            </article>

            <article>
                <div class="container p-4">
                    <h2 class="text-center text-primary">Les services</h2>
                    <div class="row row-cols-2 align-items-center">
                        <div class="col text-justify">
                            <p>Pour améliorer votre visite, le Zoo Arcadia propose une variété de services. Dégustez de délicieux repas dans nos restaurants ou profitez de nos aires de pique-nique et distributeurs de snacks pour une pause gourmande. Partez à la découverte des habitats avec nos guides expérimentés lors de visites gratuites et immersives. Pour une expérience unique, montez à bord de notre petit train et laissez-vous transporter à travers les merveilles du zoo.</p>
                        </div>
                        <div class="col image-container-homepage">
                            <img class="w-100 rounded img-homepage" src="/Média/lajungle.jpg" alt="">
                        </div>
                    </div>
                    <div class="text-center pt-4">
                        <a href="" class="btn btn-primary">En savoir plus</a>
                    </div>
                </div>
            </article>


            <!-- Avis -->
            <article class="bg-black text-white">
                <div class="container p-4">
                    <h2 class="text-center text-primary">Les avis</h2>
                    <div class="align-items-center">

                        <div class="col text-justify">
                            <div>

                            <!-- Avis - back -->
                                    <?php
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

                                        try {
                                            $sql = "select * from commentaires ORDER BY id DESC";
                                            $sth = $cx->prepare($sql);
                                            $sth->execute();
                                            $result = $sth->fetchAll();

                                            //Afficher les 3 derniers commentaires
                                            $count = 0;
                                            foreach($result as $k => $v) {
                                                if ($v["etat"]){
                                                    if ($count < 1) {
                                                        $date_creation = date("d/m/Y", strtotime($v["date_creation"]));
                                                        echo "
                                                        <div class='commentaire card m-5'>
                                                            <div class='commentaire-text card-body'>
                                                                <h3 class='commentaire-nom card-title'>" . $v["nom"] . "</h3>
                                                                <p class='commentaire-date card-subtitle'> Posté le $date_creation</p>
                                                                <p class='commentaire-message card-text pt-3'>" . $v["commentaire"] . "</p>
                                                            </div>
                                                        </div>";
                                                        $count++;
                                                    } else {
                                                        //les commentaires supp seront cachés par défaut
                                                        echo "<div class='commentaire card m-5 hidden'>
                                                                    <div class='commentaire-text card-body'>
                                                                        <h3 class='commentaire-nom card-title'>" . $v["nom"] ."</h3>
                                                                        <p class='commentaire-date card-subtitle'>Posté le $date_creation</p>
                                                                        <p class='commentaire-message card-text pt-3'>" . $v["commentaire"] . "</p>
                                                                    </div>
                                                                </div>";
                                                    }
                                                }
                                            }

                                            //Bouton pour voir tous les avis
                                            echo "<button class='button btn btn-primary' id='voir-plus'>Voir plus</button>";
                                            echo "<button class='button btn btn-primary' id='voir-moins' style='display: none;'>Voir moins</button>";
                                            
                                        } catch (PDOException $e) {
                                            echo "Erreur : " . $e->getMessage() . "</br>";
                                            die();
                                        }
                                    ?>
                            </div>
                        </div>


                    </div>

                    
                    <div class="text-center pt-4">
                        <a href="/pages/avis/avis.php" class="btn btn-primary">Laissez un avis</a>
                    </div>
                
                    <div class="text-center pt-4">
                        <a href="/pages/avis/admin_avis.php" class="btn btn-primary">Admin avis</a>
                    </div>

                </div>
            </article>

        </section>

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



<!-- Js bouton voir plus voir moins - Avis -->
    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Sélectionner le bouton "Voir tous les avis"
                        const voirPlusButton = document.getElementById('voir-plus');
                        const voirMoinsButton = document.getElementById('voir-moins');

                        // Ajouter un écouteur d'événement sur le clic du bouton
                        voirPlusButton.addEventListener('click', function() {
                            // Sélectionner tous les commentaires cachés et les afficher
                            const commentairesCaches = document.querySelectorAll('.commentaire.hidden');
                            commentairesCaches.forEach(function(commentaire) {
                                commentaire.classList.remove('hidden');
                            });

                            // Cacher le bouton "Voir tous les avis" après l'affichage des commentaires
                            voirPlusButton.style.display = 'none';
                            voirMoinsButton.style.display = 'block';
                        });

                        voirMoinsButton.addEventListener('click', function(){
                            const commentaireVisible = document.querySelectorAll('.commentaire:not(.hidden)');
                            commentaireVisible.forEach(function(commentaire, index){
                                if (index >= 1) {
                                    commentaire.classList.add('hidden');
                                }
                            });

                            // Cacher le bouton "Voir tous les avis" après l'affichage des commentaires
                            voirPlusButton.style.display = 'block';
                            voirMoinsButton.style.display = 'none';
                        })

                    });
        </script>
    



</body>
</html>