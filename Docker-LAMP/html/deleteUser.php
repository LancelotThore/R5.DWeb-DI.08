<?php
require_once 'db.php'; 

$mysqli = getMySQLiConnection();

if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    $id = $mysqli->real_escape_string($_REQUEST['id']);
    $mysqli->query("DELETE FROM `users` WHERE `id_users` = '$id'");

    if($mysqli->connect_error){
        die('Erreur : ' .$mysqli->connect_error);
    }
    header('Location: /index.php?message=' . urlencode('Utilisateur supprimé'));
} else {
    if(isset($_REQUEST['id']) && !is_numeric($_REQUEST['id'])){
        header('Location: /index.php?message=' . urlencode('ID doit être un nombre'));
    }
}

?>