<?php
require_once 'db.php'; 

$mysqli = getMySQLiConnection();

// mettre que des int et empecher insertion SQL
if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    $id = $mysqli->real_escape_string($_REQUEST['id']);
} else {
    if(isset($_REQUEST['id']) && !is_numeric($_REQUEST['id'])){
        die('ID doit être un nombre');
    }
    $id = '';
}

if(isset($_REQUEST['type']) && is_numeric($_REQUEST['type'])) {
    $type = $mysqli->real_escape_string($_REQUEST['type']);
} else {
    if(isset($_REQUEST['type']) && !is_numeric($_REQUEST['type'])){
        $error = 'Type doit être un nombre';
    }

    $type = '';
}

if(isset($_REQUEST['adresse'])) {
    $adresse = $mysqli->real_escape_string($_REQUEST['adresse']);
} else {
    $adresse = '';
}

if(isset($_REQUEST['nom'])) {
    $nom = $mysqli->real_escape_string($_REQUEST['nom']);
} else {
    $nom = '';
}

if(isset($_REQUEST['email'])) {
    $email = $mysqli->real_escape_string($_REQUEST['email']);
} else {
    $email = '';
}

if($id && $type && $adresse && $nom && $email){
    $mysqli->query("UPDATE `users` SET `type`='$type',`adresse`='$adresse',`nom`='$nom',`email`='$email' WHERE `id_users`='$id'");
    if($mysqli->connect_error){
        die('Erreur : ' .$mysqli->connect_error);
    }
    header('Location: /index.php?message=' . urlencode('Mise à jour réussie'));
    exit();
}
else if($type && $adresse && $nom && $email){
    $mysqli->query("INSERT INTO `users`(`type`, `adresse`, `nom`, `email`) VALUES ('$type','$adresse','$nom','$email')");
    if($mysqli->connect_error){
        die('Erreur : ' .$mysqli->connect_error);
    }
    header('Location: /index.php?message=' . urlencode('Utlisateur créé'));
    exit();
}

if($id){
    $data = $mysqli->query("SELECT * FROM `users` WHERE `id_users`='$id'");
    if($mysqli->connect_error){
        die('Erreur : ' .$mysqli->connect_error);
    }
    $row = $data->fetch_assoc();
    if(!$row){
        die('Utilisateur non trouvé');
    }
    $type = empty($row['type']) ? '' : $row['type'];
    $adresse = empty($row['adresse']) ? '' : $row['adresse'];
    $nom = empty($row['nom']) ? '' : $row['nom'];
    $email = empty($row['email']) ? '' : $row['email'];
}
else{
    $type = '';
    $adresse = '';
    $nom = '';
    $email = '';
}

$actionName = empty($id) ? 'Créer' : 'Modifier';
$action = empty($id) ? 'createUser.php' : 'createUser.php/?id=' . htmlspecialchars($id);

?>

<html>
    <head>
        <title>USER CRUD</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav class="nav">
            <a href="/index.php">
                <button class="button">
                < Liste utilisateurs
                </button>
            </a>
            <h1><?= htmlspecialchars($actionName) ?> un utilisateur</h1>
        </nav>

        <?php if(isset($error)) { ?>
            <p class="alert"><?= htmlspecialchars($error) ?></p>
        <?php } ?>

        <div class="form-container">
            <form action="<?= htmlspecialchars($action) ?>" method="post" class="form">
                <ul class='form__list'>
                    <li class='form__list-elt'>
                        <label for="type">Type</label>
                        <input type="text" name="type" id="type" value="<?= htmlspecialchars($type) ?>">

                    </li>
                    <li class='form__list-elt'>
                        <label for="adresse">Adresse</label>
                        <input type="text" name="adresse" id="adresse" value="<?= htmlspecialchars($adresse) ?>">
                    </li>
                    <li class='form__list-elt'>
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($nom) ?>">
                    </li>
                    <li class='form__list-elt'>
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" value="<?= htmlspecialchars($email) ?>">
                    </li>
                </ul>
                <input type="submit" value="<?= htmlspecialchars($actionName) ?>" class="button">
            </form>
        </div>
    </body>
</html>