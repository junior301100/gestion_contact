<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
include 'connexion.php';

$message = '';

if (isset($_POST['ajouter'])) {

    if (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);
    }

    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $photo = null;

    if (!empty($_FILES['photo']['name'])) {
        $photoName = basename($_FILES['photo']['name']);
        $photoName = preg_replace("/[^a-zA-Z0-9\.\-]/", "", $photoName);
        $photoPath = "uploads/" . $photoName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
            $photo = $photoPath;
        } else {
            $message = "<p style='color:red;'>❌ Erreur lors de l'upload de la photo.</p>";
        }
    }

    $sql = "INSERT INTO contacts (nom, prenom, telephone, email, photo)
            VALUES ('$nom', '$prenom', '$telephone', '$email', " . ($photo ? "'$photo'" : "NULL") . ")";

    if (mysqli_query($conn, $sql)) {
        $message = "<p style='color:green;'>✅ Contact ajouté avec succès.</p>";
    } else {
        $message = "<p style='color:red;'>❌ Erreur : " . mysqli_error($conn) . "</p>";
    }
}
?>

<nav>
    <a href="index.php">🏠 Accueil</a>
    <a href="ajouter.php">➕ Ajouter</a>
    <a href="rechercher.php">🔍 Rechercher</a>
</nav>

<h2>Ajouter un contact</h2>

<?php
    // Afficher les messages (succès ou erreur)
    if (!empty($message)) {
        echo $message;
    }
?>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="nom" placeholder="Nom" required>
    <input type="text" name="prenom" placeholder="Prénom" required>
    <input type="text" name="telephone" placeholder="Téléphone" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="file" name="photo" accept="image/*">
    <input type="submit" name="ajouter" value="Ajouter">
</form>

</body>
</html>