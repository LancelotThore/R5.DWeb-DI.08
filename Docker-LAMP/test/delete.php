<?php
include 'db.php';

$id_users = $_GET['id_users'];

$sql = "DELETE FROM users WHERE id_users = '". $id_users ."'";
$mysqli->query($sql);

header("Location: read.php");
?>