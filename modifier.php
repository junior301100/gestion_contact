<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
    include 'connexion.php';

    $id = $_GET['id'];
    $res = mysqli_query($conn, "SELECT * FROM contacts WHERE id = $id");
    $data = mysqli_fetch_assoc($res);
?>

<nav>
    <a href="index.php">🏠 Accueil</a>
    <a href="ajouter.php">➕ Ajouter</a>
    <a href="rechercher.php">🔍 Rechercher</a>
</nav>

<h2>Modifier un contact</h2>

<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $data['id'] ?>">
    <input type="text" name="nom" value="<?= $data['nom'] ?>" required>
    <input type="text" name="prenom" value="<?= $data['prenom'] ?>" required>
    <input type="text" name="telephone" value="<?= $data['telephone'] ?>" required>
    <input type="email" name="email" value="<?= $data['email'] ?>" required>
    <input type="file" name="photo">
    <input type="submit" name="modifier" value="Modifier">
</form>

<?php
if (isset($_POST['modifier'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $tel = $_POST['telephone'];
    $email = $_POST['email'];

    if (!empty($_FILES['photo']['name'])) {
        $photo = "uploads/" . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
        $sql = "UPDATE contacts SET nom='$nom', prenom='$prenom', telephone='$tel', email='$email', photo='$photo' WHERE id=$id";
    } else {
        $sql = "UPDATE contacts SET nom='$nom', prenom='$prenom', telephone='$tel', email='$email' WHERE id=$id";
    }

    mysqli_query($conn, $sql);
    header("Location: rechercher.php");
}
?>

</body>
</html>