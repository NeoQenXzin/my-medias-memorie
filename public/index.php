<?php
require_once '../classes/Book.php'; // Assurez-vous que le chemin est correct
require_once '../Templates/header.php';
require_once '../classes/Database.php';
$db = new Database();
$book = new Book($db->getConnection()); // Assurez-vous que $db est correctement défini
$categories = $book->getAllCategories();
?>

<div class="container-create-form">



    <form action="insertion.php" method="post" enctype="multipart/form-data" class='neumorphic-card'>

            <legend>
            <h1>Enregistrer votre livre 📙</h1>
            </legend>

            <table>
                <tr>
                    <td>Titre :</td>
                    <td><input class='neumorphic-input' type="text" name="titre" size="50" maxlength ="50"></td>
                </tr>
                <tr>
                    <td>Auteur :</td>
                    <td><input class='neumorphic-input' type="text" name="auteur" size="50" maxlength ="50"></td>
                </tr>
                <tr>
                    <td>Année :</td>
                    <td><input class='neumorphic-input' type="text" name="annee" size="50" maxlength ="50"></td>
                </tr>
                <tr>
                    <td>Editeur :</td>
                    <td><input class='neumorphic-input' type="text" name="editeur" size="50" maxlength ="50"></td>
                </tr>
                <tr>
                    <td>Commentaire :</td>
                    <td><input class='neumorphic-input' type="text" name="commentaire" size="50" maxlength ="450"></td>
                </tr>
                <tr>
                    <td>Couverture :</td>
                    <td><input class='neumorphic-input' type="file" name="couverture"></td>
                </tr>
                <tr class='categorie-tr'>
                    <br><br>
                    <td >Catégorie: </td>
                        <td>
                            <select name="categorie">

                                <?php foreach ($categories as $categorie): ?>
                                    <option value="<?=$categorie['id']?>"><?=$categorie['name']?></option>
                                <?php endforeach;?>
                            </select>
                        </td>
                    </tr>
                <tr class='form-buttons-container'>
                    <td><input class='neumorphic-input' type="reset" name="effacer" value="Effacer"></td>
                    <td><input class='neumorphic-input' type="submit" name="enregistrer" value="Enregistrer"></td>
                </tr>
            </table>

    </form>
    </div>
</body>
</html>