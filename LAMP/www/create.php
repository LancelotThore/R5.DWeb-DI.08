<?php
include 'db.php';
include 'index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];

    $sql = "INSERT INTO users (nom, email, adresse) VALUES (:nom, :email, :adresse)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':adresse', $adresse);
    $stmt->execute();

    header("Location: read.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
</head>
<body>
    <h2>Create User</h2>
    <form method="post" action="create.php">
        Nom: <input type="text" name="nom" required><br>
        Email: <input type="email" name="email" required><br>
        Adresse: <input type="text" name="adresse" required><br>
        <input type="submit" value="Create">
    </form>
</body>
</html>