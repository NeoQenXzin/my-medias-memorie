<?php
require_once '../Templates/header.php';
require_once '../classes/Database.php';
require_once '../classes/Book.php';

$db = new Database();
$book = new Book($db->getConnection());

$books = $book->getAllBooks();
?>

<h1 class='media-main-title'>Mes Médias</h1>

<div class="my-medias-container">



    <!-- Recupérer les paramètres de recherche -->
    <?php
// Récupérer les paramètres de recherche
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$author = isset($_GET['author']) ? $_GET['author'] : '';

// Utiliser la méthode searchBooks pour récupérer les livres filtrés
$filteredBooks = $book->searchBooks($search, $category, $author);

if ($filteredBooks === false) {
    // Afficher un message d'erreur si le titre contient moins de 2 lettres
    echo "Le titre doit contenir au moins 2 lettres.";
    exit; // Arrêter l'exécution du script
}

// Afficher les livres filtrés
foreach ($filteredBooks as $livre) {
    // ... (votre code d'affichage des livres)
}

?>
<!-- Affichage médias filtrer  -->
<!-- <div class="container"> -->
    <?php foreach ($filteredBooks as $livre): ?>
        <div class="book">
            <div class="title">
                <p><?=$livre['titre']?></p>
            </div>
            <div class="book-cover open-modal" data-book-id="<?=$livre['id_livre']?>" style="background: url('../uploads/<?=$livre['couverture']?>'); background-size: 100% 100%; background-repeat: no-repeat;">
                <div class="effect"></div>
                <div class="light"></div>
            </div>
            <div class="book-inside"></div>
            <a class="btn" href="gestion_update_book.php?id_livre=<?=$livre['id_livre']?>">Édit</a>
        </div>

         <!-- Code de la modale pour ce livre -->
    <div class="modal" id="modal-<?=$livre['id_livre']?>">
        <div class="modal-content">
            <!-- Affichez les informations du livre ici -->
        <form>
<table class='table-modal neumorphic-card-modal'>
    <tr class='centre'>

        <td class='centre modal-title' >
            <?=$livre['titre']?>
        </td>
    </tr>
    <tr class='centre'>

        <td class='centre'>
            <img src="../uploads/<?=$livre['couverture']?>" alt="Couverture du livre" style="max-width: 250px; max-height: 250px; border-radius: 12px">
        </td>
    </tr>
    <tr style='margin-top: 30px;'>
        <td >Auteur: </td>
        <td>
            <?=$livre['auteur']?>
        </td>
    </tr>

    <tr>
        <td>Editeur: </td>
        <td>
            <?=$livre['editeur']?>
        </td>
    </tr>

    <tr>
        <td>Année: </td>
        <td>
            <?=$livre['annee']?>
        </td>
    </tr>

    <tr>
        <td>Commentaire: </td>
        <td>
            <?=$livre['commentaire']?>
        </td>
    </tr>
    <tr>
        <td>Catégorie: </td>
        <td>
<?php
// Récupérez le nom de la catégorie à partir de son ID
$categorie_name = $book->getCategoryById($livre['categorie_id']);
echo $categorie_name['name'];
?>
        </tr>
    </table>

    <button class="close-modal neumorphic-btn">Fermer</button>
        </form>
        </div>
    </div>
        <?php endforeach;?>
    <!-- </div> -->
</div>
<!-- Search bar  -->
<div class="form-container">
    <form class='form' method="get" action="my-medias.php">
        <div class="form-field">
    <label class="input-group__label">Titre</label>
            <input class="input-group__input" type="text" name="search" placeholder="" />
            <label class="input-group__label">Catégorie</label>
            <select class="input-group__input" name="category">
                <option value=""></option>
                <?php
$categories = $book->getAllCategories();
foreach ($categories as $category) {
    $selected = ($category['id'] == $category) ? 'selected' : '';
    echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
}
?>
        </select>

        <label class="input-group__label">Auteur</label>
        <input  class="input-group__input" type="text" name="author" placeholder="" />
        <button class='button-search' type="submit">Rechercher</button>
    </div>
    </form>
</div>
</div>
