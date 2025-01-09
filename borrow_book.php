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
    <title>Emprunter un livre</title>
</head>
<body>
    <section>
        <div>
            <p>Titre :</p>
            <p><?= htmlspecialchars($book['titre']); ?></p>
        </div>

        <div>
            <p>Auteur :</p>
            <p><?= htmlspecialchars($book['auteur']); ?></p>
        </div>

        <div>
            <p>Date de publication :</p>
            <p><?= htmlspecialchars($book['date_publication']); ?></p>
        </div>

        <div>
            <p>Description :</p>
            <p><?= htmlspecialchars($book['description']); ?></p>
        </div>

        <div>
            <img src="<?= htmlspecialchars($book['photo_url']); ?>" alt="">
        </div>
    </section>

    <?php if (!isset($_GET['borrow'])) { ?>
    <form action="borrow_book_treatment.php" method="post">
        <input type="hidden" name="id-book-to-borrow" value="<?= htmlspecialchars($book['id']); ?>">
        <input type="submit" value="Emprunter ce livre.">
    </form>
    <?php } elseif ($_GET['borrow'] == 0) { ?>
        <p>Ce livre n'est pas disponible.</p>
    <?php } elseif ($_GET['borrow'] == 1) { 
        $query = "SELECT * FROM emprunts WHERE id_livre = :id AND id_utilisateur = :id_user ORDER BY id DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':id' => $_GET['id'], ':id_user' => $_SESSION['user_id']));
        $emprunt = $stmt->fetch();
        ?>    
        <p>Vous avez emprunté le livre "<?= htmlspecialchars($book['titre']); ?>". La date de retour maximale est le <?= htmlspecialchars($emprunt['date_retour']); ?></p>
    <?php } ?>    

    <a href="book_details.php?id=<?= htmlspecialchars($book['id']); ?>">Retour</a>
</body>
</html>