<?php
$errors = [];
$inputs = [
    'nom' => '', 'prenom' => '', 'email' => '', 'telephone' => '',
    'date_naissance' => '', 'genre' => '', 'ateliers' => [],
    'type_participation' => '', 'commentaires' => '', 'conditions' => ''
];

$ateliers_list = ['Atelier A', 'Atelier B', 'Atelier C'];
$types_participation = ['Visiteur', 'Bénévole', 'Intervenant'];
$genres = ['Homme', 'Femme', 'Autre'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des champs et nettoyage
    foreach ($inputs as $key => $default) {
        if ($key === 'ateliers') {
            $inputs[$key] = isset($_POST[$key]) ? (array)$_POST[$key] : [];
        } else {
            $inputs[$key] = trim($_POST[$key] ?? '');
        }
    }

    // Validation Nom/Prénom
    foreach (['nom', 'prenom'] as $field) {
        if ($inputs[$field] === '') {
            $errors[$field] = "Ce champ est obligatoire.";
        }
    }

    // Validation Email
    if ($inputs['email'] === '') {
        $errors['email'] = "L'email est obligatoire.";
    } elseif (!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Format d'email invalide.";
    }

    // Validation Téléphone
    if ($inputs['telephone'] === '') {
        $errors['telephone'] = "Le téléphone est obligatoire.";
    } elseif (!preg_match('/^0[1-9](\d{8})$/', $inputs['telephone'])) {
        $errors['telephone'] = "Format attendu : 06XXXXXXXX";
    }

    // Validation Date de naissance
    if ($inputs['date_naissance'] === '') {
        $errors['date_naissance'] = "La date de naissance est obligatoire.";
    } else {
        $birth = DateTime::createFromFormat('Y-m-d', $inputs['date_naissance']);
        $now = new DateTime();
        if (!$birth) {
            $errors['date_naissance'] = "Date invalide.";
        } else {
            $age = $birth->diff($now)->y;
            if ($age < 18) {
                $errors['date_naissance'] = "Vous devez avoir au moins 18 ans.";
            }
        }
    }

    // Validation Genre
    if (!in_array($inputs['genre'], $genres)) {
        $errors['genre'] = "Veuillez sélectionner votre genre.";
    }

    // Validation Ateliers
    $selected_ateliers = array_intersect($inputs['ateliers'], $ateliers_list);
    if (count($selected_ateliers) < 1) {
        $errors['ateliers'] = "Sélectionnez au moins un atelier.";
    }

    // Validation Type de participation
    if (!in_array($inputs['type_participation'], $types_participation)) {
        $errors['type_participation'] = "Sélectionnez un type de participation.";
    }

    // Validation Commentaires
    if (strlen($inputs['commentaires']) > 300) {
        $errors['commentaires'] = "300 caractères maximum.";
    }

    // Validation Conditions
    if (empty($_POST['conditions'])) {
        $errors['conditions'] = "Vous devez accepter le règlement.";
    }

    // Si tout est valide
    if (empty($errors)) {
        // Affichage du récapitulatif
        $safe = fn($v) => htmlspecialchars($v, ENT_QUOTES);
        echo "<h2>Inscription réussie !</h2>";
        echo "<ul>";
        echo "<li><strong>Nom :</strong> " . $safe($inputs['nom']) . "</li>";
        echo "<li><strong>Prénom :</strong> " . $safe($inputs['prenom']) . "</li>";
        echo "<li><strong>Email :</strong> " . $safe($inputs['email']) . "</li>";
        echo "<li><strong>Téléphone :</strong> " . $safe($inputs['telephone']) . "</li>";
        echo "<li><strong>Date de naissance :</strong> " . $safe($inputs['date_naissance']) . " (" . $age . " ans)</li>";
        echo "<li><strong>Genre :</strong> " . $safe($inputs['genre']) . "</li>";
        echo "<li><strong>Ateliers :</strong> " . implode(', ', array_map($safe, $selected_ateliers)) . "</li>";
        echo "<li><strong>Type de participation :</strong> " . $safe($inputs['type_participation']) . "</li>";
        if ($inputs['commentaires']) {
            echo "<li><strong>Commentaires :</strong> " . $safe($inputs['commentaires']) . "</li>";
        }
        echo "</ul>";
		exit;
    }
} 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Inscription à l'événement</title>
</head>
<body>
<h1>Inscription à l'événement</h1>
<form method="post" action="">
    <label>Nom :<br>
        <input type="text" name="nom" value="<?= htmlspecialchars($inputs['nom']) ?>">
        <div style="color:red;"><?= $errors['nom'] ?? '' ?></div>
    </label><br>

    <label>Prénom :<br>
        <input type="text" name="prenom" value="<?= htmlspecialchars($inputs['prenom']) ?>">
        <div style="color:red;"><?= $errors['prenom'] ?? '' ?></div>
    </label><br>

    <label>Email :<br>
        <input type="text" name="email" value="<?= htmlspecialchars($inputs['email']) ?>">
        <div style="color:red;"><?= $errors['email'] ?? '' ?></div>
    </label><br>

    <label>Téléphone :<br>
        <input type="text" name="telephone" value="<?= htmlspecialchars($inputs['telephone']) ?>">
        <div style="color:red;"><?= $errors['telephone'] ?? '' ?></div>
    </label><br>

    <label>Date de naissance :<br>
        <input type="date" name="date_naissance" value="<?= htmlspecialchars($inputs['date_naissance']) ?>">
        <div style="color:red;"><?= $errors['date_naissance'] ?? '' ?></div>
    </label><br>

    <label>Genre :<br>
        <?php foreach ($genres as $g): ?>
            <input type="radio" name="genre" value="<?= $g ?>" <?= $inputs['genre'] === $g ? 'checked' : '' ?>> <?= $g ?>
        <?php endforeach; ?>
        <div style="color:red;"><?= $errors['genre'] ?? '' ?></div>
    </label><br>

    <label>Ateliers souhaités :<br>
        <?php foreach ($ateliers_list as $a): ?>
            <input type="checkbox" name="ateliers[]" value="<?= $a ?>" <?= in_array($a, $inputs['ateliers']) ? 'checked' : '' ?>> <?= $a ?>
        <?php endforeach; ?>
        <div style="color:red;"><?= $errors['ateliers'] ?? '' ?></div>
    </label><br>

    <label>Type de participation :<br>
        <select name="type_participation">
            <option value="">--Sélectionnez--</option>
            <?php foreach ($types_participation as $t): ?>
                <option value="<?= $t ?>" <?= $inputs['type_participation'] === $t ? 'selected' : '' ?>><?= $t ?></option>
            <?php endforeach; ?>
        </select>
        <div style="color:red;"><?= $errors['type_participation'] ?? '' ?></div>
    </label><br>

    <label>Commentaires (facultatif, 300 caractères max) :<br>
        <textarea name="commentaires" maxlength="300"><?= htmlspecialchars($inputs['commentaires']) ?></textarea>
        <div style="color:red;"><?= $errors['commentaires'] ?? '' ?></div>
    </label><br>

    <label>
        <input type="checkbox" name="conditions" value="1" <?= empty($errors) && !empty($_POST['conditions']) ? 'checked' : '' ?>> J’accepte le règlement de l’événement
        <div style="color:red;"><?= $errors['conditions'] ?? '' ?></div>
    </label><br><br>

    <button type="submit">S'inscrire</button>
</form>
</body>
</html>