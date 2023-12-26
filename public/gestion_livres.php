<?php
require_once '../Templates/header.php';
require_once '../classes/Database.php';
require_once '../classes/Book.php';

$db = new Database();
$book = new Book($db->getConnection());

$books = $book->getAllBooks();

if ($books) {
    $nbre_livres = count($books);
} else {
    echo 'Not working';
}

?>
<div class="container-gestion-form">
<h1>Gestion de mes livres</h1>


<p>Il y a <?php echo $nbre_livres ?> livres enregistrés dans votre base de données</p>

<table class='neumorphic-card'>
    <tr class="neumorphic-input gestion-tr-title">
        <th>Numéro</th>
        <th>Titre</th>
        <th>Auteur</th>
        <th>Couverture</th>
        <th>Année de parution</th>
        <th>Editeur</th>
        <th>Commentaire</th>
        <th>Catégorie</th>
        <th>Modifier</th>
        <th>Supprimer</th>
    </tr>

    <?php
foreach ($books as $livre) {
    echo "<tr class='neumorphic-input-gestion'>";
    foreach ($livre as $key => $valeur) {
        if ($key === 'couverture') {
            if (!empty($valeur)) {
                // Afficher l'image en utilisant le chemin du dossier d'upload général
                $cover = urlencode($valeur);
                $dossierLivre = '../uploads';
                echo "<td><img src='$dossierLivre/$cover' alt='Couverture' style='width: 50px; height: 50px;'></td>";
            } else {
                echo "<td></td>"; // Si pas de couverture, afficher une cellule vide
            }
        } elseif ($key === 'categorie_id' && !empty($valeur)) {
            $categorie = $book->getCategoryById($valeur);
            echo "<td>{$categorie['name']}</td>";
        } else {
            echo "<td>$valeur</td>";
        }
    }

    ?>
    <td>
        <!-- Je passe l'id via la méthode GET dans l'URL du lien vers le fichier modifier -->
        <button class='neumorphic-btn'><a href="gestion_update_book.php?id_livre=<?=$livre['id_livre']?>">Modifier</a></button>
    </td>
    <td>
        <!-- Je passe l'id via la méthode GET dans l'URL du lien vers le fichier supprimer -->
        <button class='neumorphic-btn'> <a href="gestion_delete_book.php?id_livre=<?=$livre['id_livre']?>">Supprimer</a></button>
    </td>
    <?php
echo "</tr>";
}
?>

</table>
</div>
<?php
// Pas besoin de closeCursor() car fetchAll() ferme automatiquement le curseur.
require_once '../Templates/footer.php';
?>
