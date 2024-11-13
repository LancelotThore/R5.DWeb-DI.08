<?php

require_once 'db.php';
ini_set('max_execution_time', '300'); // Augmente la limite de temps d'exécution à 300 secondes

/**
 * Fonction pour générer un fichier CSV contenant des lignes d'utilisateurs
 * 
 * @param int $numberOfRows Nombre de lignes à générer
 * @param string $filename Nom du fichier CSV
 * @return string Le nom du fichier CSV généré
 */

$mysqli = getMySQLiConnection();

$startTime = microtime(true);

// Ajout de l'index sur le champ 'type'
$sql = "ALTER TABLE users 
        ADD UNIQUE INDEX unique_email (email)";

if ($mysqli->query($sql) === TRUE) {
    $endTime = microtime(true);
    $executionTime = ($endTime - $startTime);

    echo "Opération réussie en $executionTime secondes.\n";
} else {
    echo "Erreur lors de l'ajout de l'index : " . $mysqli->error . "\n";
}

// Fermeture de la connexion
$mysqli->close();

?>