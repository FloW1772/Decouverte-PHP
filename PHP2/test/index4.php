<?php
if (!empty($_POST)) {
    // Traitement du formulaire
    // Par exemple : vérification des champs, enregistrement en base de données, etc.

    // Si tout est nickel, redirection
    header('Location: autrePage.php');
    exit(); // Toujours ajouter exit après une redirection
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulaire d'inscription</title>
</head>
<body>
<h1>Inscription</h1>
<form method="post" action="">
    <input type="text" >
    <input type="text" >
    <input type="text" >
    <button>OK</button>
</form>
</body>
</html>
