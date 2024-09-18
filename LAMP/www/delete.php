<?php
include 'db.php';

$id_users = $_GET['id_users'];

$sql = "DELETE FROM users WHERE id_users = :id_users";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_users', $id_users);
$stmt->execute();

header("Location: read.php");
?>