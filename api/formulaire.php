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

    echo 'debut';

    // Vérifier si les paramètres chalet_id et date_reservation sont présents dans la requête GET
    if (isset($_GET['chalet_id']) && isset($_GET['date_reservation']) && isset($_GET['nom'])
    && isset($_GET['prenom']) && isset($_GET['email']) && isset($_GET['telephone']) 
    && isset($_GET['nombre_personnes']) && isset($_GET['petit_dejeuner']) && isset($_GET['repas'])
    && isset($_GET['spa']) && isset($_GET['all_in'])) {
        $chaletId = $_GET['chalet_id'];
        $dateReservation = $_GET['date_reservation'];
        $nom = $_GET['nom'];
        $prenom = $_GET['prenom'];
        $email = $_GET['email'];
        $telephone = $_GET['telephone'];
        $nombrePersonnes = $_GET['nombre_personnes'];
        $petitDejeuner = $_GET['petit_dejeuner'];
        $repas = $_GET['repas'];
        $spa = $_GET['spa'];
        $allIn = $_GET['all_in'];
        echo 'requete sql';
        // Requête d'insertion des données dans la table "reservations"
        $sql = "INSERT INTO reservations (chalet_id, date_reservation, nom, prenom, email, telephone, nombre_personnes, petit_dejeuner, repas, spa, all_in)
                VALUES (:chalet_id, :date_reservation, :nom, :prenom, :email, :telephone, :nombre_personnes, :petit_dejeuner, :repas, :spa, :all_in)";

        $requete = $connexion->prepare($sql);
        $requete->bindParam(':chalet_id', $chaletId);
        $requete->bindParam(':date_reservation', $dateReservation);
        $requete->bindParam(':nom', $nom);
        $requete->bindParam(':prenom', $prenom);
        $requete->bindParam(':email', $email);
        $requete->bindParam(':telephone', $telephone);
        $requete->bindParam(':nombre_personnes', $nombrePersonnes);
        $requete->bindParam(':petit_dejeuner', $petitDejeuner, PDO::PARAM_INT);
        $requete->bindParam(':repas', $repas, PDO::PARAM_INT);
        $requete->bindParam(':spa', $spa, PDO::PARAM_INT);
        $requete->bindParam(':all_in', $allIn, PDO::PARAM_INT);

       // Exécuter la requête d'insertion
        if ($requete->execute()) {
            // La réservation a été enregistrée avec succès
            echo 'true';
        } else {
            // Une erreur s'est produite lors de l'enregistrement de la réservation
            header('HTTP/1.1 500 Internal Server Error');
            echo "Erreur lors de l'enregistrement de la réservation.";
        }
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>
