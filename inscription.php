<?php
session_start();
include 'connexion.php';

$message = '';

if (isset($_POST['inscription'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
        $message = "<p style='color:red;'>❌ Tous les champs sont obligatoires.</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<p style='color:red;'>❌ Email invalide.</p>";
    } elseif ($password !== $password_confirm) {
        $message = "<p style='color:red;'>❌ Les mots de passe ne correspondent pas.</p>";
    } else {
        // Vérifier si l'utilisateur existe déjà
        $username_safe = mysqli_real_escape_string($conn, $username);
        $email_safe = mysqli_real_escape_string($conn, $email);

        $checkUser = mysqli_query($conn, "SELECT id FROM utilisateurs WHERE username='$username_safe' OR email='$email_safe'");
        if (mysqli_num_rows($checkUser) > 0) {
            $message = "<p style='color:red;'>❌ Nom d'utilisateur ou email déjà utilisé.</p>";
        } else {
            // Hasher le mot de passe
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO utilisateurs (username, email, password) VALUES ('$username_safe', '$email_safe', '$password_hash')";
            if (mysqli_query($conn, $sql)) {
                $message = "<p style='color:green;'>✅ Inscription réussie. <a href='login.php'>Connectez-vous ici</a>.</p>";
            } else {
                $message = "<p style='color:red;'>❌ Erreur lors de l'inscription : " . mysqli_error($conn) . "</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Inscription</h2>

<?php if (!empty($message)) echo $message; ?>

<form method="post">
    <input type="text" name="username" placeholder="Nom d'utilisateur" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <input type="password" name="password_confirm" placeholder="Confirmer le mot de passe" required>
    <input type="submit" name="inscription" value="S'inscrire">
</form>

<p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous ici</a>.</p>

</body>
</html>
