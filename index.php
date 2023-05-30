<?php 
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motDePasse = "";
$baseDeDonnees = "chalet_card";

try {
    // Création de l'objet PDO pour la connexion à la base de données
    $connexion = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);

    // Configuration des options PDO
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CozyCabins</title>

    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/chalet_card.css">
    <link rel="stylesheet" href="style/calendrier.css">
    <link rel="stylesheet" href="style/popup.css">
</head>
<body>
  <?php
    // Requête pour récupérer les informations des chalets
    $sql = "SELECT * FROM chalets";
    $resultat = $connexion->query($sql);

    // Vérifier si des résultats ont été obtenus
    if ($resultat->rowCount() > 0) {
        // Parcourir les résultats et afficher les informations des chalets
        while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
            $idChalet = $row['id'];
            $nomChalet = $row['nom'];
            $adresseChalet = $row['adresse'];
            $descriptionChalet = $row['description'];

            // Afficher les informations du chalet à la place de "<main key={card.id}>"
            echo "<main key=$idChalet>";
            echo "<img src='chemin/vers/image.jpg' alt='images des chalet' />";
            echo "<div class='title__group_infos'>";
            echo "<h2>$nomChalet</h2>";
            echo "<button class='show_photos'>Voir photos</button>";
            echo "</div>";
            echo "<p class='adress__chalet'>$adresseChalet</p>";
            echo "<p class='description__chalet'>$descriptionChalet</p>";

            echo "<div class='calendar'>";
            echo "<div class='controls'>";
            echo "<button id='previous'>Précédent</button>";
            echo "<span id='currentMonthYear'></span>";
            echo "<button id='next'>Suivant</button>";
            echo "</div>";
            echo "<table id='calendarTable' class='calendarTable_$idChalet'></table>";
            echo "</div>";
            echo "</main>";
        }
    } else {
        echo "Aucun chalet trouvé dans la base de données.";
    }
  } catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
  }
?>
  <div class="popup" id="popup">
      <div class="popup-content">
          <form action="/api/formulaire.php">
              <label for="nom">Nom :</label>
              <input type="text" id="nom" name="nom" required>
          
              <label for="prenom">Prénom :</label>
              <input type="text" id="prenom" name="prenom" required>
          
              <label for="email">Adresse e-mail :</label>
              <input type="email" id="email" name="email" required>
          
              <label for="telephone">Numéro de téléphone :</label>
              <input type="tel" id="telephone" name="telephone" required>
          
              <label for="nombre_personnes">Nombre de personnes :</label>
              <input type="number" id="nombre_personnes" name="nombre_personnes" required>
          
              <label for="petit_dejeuner">Petit-déjeuner compris :</label>
              <input type="checkbox" id="petit_dejeuner" name="petit_dejeuner">
          
              <label for="repas">Repas compris :</label>
              <input type="checkbox" id="repas" name="repas">
          
              <label for="spa">Accès au spa :</label>
              <input type="checkbox" id="spa" name="spa">
          
              <label for="all_in">All-in :</label>
              <input type="checkbox" id="all_in" name="all_in">
          
              <input type="submit" value="Soumettre" id="button_submit">
          </form>
          <button class="close-btn">Fermer</button>
      </div>
  </div>
  <script src="script.js"></script>
</body>
</html>