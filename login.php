<?php
session_start();
include 'connexion.php';

$message = '';

if (isset($_POST['connexion'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $message = "<p style='color:red;'>❌ Tous les champs sont obligatoires.</p>";
    } else {
        $username_safe = mysqli_real_escape_string($conn, $username);
        $sql = "SELECT id, password FROM utilisateurs WHERE username='$username_safe'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                // Mot de passe correct, démarrer la session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username_safe;
                header('Location: index.php');
                exit;
            } else {
                $message = "<p style='color:red;'>❌ Mot de passe incorrect.</p>";
            }
        } else {
            $message = "<p style='color:red;'>❌ Nom d'utilisateur non trouvé.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Connexion</h2>

<?php if (!empty($message)) echo $message; ?>

<form method="post">
    <input type="text" name="username" placeholder="Nom d'utilisateur" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <input type="submit" name="connexion" value="Se connecter">
</form>

<p>Pas encore de compte ? <a href="inscription.php">Inscrivez-vous ici</a>.</p>

</body>
</html>
