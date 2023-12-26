<?php

class Book
{
    private $db;
    private $stmt;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllBooks()
    {
        $query = "SELECT * FROM livres ORDER BY id_livre ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookById($id_livre)
    {
        $query = "SELECT * FROM livres WHERE id_livre = :id_livre";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_livre', $id_livre);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertBook($data)
    {
        $query = "INSERT INTO livres(titre, auteur, editeur, annee, commentaire, couverture, categorie_id) VALUES (:titre, :auteur, :editeur, :annee, :commentaire, :couverture, :categorie_id)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    public function updateBook($data)
    {
        $query = "UPDATE livres SET titre=:titre, auteur=:auteur, editeur=:editeur, annee=:annee, commentaire=:commentaire, categorie_id=:categorie_id";

        // Vérifiez si un nouveau fichier de couverture a été téléchargé
        if (!empty($_FILES['nouvelle_couverture']['name'])) {
            $query .= ", couverture=:nouvelle_couverture";
            $data[':nouvelle_couverture'] = $this->uploadCover();
        }

        $query .= " WHERE id_livre=:id_livre";

        $stmt = $this->db->prepare($query);

        // Bind des paramètres
        $stmt->bindValue(':titre', $data[':titre']);
        $stmt->bindValue(':auteur', $data[':auteur']);
        $stmt->bindValue(':editeur', $data[':editeur']);
        $stmt->bindValue(':annee', $data[':annee']);
        $stmt->bindValue(':commentaire', $data[':commentaire']);
        $stmt->bindValue(':categorie_id', $data[':categorie_id']);

        // Ajoutez la vérification si un nouveau fichier de couverture a été téléchargé
        if (!empty($_FILES['nouvelle_couverture']['name'])) {
            $stmt->bindValue(':nouvelle_couverture', $data[':nouvelle_couverture']);
        }

        $stmt->bindValue(':id_livre', $data[':id_livre']);

        return $stmt->execute();
    }

    private function uploadCover()
    {
        $upload_dir = '../uploads/';
        $upload_file = $upload_dir . basename($_FILES['nouvelle_couverture']['name']);

        // Vérification que le fichier est une image
        $image_info = getimagesize($_FILES['nouvelle_couverture']['tmp_name']);
        if (!$image_info) {
            // Gestion des erreurs d'upload
            return 'Le fichier n\'est pas une image valide.';
        }

        // Vérification de la taille du fichier
        $max_file_size = 10 * 1024 * 1024; // 10 Mo
        if ($_FILES['nouvelle_couverture']['size'] > $max_file_size) {
            return 'Le fichier est trop volumineux. La taille maximale autorisée est de 10 Mo.';
        }

        // Nettoyage du nom du fichier
        $clean_filename = preg_replace('/[^a-zA-Z0-9_.-]/', '', $_FILES['nouvelle_couverture']['name']);
        $upload_file = $upload_dir . $clean_filename;

        if (move_uploaded_file($_FILES['nouvelle_couverture']['tmp_name'], $upload_file)) {
            return $clean_filename;
        } else {
            // Gestion des erreurs d'upload
            return 'Une erreur s\'est produite lors du téléchargement du fichier.';
        }
    }

    public function deleteBook($id_livre)
    {
        $requete = $this->db->prepare("DELETE FROM livres WHERE id_livre = :id_livre");

        // Suppression du fichier de couverture
        $this->deleteCoverFile($book_data['couverture']);

        $requete->bindValue(':id_livre', $id_livre);
        $result = $requete->execute();

        return $result;
    }

    private function deleteCoverFile($filename)
    {
        // Chemin vers le dossier d'upload
        $upload_path = '../uploads/';

        // Construction du chemin complet du fichier de couverture
        $cover_path = $upload_path . $filename;

        // Vérifie si le fichier existe avant de le supprimer
        if (file_exists($cover_path)) {
            unlink($cover_path);
        }
    }

    public function getAllCategories()
    {
        $query = "SELECT id, name FROM categories";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCategoryById($categorie_id)
    {
        $query = "SELECT name FROM categories WHERE id = :categorie_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':categorie_id', $categorie_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function closeCursor()
    {
        if ($this->stmt) {
            $this->stmt->closeCursor();
        }
    }
}
