<?php
$pdo = new PDO('mysql:host=localhost;dbname=chalet_card;', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    // Requête pour récupérer les informations des chalets
    $sql = "SELECT * FROM reservations";
    $resultat = $pdo->query($sql);

    // Vérifier si des résultats ont été obtenus
    if ($resultat->rowCount() > 0) {
        // Parcourir les résultats et afficher les informations des chalets
        while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
            $chalet_id = $row['chalet_id'];
            $dateReservation = $row['date_reservation'];
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $email = $row['email'];
            $telephone = $row['telephone'];
            $nombrePersonne = $row['nombre_personnes'];

            // Afficher les informations du chalet à la place de "<main key={card.id}>"
            echo "<h2>$chalet_id</h2>";
            echo "<p class='adress__chalet'>$dateReservation</p>";
            echo "<p class='description__chalet'>$nom</p>";
            echo "<p class='description__chalet'>$prenom</p>";
            echo "<p class='description__chalet'>$email</p>";
            echo "<p class='description__chalet'>$telephone</p>";
            echo "<p class='description__chalet'>$nombrePersonne</p>";
        }
    } else {
        echo "Aucun chalet trouvé dans la base de données.";
    }
    ?>
</body>
</html>