<?php
require('config.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$query = "SELECT * FROM livres WHERE livres.id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(array(':id' => $_GET['id']));
$book = $stmt->fetch();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <style>
         .book-image {
            max-width: 30%;
            height: auto;
            display: block;
            margin: 0 auto; /* Pour centrer l'image */
        }
        </style>
    <title>Emprunter un livre</title>
</head>
<body>
<header>
        <h1>Emprunter ce Livre</h1>
    </header>
    <div class="container">
        <div class="details">
            <?php if (isset($book)) : ?>
                <h3><?= htmlspecialchars($book['titre']); ?></h3>

                <?php echo '<img class="book-image" src="' . htmlspecialchars($book['photo_url']) . '" alt="' . htmlspecialchars($book['titre']) . '">';?>
                <p>Auteur : <?= htmlspecialchars($book['auteur']); ?></p>
                <p>Année de publication : <?= htmlspecialchars($book['date_publication']); ?></p>
                <p>ISBN : <?= htmlspecialchars($book['isbn']); ?></p>
                <!-- Ajoutez l'URL de l'image ici -->
                <p>URL de l'image : <?= htmlspecialchars($book['photo_url']); ?></p>
                <!-- Autres détails du livre à afficher ici -->
            <?php else : ?>
                <p>Livre non trouvé</p>
            <?php endif; ?>
        </div>
        <div class="back-button">
            <button class="btn btn-primary"  style="border-radius:0;" onclick="window.location.href = 'books.php'">Retour à la liste des livres</button>
        <?php if ($book['statut'] != "emprunté" && !isset($_GET['borrow'])) { ?>
            <form style="box-shadow:none; background:transparent" action="borrow_book_treatment.php" method="post">
                <input type="hidden" name="id-book-to-borrow" value="<?= htmlspecialchars($book['id']); ?>">
                <input class="btn btn-primary" style="border-radius:0;" type="submit" value="Emprunter ce livre.">
            </form>
        <?php } elseif ($_GET['borrow'] == 0) { ?>
        <p>Ce livre n'est pas disponible.</p>
        <?php } elseif ($_GET['borrow'] == 1) { 
            $query = "SELECT * FROM emprunts WHERE id_livre = :id AND id_utilisateur = :id_user ORDER BY id DESC";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(':id' => $_GET['id'], ':id_user' => $_SESSION['user_id']));
            $emprunt = $stmt->fetch();
            ?>    
            <button class="btn btn-primary"  style="border-radius:0;" onclick="window.location.href = 'borrows.php'">Vous avez emprunté le livre "<?= htmlspecialchars($book['titre']); ?>". La date de retour maximale est le <?= htmlspecialchars($emprunt['date_retour']); ?></button>
        <?php } ?>    

        </div>

    </div>
</html>