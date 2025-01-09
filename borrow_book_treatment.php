<?php

require('config.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $query = "SELECT * FROM livres WHERE id = :id AND statut = 'disponible'";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array(':id' => $_POST['id-book-to-borrow']));

    if ($stmt->rowCount() > 0) {

        $query = "UPDATE livres SET statut = 'emprunté' WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':id' => $_POST['id-book-to-borrow']));

        $back_time = new DateTime();
        $back_time->add(new DateInterval('P1M')); //Où 'P12M' indique 'Période de 12 Mois'

        $query = "INSERT INTO emprunts (id_livre,id_utilisateur,date_retour) VALUES (:id, :id_user, :back)";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':id' => $_POST['id-book-to-borrow'], ':id_user' => $_SESSION['user_id'], ':back' => $back_time->format('Y-m-d')));

        header('Location: borrow_book.php?borrow=1&id='.$_POST['id-book-to-borrow']);
    }
    else {
        header('Location: borrow_book.php?borrow=0&id='.$_POST['id-book-to-borrow']);
    }
}

?>