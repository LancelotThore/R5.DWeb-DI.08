<?php
include 'db.php';
include 'index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_users = $_POST['id_users'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];

    $sql = 'UPDATE users SET nom = ?, email = ?, adresse = ? WHERE id_users = ?';
    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die('Erreur de préparation de la requête : ' . $mysqli->error);
    }

    $stmt->bind_param('sssi', $nom, $email, $adresse, $id_users);

    if ($stmt->execute() === false) {
        die('Erreur d\'exécution de la requête : ' . $stmt->error);
    }

} else {
    $id_users = $_GET['id_users'];

    // Préparer la requête SQL pour la sélection
    $sql = "SELECT * FROM users WHERE id_users = ?";
    $stmt = $mysqli->prepare($sql);

    // Vérifier si la préparation a réussi
    if ($stmt === false) {
        die('Erreur de préparation de la requête : ' . $mysqli->error);
    }

    // Lier les paramètres
    $stmt->bind_param('i', $id_users);

    // Exécuter la requête
    if ($stmt->execute() === false) {
        die('Erreur d\'exécution de la requête : ' . $stmt->error);
    }

    // Obtenir le résultat
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
    <h2>Update User</h2>
    <form method="post" action="update.php">
        <input type="hidden" name="id_users" value="<?php echo htmlspecialchars($user['id_users']); ?>">
        Name: <input type="text" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required><br>
        Email: <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
        Adresse: <input type="text" name="adresse" value="<?php echo htmlspecialchars($user['adresse']); ?>" required><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>