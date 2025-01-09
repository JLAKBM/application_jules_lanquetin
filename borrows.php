<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos emprunts</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">

<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    header {
   
        color: #fff;
        text-align: center;
        padding: 1em 0;
    }

    .container {
        width: 80%;
        margin: auto;
        overflow: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {

        color: #fff;
    }

    .book-image {
        max-width: 100px; /* Ajustez la taille maximale de l'image selon vos besoins */
        height: auto;
    }

    button {
 
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
</style>

<!-- Ajoutez des médias requêtes pour le style responsive -->
<style>
    @media (max-width: 768px) {
        .container {
            width: 100%;
        }

        table {
            font-size: 14px;
        }

        .book-image {
            max-width: 50px;
        }
    }
</style>
</head>
<body>
<header>
        <h1>Liste de vos Emprunts</h1>
    </header>

    <div class="container">
        <!-- Affichage des livres depuis la base de données -->
        <?php
        require('config.php');

        $query = "SELECT * FROM emprunts LEFT JOIN livres ON livres.id=id_livre WHERE id_utilisateur = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':id' => $_SESSION['user_id']));

        if ($stmt) {
            echo "<table>";
            echo "<tr><th>Image</th><th>Titre</th><th>Auteur</th><th>Date de publication</th><th>Date d'emprunt'</th><th>Date de retour</th><th>Action</th></tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo '<td><img class="book-image" src="' . $row['photo_url'] . '" alt="' . $row['titre'] . '"></td>';
                echo "<td>{$row['titre']}</td>";
                echo "<td>{$row['auteur']}</td>";
                echo "<td>{$row['date_publication']}</td>";
                echo "<td>{$row['date_emprunt']}</td>";
                echo "<td>{$row['date_retour']}</td>";
                echo $row['returned'] == 1 ? "<td>Retourné</td>" : '<td><a href="return-book.php?id=' . $row['id'] . '">Retourner</a></td>';
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Erreur lors de la récupération des livres.";
        }
        ?>
        
    </div>
</body>
</html>