<?php

require('config.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {

    $query = "SELECT *,emprunts.id as id_emprunt FROM emprunts LEFT JOIN livres ON livres.id=id_livre WHERE id_utilisateur = :id AND livres.id=:id_livre AND statut = 'emprunté'";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array(':id' => $_SESSION['user_id'],':id_livre' => $_GET['id']));
    $emprunt = $stmt->fetch();

    if ($stmt->rowCount() > 0) {

        $query = "UPDATE livres SET statut = 'disponible' WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':id' => $_GET['id']));

        $query = "UPDATE emprunts SET returned = 1 WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':id' => $emprunt['id_emprunt']));
    }
    header('Location: borrows.php');
}

?>