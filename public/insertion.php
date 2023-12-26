<?php
require_once '../classes/Database.php';
require_once '../classes/Book.php';

$db = new Database();
$book = new Book($db->getConnection());

// Récupérer la liste des catégories depuis la base de données
$categories = $book->getAllCategories();

if (isset($_POST['enregistrer'])) {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $editeur = $_POST['editeur'];
    $annee = $_POST['annee'];
    $commentaire = $_POST['commentaire'];
    $categorie_id = $_POST['categorie']; // Récupérer la catégorie sélectionnée

    // Utilisez $_FILES pour traiter les fichiers uploadés
    $couverture = $_FILES['couverture']['name']; // Le nom du fichier, ajustez selon votre besoin

    // Vérification du fichier uploadé
    if (isset($_FILES['couverture']) && $_FILES['couverture']['error'] === UPLOAD_ERR_OK) {

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif']; // Ajoutez les extensions autorisées

        $fileExtension = strtolower(pathinfo($_FILES['couverture']['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo 'Extension de fichier non autorisée. Veuillez choisir un fichier valide.';
            exit;
        }

        // Débogage : afficher la valeur de $titre
        echo 'Titre avant traitement : ' . $titre . '<br>';

// Générer un nom de fichier en remplaçant les espaces et les apostrophes par des tirets
        $nomFichier = preg_replace('/[^a-zA-Z0-9]/', '-', $titre) . '_cover.' . $fileExtension;

// Débogage : afficher la valeur de $nomFichier
        echo 'Nom du fichier après traitement : ' . $nomFichier . '<br>';

// Supprimer les accents du nom de fichier
        $nomFichier = iconv('UTF-8', 'ASCII//TRANSLIT', $nomFichier);
        $cheminFichier = '../uploads/' . $nomFichier;
        move_uploaded_file($_FILES['couverture']['tmp_name'], $cheminFichier);
    } else {
        echo 'Veuillez choisir un fichier valide svp.';
        exit;
    }

    if (!empty($titre) && !empty($auteur) && !empty($editeur) && !empty($annee) && !empty($commentaire) && !empty($categorie_id)) {
        $data = array(
            ':titre' => $titre,
            ':auteur' => $auteur,
            ':editeur' => $editeur,
            ':annee' => $annee,
            ':commentaire' => $commentaire,
            ':couverture' => $nomFichier,
            ':categorie_id' => $categorie_id,
        );

        $result = $book->insertBook($data);

        if (!$result) {
            echo 'Un problème est survenu.';
        } else {
            echo "<script type=\"text/javascript\">alert('Votre livre est bien enregistré, votre livre est : " . $titre . "')</script>";
            header("Location:gestion_livres.php");
        }
    } else {
        echo 'Tous les champs sont requis';
    }
}
