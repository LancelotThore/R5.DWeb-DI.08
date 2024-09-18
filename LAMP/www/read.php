<?php
include 'db.php';
include 'index.php';

$sql = "SELECT * FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Read Users</title>
</head>
<body>
    <h2>Users</h2>
    <a href="create.php">Create User</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Adresse</th>
            <th></th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id_users']; ?></td>
            <td><?php echo $user['nom']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['adresse']; ?></td>
            <td>
                <a href="update.php?id_users=<?php echo $user['id_users']; ?>">Edit</a>
                <a href="delete.php?id_users=<?php echo $user['id_users']; ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>