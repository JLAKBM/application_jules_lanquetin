<?php

$query = "SELECT * FROM emprunts WHERE id_utilisateur = :id AND returned = 0 AND DATEDIFF(now(), date_retour) <= 0";
$stmt = $pdo->prepare($query);
$stmt->execute(array(':id' => $_SESSION['user_id']));
$emprunt = $stmt->fetch();
?>

<header>

<?php
if ($stmt->rowCount() > 0) {
    echo "<h1 style='color:red;background:white'>Certains des livres que vous avez empruntés ont dépassé leur date de retour maximale !<h2>";
}
?>

</header>