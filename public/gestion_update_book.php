<?php
require_once '../Templates/header.php';
require_once '../classes/Database.php';
require_once '../classes/Book.php';

$db = new Database();
$book = new Book($db->getConnection());

if (!isset($_POST['modif'])) {
    $id_livre = $_GET['id_livre'];
    $data = $book->getBookById($id_livre);
    $categories = $book->getAllCategories();
    ?>



<form action="gestion_update_book.php" method="post" enctype="multipart/form-data" class='neumorphic-card-delete'>
<th >
            <legend class='delete-action-title'><b>Modifier votre livre</b></legend>
            <p class='neumorphic-btn'><a  href="gestion_livres.php">Retour</a></p>
        </th>
            <table class='neumorphic-card centre'>
                <tr class='neumorphic-input centre'>
                    <td >Titre: </td>
                    <td>
                        <input class='input-update' type="text" name="titre" size="100" value="<?=$data['titre']?>">
                    </td>
                </tr>
                <tr class='neumorphic-input centre'>
                    <td>Auteur: </td>
                    <td>
                        <input class='input-update' type="text" name="auteur" size="100" value="<?=$data['auteur']?>">
                    </td>
                </tr>

                <tr class='neumorphic-input centre'>
                    <td>Editeur: </td>
                    <td>
                        <input  class='input-update' type="text" name="editeur" size="100" value="<?=$data['editeur']?>">
                    </td>
                </tr>

                <tr class='neumorphic-input centre'>
                    <td>Année: </td>
                    <td>
                        <input class='input-update' type="text" name="annee" size="100" value="<?=$data['annee']?>">
                    </td>
                </tr>

                <tr class='neumorphic-input centre'>
                    <td>Commentaire: </td>
                    <td>
                        <input class='input-update' type="text" name="commentaire" size="100" value="<?=$data['commentaire']?>">
                    </td>
                </tr>
<tr class='neumorphic-input start'>

    <td>Couverture: </td>
    <td>
        <!-- Affichez l'image actuelle -->
        <img src="../uploads/<?=$data['couverture']?>" alt="Couverture actuelle" style="max-width: 200px; max-height: 200px;">
        <br>
        <!-- Champ pour le nouveau fichier de couverture -->
        <input type="file" name="nouvelle_couverture">
    </td>
</tr>
                    <tr class='neumorphic-input start'>
                    <td>Catégorie: </td>
                    <td>
                        <select name="categorie">
                            <?php
foreach ($categories as $categorie) {
        $selected = ($categorie['id'] == $data['categorie_id']) ? 'selected' : '';
        echo "<option value=\"{$categorie['id']}\" {$selected}>{$categorie['name']}</option>";
    }
    ?>
                        </select>
                    </td>
                </tr>

                <tr class='centre' style='margin-top: 50px'>
                    <td>
                        <!-- <input type="reset" value="effacer" class='neumorphic-btn'style='margin-right: 30px'> -->
                        <input type="submit" value="Enregistrer" name="modif" class='neumorphic-btn'>
                    </td>
                </tr>

            </table>


        <!-- Champs cacher permettant de récupérer l'id pour upload la bdd -->
        <input type="hidden" name="id_livre" value="<?=$id_livre?>">
</form>

<?php
$book->closeCursor(); // Libère notre connection et permet ainsi a d'autre requête d'être executées par sql
} elseif (isset($_POST['titre']) && isset($_POST['auteur']) && isset($_POST['editeur']) && isset($_POST['commentaire']) && isset($_POST['annee'])) {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $editeur = $_POST['editeur'];
    $annee = $_POST['annee'];
    $commentaire = $_POST['commentaire'];
    $categorie_id = $_POST['categorie']; // Récupérer la catégorie sélectionnée
    $id_livre = $_POST['id_livre'];

    $data = array(
        ':titre' => $titre,
        ':auteur' => $auteur,
        ':editeur' => $editeur,
        ':annee' => $annee,
        ':commentaire' => $commentaire,
        ':categorie_id' => $categorie_id, // Ajoutez cette ligne pour la catégorie
        ':id_livre' => $id_livre,
    );

    $result = $book->updateBook($data);

    if (!$result) {
        echo "Un problème est survenu, les modifications n'ont pas été faites!";
    } else {
        echo "Vos modifications ont été bien effectuées";
        // Redirection
        header("Location:gestion_livres.php");
    }
} else {
    echo 'Modifiez vos coordonnées';
}
