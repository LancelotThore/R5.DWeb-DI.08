<?php
include 'db.php';
include 'index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_users = $_POST['id_users'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];

    $sql = "UPDATE users SET nom = :nom, email = :email, adresse = :adresse WHERE id_users = :id_users";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_users', $id_users);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':adresse', $adresse);
    $stmt->execute();

    header("Location: read.php");
} else {
    $id_users = $_GET['id_users'];
    $sql = "SELECT * FROM users WHERE id_users = :id_users";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_users', $id_users);
    $stmt->execute();
    $user = $stmt->fetch();
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
        <input type="hidden" name="id_users" value="<?php echo $user['id_users']; ?>">
        Name: <input type="text" name="nom" value="<?php echo $user['nom']; ?>" required><br>
        Email: <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
        Adresse: <input type="text" name="adresse" value="<?php echo $user['adresse']; ?>" required><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>