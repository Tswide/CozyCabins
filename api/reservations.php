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

    // Vérifier si les paramètres chalet_id et date_reservation sont présents dans la requête GET
    if (isset($_GET['chalet_id']) && isset($_GET['date_reservation'])) {
        $chaletId = $_GET['chalet_id'];
        $dateReservation = $_GET['date_reservation'];

        // Requête pour vérifier si une réservation existe pour l'ID du chalet et la date donnée
        $sql = "SELECT * FROM reservations WHERE chalet_id = :chalet_id AND date_reservation = :date_reservation";
        $requete = $connexion->prepare($sql);
        $requete->bindParam(':chalet_id', $chaletId);
        $requete->bindParam(':date_reservation', $dateReservation);
        $requete->execute();
        $reservationExists = $requete->rowCount() > 0;

        // Renvoyer la réponse (true si une réservation existe, false sinon)
        header('Content-Type: text/plain');
        echo $reservationExists ? 'true' : 'false';
    } else {
        // Renvoyer une erreur si les paramètres chalet_id et date_reservation ne sont pas spécifiés
        header('HTTP/1.1 400 Bad Request');
        echo "Les paramètres chalet_id et date_reservation sont requis.";
    }
} catch (PDOException $e) {
    // Renvoyer une erreur en cas de problème de connexion à la base de données
    header('HTTP/1.1 500 Internal Server Error');
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>
