<?php

require_once 'db.php';

/**
 * Fonction pour mesurer le temps d'exécution d'une requête SQL
 * 
 * @param mysqli $mysqli Objet de connexion MySQLi
 * @param string $query Requête SQL à exécuter
 * @return float Temps d'exécution en secondes
 */
function measureQueryTime($mysqli, $query) {
    $startTime = microtime(true);
    $result = $mysqli->query($query);
    $endTime = microtime(true);

    if (!$result) {
        die("Erreur lors de l'exécution de la requête : " . $mysqli->error);
    }

    // Libération des résultats
    $result->free();

    return $endTime - $startTime;
}

// Connexion à la base de données
$mysqli = getMySQLiConnection();

// Requête SQL pour sélectionner 2000 lignes non supprimées et de type 1
$query = "SELECT * FROM users WHERE type = 1 AND supprime = 0 LIMIT 2000";

// Mesure du temps d'exécution de la première requête
$firstExecutionTime = measureQueryTime($mysqli, $query);
echo "Temps d'exécution de la première requête : $firstExecutionTime secondes.\n";

// Mesure du temps d'exécution de la deuxième requête
$secondExecutionTime = measureQueryTime($mysqli, $query);
echo "Temps d'exécution de la deuxième requête : $secondExecutionTime secondes.\n";

// Fermeture de la connexion à la base de données
$mysqli->close();
?>