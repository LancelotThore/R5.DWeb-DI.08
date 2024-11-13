<?php

require_once 'db.php';
ini_set('max_execution_time', '300'); // Augmente la limite de temps d'exécution à 300 secondes

/**
 * Fonction pour exécuter une requête SQL et mesurer le temps d'exécution
 * 
 * @return void
 */

$mysqli = getMySQLiConnection();

if ($mysqli->connect_error) {
    die("Échec de la connexion : " . $mysqli->connect_error);
}

$startTime = microtime(true);

// Préparation de la requête pour compter le nombre d'adresses e-mail par domaine
$sql = "SELECT SUBSTRING_INDEX(email, '@', -1) as domain, COUNT(*) as count FROM `users` GROUP BY domain";
$result = $mysqli->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "Domaine : " . $row['domain'] . " - Nombre d'adresses e-mail : " . $row['count'] . "\n";
    }

    $endTime = microtime(true);
    $executionTime = ($endTime - $startTime);

    echo "Opération réussie en $executionTime secondes.\n";
} else {
    echo "Erreur lors de l'exécution de la requête : " . $mysqli->error;
}

// Fermeture de la connexion
$mysqli->close();

?>