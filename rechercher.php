<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rechercher un contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <a href="index.php">🏠 Accueil</a>
    <a href="ajouter.php">➕ Ajouter</a>
    <a href="rechercher.php">🔍 Rechercher</a>
</nav>

<h2>Liste des contacts</h2>

<form method="get">
    <input type="text" name="search" placeholder="Rechercher un nom ou prénom">
    <input type="submit" value="Rechercher">
</form>

<?php
include 'connexion.php';
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM contacts WHERE nom LIKE '%$search%' OR prenom LIKE '%$search%'";
$result = mysqli_query($conn, $sql);

echo "<table>
<tr><th>Nom</th><th>Prénom</th><th>Téléphone</th><th>Email</th><th>Photo</th><th>Actions</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['nom']}</td>
            <td>{$row['prenom']}</td>
            <td>{$row['telephone']}</td>
            <td>{$row['email']}</td>
            <td>";
    if ($row['photo']) echo "<img src='{$row['photo']}'>";
    echo "</td>
            <td>
                <a href='modifier.php?id={$row['id']}'>Modifier</a> |
                <a href='supprimer.php?id={$row['id']}' onclick=\"return confirm('Supprimer ce contact ?')\">Supprimer</a>
            </td>
        </tr>";
}
echo "</table>";
?>

</body>
</html>