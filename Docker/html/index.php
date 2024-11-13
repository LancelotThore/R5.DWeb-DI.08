<?php

require_once 'db.php';

function getLoadTime () {
    $timestart=microtime(true);
    $timeend=microtime(true);
    $time=$timeend-$timestart;
    return $time;
}

function dd($var) {
    var_dump($var);
    die();
}

$mysqli = getMySQLiConnection();

// On détermine sur quelle page on se trouve
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']) ;
}else{
    $currentPage = 1;
}

$resultCount = $mysqli->query("SELECT COUNT(*) as count FROM `users`")->fetch_assoc();
$userPerPage = 16;
$nbPage = ceil($resultCount['count'] / $userPerPage);


$data = $mysqli->query("SELECT `id_users`, `type`, `adresse`, `nom`, `email` FROM `users` LIMIT $userPerPage OFFSET " . ($currentPage - 1) * $userPerPage)->fetch_all(MYSQLI_ASSOC);

if($mysqli->connect_error){
    die('Erreur : ' .$mysqli->connect_error);
}

?>

<html>
    <head>
        <title>USER CRUD</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav class="nav">
            <h1>Liste des utilisateurs</h1>
            <a href="createUser.php">
                <button class="button">
                    + Créer un utilisateur
                </button>
            </a>
        </nav>
        <?php
        if(isset($_GET['message'])) {
            echo '<p class="message">' . htmlspecialchars($_GET['message']) . '</p>';
        }
        ?>
        <ul class='list'>
        <?php
            foreach ($data as $row) {
                echo "<li class='list__elt'><p>
                 ID :  " . htmlspecialchars($row['id_users']) . "<br>
                   Adresse : " . htmlspecialchars($row['adresse']) . "<br>

                 Nom : " . htmlspecialchars($row['nom']) . "<br>
                    Email : " . htmlspecialchars($row['email']) . "<br>
                     </p>
                    <div class='actions'>
                    <a href='deleteUser.php?id=" .  htmlspecialchars($row['id_users']) . "'><button class='button button--del'>Supprimer</button></a>
                    <a href='createUser.php?id=" .  htmlspecialchars($row['id_users']) . "'><button class='button button--outline'>Modifier</button></a>
                    </div>
                 </li>";
            }
        ?>
        </ul>
        <p class="title__pagination">Page <?php echo $currentPage ?> sur <?php echo $nbPage ?></p>
        <ul class="pagination">
            <?php
                if($currentPage > 1){
                    echo '<li class="pagination__elt"><a href="index.php?page=1">1</a></li>';
                    if ($currentPage > 2) {
                        echo '<li class="pagination__elt"><a href="index.php?page=' . ($currentPage - 1) . '"><</a></li>';
                    }
                }
            ?>
            <li class="pagination__elt">
                <p><?php echo $currentPage ?></p>
            </li>
            <?php
                if($currentPage < $nbPage){
                    if ($currentPage < ($nbPage - 1)) {
                        echo '<li class="pagination__elt"><a href="index.php?page=' . ($currentPage + 1) . '">></a></li>';
                    }
                    echo '<li class="pagination__elt"><a href="index.php?page=' . $nbPage .'">'. $nbPage .'</a></li>';
                }
            ?>
        </ul>
    </body>
</html>