<?php
require_once '../Templates/header.php';
require_once '../classes/Database.php';
require_once '../classes/Book.php';

$db = new Database();
$book = new Book($db->getConnection());

if (!isset($_POST['supprimer'])) {
    $id_livre = $_GET['id_livre'];
    $data = $book->getBookById($id_livre);
    ?>

    <!-- Affichage des détails du livre et du formulaire de confirmation -->
    <form action="gestion_delete_book.php" method="post" class='neumorphic-card-delete'>

        <th >
            <legend class='delete-action-title'><b>Supprimer ce livre ?</b></legend>
            <p class='neumorphic-btn'><a  href="gestion_livres.php">Retour</a></p>
        </th>
        <table class='neumorphic-card-delete'>
            <tr class='centre'>

                <td class='centre delete-title' >
                    <?=$data['titre']?>
                </td>
            </tr>
            <tr class='centre'>

                <td class='centre'>
                    <img src="../uploads/<?=$data['couverture']?>" alt="Couverture du livre" style="max-width: 250px; max-height: 250px; border-radius: 12px">
                </td>
            </tr>
            <tr style='margin-top: 30px;'>
                <td >Auteur: </td>
                <td>
                    <?=$data['auteur']?>
                </td>
            </tr>

            <tr>
                <td>Editeur: </td>
                <td>
                    <?=$data['editeur']?>
                </td>
            </tr>

            <tr>
                <td>Année: </td>
                <td>
                    <?=$data['annee']?>
                </td>
            </tr>

            <tr>
                <td>Commentaire: </td>
                <td>
                    <?=$data['commentaire']?>
                </td>
            </tr>





            <tr>
                <td>Catégorie: </td>
                <td>
    <?php
// Récupérez le nom de la catégorie à partir de son ID
    $categorie_name = $book->getCategoryById($data['categorie_id']);
    echo $categorie_name['name'];
    ?>
                </tr>
            </table>
            <!-- ... autres champs -->
            <input type="hidden" name="id_livre" value="<?=$id_livre?>">
            <input type="submit" value="supprimer" name="supprimer" class='neumorphic-btn'>
                </form>


<?php
} else {
    // Traitement de la suppression
    $id_livre = $_POST['id_livre'];
    $result = $book->deleteBook($id_livre);

    if (!$result) {
        echo "Un problème est survenu, votre livre n'a pas été supprimé!";
    } else {
        echo "Votre livre a bien été supprimé";
        header("Location: gestion_livres.php");
    }
}
?>
