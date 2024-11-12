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

function generateCSV($numberOfRows = 5000000, $filename = 'users.csv') {
    // Ouverture du fichier en mode écriture
    $file = fopen($filename, 'w');
    if ($file === false) {
        die("Erreur lors de l'ouverture du fichier $filename");
    }

    // Taille du lot pour l'écriture
    $batchSize = 10000;
    $csvData = '';

    // Boucle pour générer les données
    for ($i = 0; $i < $numberOfRows; $i++) {
        // Génération des valeurs pour chaque colonne
        $type = rand(1, 5); // Génère un type aléatoire entre 1 et 5
        $name = "User_" . $i; // Nom d'utilisateur unique pour chaque ligne
        $address = "Address_" . $i; // Adresse unique pour chaque ligne
        $email = "user" . $i . "@example.com"; // Email unique pour chaque ligne

        // Accumulation des données dans la chaîne
        $csvData .= "$type,$name,$address,$email\n";

        // Écriture par lots
        if (($i + 1) % $batchSize == 0) {
            fwrite($file, $csvData);
            $csvData = ''; // Réinitialisation de la chaîne
        }
    }

    // Écriture des données restantes
    if (!empty($csvData)) {
        fwrite($file, $csvData);
    }

    // Fermeture du fichier après écriture
    fclose($file);
    return $filename; // Retourne le nom du fichier généré
}

/**
 * Fonction pour importer les données d'un fichier CSV dans la base de données
 * 
 * @param string $filename Nom du fichier CSV à importer
 * @return float Temps d'exécution en millisecondes
 */
function importCSV($filename) {
    // Connexion à la base de données
    $mysqli = getMySQLiConnection();

    // Désactivation de l'auto-commit pour effectuer une transaction
    $mysqli->autocommit(FALSE);

    // Désactivation des vérifications d'unicité et des clés étrangères pour accélérer l'importation
    $mysqli->query("SET unique_checks=0");
    $mysqli->query("SET foreign_key_checks=0");

    // Requête SQL pour importer le fichier CSV dans la table 'users'
    $query = "LOAD DATA LOCAL INFILE '$filename' 
              INTO TABLE users 
              FIELDS TERMINATED BY ',' 
              ENCLOSED BY '\"' 
              LINES TERMINATED BY '\\n' 
              (type, nom, adresse, email)";

    // Autorisation du chargement local des fichiers dans MySQL
    $mysqli->options(MYSQLI_OPT_LOCAL_INFILE, true);

    // Exécution de la requête d'importation CSV
    if (!$mysqli->query($query)) {
        echo "Erreur lors du chargement des données : " . $mysqli->error . "\n";
        $mysqli->rollback();
        return -1;
    }

    // Réactivation des vérifications d'unicité et des clés étrangères après l'importation
    $mysqli->query("SET unique_checks=1");
    $mysqli->query("SET foreign_key_checks=1");

    // Validation de la transaction
    $mysqli->commit();

    $mysqli->close();
}

// Génération du fichier CSV
$csvFile = generateCSV();


// Enregistrement du temps de début d'importation
$startTime = microtime(true);

importCSV(generateCSV());
// importCSV("users.csv");

// Calcul du temps d'exécution total
$endTime = microtime(true);
$executionTime = ($endTime - $startTime); // Conversion en secondes

if ($executionTime >= 0) {
    echo "Importation réussie en $executionTime secondes.\n";
} else {
    echo "Échec de l'importation.\n";
}
?>