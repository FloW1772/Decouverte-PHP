<?php
// inscription.php
declare(strict_types=1);
mb_internal_encoding('UTF-8');

// --- Config & helpers ---
$allowedGenders   = ['Homme', 'Femme', 'Autre'];
$allowedAteliers  = ['Créativité', 'Numérique', 'Écologie'];
$allowedTypes     = ['Visiteur', 'Bénévole', 'Intervenant'];
$maxCommentLength = 300;
$maxPhotoBytes    = 2 * 1024 * 1024; // 2 MB
$allowedPhotoMimes= ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

function h(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
function hasError(array $errors, string $field): bool { return isset($errors[$field]); }
function errId(string $field): string { return "error-$field"; }
function ariaInvalid(array $errors, string $field): string {
    return hasError($errors, $field) ? ' aria-invalid="true" aria-describedby="'.errId($field).'"' : '';
}

// Normalize and validate FR phone number (accepts separators, checks 10 digits starting with 0[1-9])
function normalize_fr_phone(string $raw): string {
    $digits = preg_replace('/\D+/', '', $raw ?? '');
    return $digits ?? '';
}
function is_valid_fr_phone(string $digits): bool {
    return (bool)preg_match('/^0[1-9]\d{8}$/', $digits);
}

// Compute age in years from YYYY-MM-DD; returns [age:int|null, dob:DateTimeImmutable|null]
function compute_age(string $yyyy_mm_dd): array {
    $dt = DateTimeImmutable::createFromFormat('Y-m-d', $yyyy_mm_dd);
    $errors = DateTimeImmutable::getLastErrors();
    if (!$dt || !empty($errors['warning_count']) || !empty($errors['error_count'])) {
        return [null, null];
    }
    $today = new DateTimeImmutable('today');
    if ($dt > $today) return [null, $dt];
    $diff = $today->diff($dt);
    return [$diff->y, $dt];
}

// --- State ---
$errors = [];
$data = [
    'nom'             => '',
    'prenom'          => '',
    'email'           => '',
    'telephone'       => '',
    'date_naissance'  => '',
    'genre'           => '',
    'ateliers'        => [],
    'type'            => '',
    'commentaires'    => '',
    // 'conditions' intentionally not stored for prefill per requirement
];
$photoInfo = null;
$age = null;
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect
    $data['nom']            = trim($_POST['nom'] ?? '');
    $data['prenom']         = trim($_POST['prenom'] ?? '');
    $data['email']          = trim($_POST['email'] ?? '');
    $data['telephone']      = trim($_POST['telephone'] ?? '');
    $data['date_naissance'] = trim($_POST['date_naissance'] ?? '');
    $data['genre']          = $_POST['genre'] ?? '';
    $data['ateliers']       = isset($_POST['ateliers']) && is_array($_POST['ateliers']) ? array_values($_POST['ateliers']) : [];
    $data['type']           = $_POST['type'] ?? '';
    $data['commentaires']   = trim($_POST['commentaires'] ?? '');

    // Validate Nom & Prénom: 2-50 letters (allow spaces, hyphens, apostrophes for FR names)
    if (!preg_match('/^[\p{L}][\p{L}\s\'\-]{1,49}$/u', $data['nom'])) {
        $errors['nom'] = "Nom invalide : 2 à 50 lettres (espaces et tirets autorisés).";
    }
    if (!preg_match('/^[\p{L}][\p{L}\s\'\-]{1,49}$/u', $data['prenom'])) {
        $errors['prenom'] = "Prénom invalide : 2 à 50 lettres (espaces et tirets autorisés).";
    }

    // Email
    if ($data['email'] === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Veuillez saisir un email valide.";
    }

    // Téléphone (FR)
    $telDigits = normalize_fr_phone($data['telephone']);
    if (!is_valid_fr_phone($telDigits)) {
        $errors['telephone'] = "Téléphone invalide : format français à 10 chiffres (ex. 06XXXXXXXX).";
    }

    // Date de naissance + âge >= 18
    [$computedAge, $dob] = compute_age($data['date_naissance']);
    if ($dob === null) {
        $errors['date_naissance'] = "Date de naissance invalide (format attendu AAAA-MM-JJ).";
    } else {
        if ($computedAge === null) {
            $errors['date_naissance'] = "Date de naissance invalide.";
        } elseif ($computedAge < 18) {
            $errors['date_naissance'] = "Vous devez avoir au moins 18 ans pour vous inscrire.";
        } else {
            $age = $computedAge;
        }
    }

    // Genre
    if (!in_array($data['genre'], $allowedGenders, true)) {
        $errors['genre'] = "Veuillez sélectionner un genre.";
    }

    // Ateliers (au moins 1, parmi la liste)
    $data['ateliers'] = array_values(array_intersect($data['ateliers'], $allowedAteliers));
    if (count($data['ateliers']) < 1) {
        $errors['ateliers'] = "Veuillez sélectionner au moins un atelier.";
    }

    // Type de participation
    if (!in_array($data['type'], $allowedTypes, true)) {
        $errors['type'] = "Veuillez sélectionner un type de participation.";
    }

    // Commentaires (facultatif, max 300)
    if ($data['commentaires'] !== '' && mb_strlen($data['commentaires']) > $maxCommentLength) {
        $errors['commentaires'] = "Commentaires trop longs (max {$maxCommentLength} caractères).";
    }

    // Conditions (obligatoire, ne pas pré-remplir)
    $accepted = isset($_POST['conditions']) && ($_POST['conditions'] === '1' || $_POST['conditions'] === 'on');
    if (!$accepted) {
        $errors['conditions'] = "Vous devez accepter le règlement de l’événement.";
    }

    // Photo (facultative)
    if (!empty($_FILES['photo']) && is_array($_FILES['photo']) && ($_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE)) {
        $err = $_FILES['photo']['error'];
        if ($err === UPLOAD_ERR_OK) {
            $size = (int)$_FILES['photo']['size'];
            if ($size > $maxPhotoBytes) {
                $errors['photo'] = "La photo dépasse la taille maximale de 2 Mo.";
            } else {
                $tmp = $_FILES['photo']['tmp_name'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime  = $finfo ? finfo_file($finfo, $tmp) : null;
                if ($finfo) finfo_close($finfo);
                if (!$mime || !in_array($mime, $allowedPhotoMimes, true)) {
                    $errors['photo'] = "Format de photo non supporté (JPEG, PNG, GIF, WEBP).";
                } else {
                    $photoInfo = [
                        'name' => (string)($_FILES['photo']['name'] ?? ''),
                        'type' => $mime,
                        'size' => $size,
                    ];
                }
            }
        } else {
            $errors['photo'] = "Erreur lors du téléversement de la photo (code $err).";
        }
    }

    // Success?
    $success = empty($errors);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription à l’atelier</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; line-height: 1.4; padding: 24px; }
        form { max-width: 720px; }
        .field { margin-bottom: 14px; }
        .field > label { display: block; font-weight: 600; margin-bottom: 6px; }
        .hint { font-size: 0.9rem; color: #555; }
        .error { color: #b00020; margin: 6px 0 0; font-size: 0.95rem; }
        .invalid { border-color: #b00020; }
        .group { border: 1px solid #ddd; padding: 12px; border-radius: 6px; }
        .actions { margin-top: 18px; }
        .recap { background: #f7fafc; border: 1px solid #e2e8f0; padding: 16px; border-radius: 8px; max-width: 720px; }
        .success { color: #0a7c2f; font-weight: 700; margin-bottom: 12px; }
        ul.inline { list-style: none; padding: 0; margin: 0; }
        ul.inline li { display: inline-block; margin-right: 8px; }
    </style>
</head>
<body>

<?php if ($success): ?>
    <section class="recap" aria-live="polite">
        <div class="success">Inscription enregistrée avec succès !</div>
        <p>Voici votre récapitulatif :</p>
        <ul>
            <li><strong>Nom :</strong> <?= h($data['nom']) ?></li>
            <li><strong>Prénom :</strong> <?= h($data['prenom']) ?></li>
            <li><strong>Email :</strong> <?= h($data['email']) ?></li>
            <li><strong>Téléphone :</strong> <?= h($data['telephone']) ?></li>
            <li><strong>Date de naissance :</strong> <?= h($data['date_naissance']) ?><?= $age !== null ? " (Âge : ".(int)$age." ans)" : "" ?></li>
            <li><strong>Genre :</strong> <?= h($data['genre']) ?></li>
            <li><strong>Ateliers souhaités :</strong>
                <?php if (!empty($data['ateliers'])): ?>
                    <?= h(implode(', ', $data['ateliers'])) ?>
                <?php else: ?>
                    Aucun
                <?php endif; ?>
            </li>
            <li><strong>Type de participation :</strong> <?= h($data['type']) ?></li>
            <li><strong>Commentaires :</strong>
                <?php if ($data['commentaires'] !== ''): ?>
                    <?= nl2br(h($data['commentaires'])) ?>
                <?php else: ?>
                    —
                <?php endif; ?>
            </li>
            <li><strong>Photo :</strong>
                <?php if ($photoInfo): ?>
                    Nom: <?= h($photoInfo['name']) ?> — Type: <?= h($photoInfo['type']) ?> — Taille: <?= number_format($photoInfo['size']/1024, 1) ?> Ko
                <?php else: ?>
                    Non fournie
                <?php endif; ?>
            </li>
        </ul>
    </section>
<?php else: ?>
    <?php if (!empty($errors)): ?>
        <div class="error" role="alert">Veuillez corriger les erreurs ci-dessous.</div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" novalidate>
        <!-- Nom -->
        <div class="field">
            <label for="nom">Nom *</label>
            <input
                type="text" id="nom" name="nom" required maxlength="50"
                pattern="[\p{L}\s'\-]{2,50}"
                value="<?= h($data['nom']) ?>"
                class="<?= hasError($errors,'nom') ? 'invalid' : '' ?>"
                <?= ariaInvalid($errors, 'nom') ?>
            >
            <div class="hint">2 à 50 lettres (espaces et tirets autorisés).</div>
            <?php if (hasError($errors, 'nom')): ?>
                <p id="<?= errId('nom') ?>" class="error"><?= h($errors['nom']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Prénom -->
        <div class="field">
            <label for="prenom">Prénom *</label>
            <input
                type="text" id="prenom" name="prenom" required maxlength="50"
                pattern="[\p{L}\s'\-]{2,50}"
                value="<?= h($data['prenom']) ?>"
                class="<?= hasError($errors,'prenom') ? 'invalid' : '' ?>"
                <?= ariaInvalid($errors, 'prenom') ?>
            >
            <div class="hint">2 à 50 lettres (espaces et tirets autorisés).</div>
            <?php if (hasError($errors, 'prenom')): ?>
                <p id="<?= errId('prenom') ?>" class="error"><?= h($errors['prenom']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Email -->
        <div class="field">
            <label for="email">Email *</label>
            <input
                type="email" id="email" name="email" required
                value="<?= h($data['email']) ?>"
                class="<?= hasError($errors,'email') ? 'invalid' : '' ?>"
                <?= ariaInvalid($errors, 'email') ?>
            >
            <?php if (hasError($errors, 'email')): ?>
                <p id="<?= errId('email') ?>" class="error"><?= h($errors['email']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Téléphone -->
        <div class="field">
            <label for="telephone">Téléphone (FR) *</label>
            <input
                type="tel" id="telephone" name="telephone" required
                inputmode="tel" pattern="0[1-9][0-9]{8}"
                placeholder="06XXXXXXXX"
                value="<?= h($data['telephone']) ?>"
                class="<?= hasError($errors,'telephone') ? 'invalid' : '' ?>"
                <?= ariaInvalid($errors, 'telephone') ?>
            >
            <?php if (hasError($errors, 'telephone')): ?>
                <p id="<?= errId('telephone') ?>" class="error"><?= h($errors['telephone']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Date de naissance -->
        <div class="field">
            <label for="date_naissance">Date de naissance *</label>
            <input
                type="date" id="date_naissance" name="date_naissance" required
                value="<?= h($data['date_naissance']) ?>"
                class="<?= hasError($errors,'date_naissance') ? 'invalid' : '' ?>"
                <?= ariaInvalid($errors, 'date_naissance') ?>
            >
            <div class="hint">Vous devez avoir au moins 18 ans.</div>
            <?php if (hasError($errors, 'date_naissance')): ?>
                <p id="<?= errId('date_naissance') ?>" class="error"><?= h($errors['date_naissance']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Genre -->
        <fieldset class="field group">
            <legend>Genre *</legend>
            <?php foreach ($allowedGenders as $g): ?>
                <label>
                    <input
                        type="radio" name="genre" value="<?= h($g) ?>" required
                        <?= $data['genre'] === $g ? 'checked' : '' ?>
                        class="<?= hasError($errors,'genre') ? 'invalid' : '' ?>"
                        <?= ariaInvalid($errors, 'genre') ?>
                    >
                    <?= h($g) ?>
                </label>
            <?php endforeach; ?>
            <?php if (hasError($errors, 'genre')): ?>
                <p id="<?= errId('genre') ?>" class="error"><?= h($errors['genre']) ?></p>
            <?php endif; ?>
        </fieldset>

        <!-- Ateliers souhaités -->
        <fieldset class="field group">
            <legend>Ateliers souhaités (au moins 1) *</legend>
            <?php foreach ($allowedAteliers as $opt): ?>
                <label>
                    <input
                        type="checkbox" name="ateliers[]"
                        value="<?= h($opt) ?>"
                        <?= in_array($opt, $data['ateliers'], true) ? 'checked' : '' ?>
                        class="<?= hasError($errors,'ateliers') ? 'invalid' : '' ?>"
                        <?= ariaInvalid($errors, 'ateliers') ?>
                    >
                    <?= h($opt) ?>
                </label>
            <?php endforeach; ?>
            <?php if (hasError($errors, 'ateliers')): ?>
                <p id="<?= errId('ateliers') ?>" class="error"><?= h($errors['ateliers']) ?></p>
            <?php endif; ?>
        </fieldset>

        <!-- Type de participation -->
        <div class="field">
            <label for="type">Type de participation *</label>
            <select
                id="type" name="type" required
                class="<?= hasError($errors,'type') ? 'invalid' : '' ?>"
                <?= ariaInvalid($errors, 'type') ?>
            >
                <option value="" hidden>— Sélectionner —</option>
                <?php foreach ($allowedTypes as $t): ?>
                    <option value="<?= h($t) ?>" <?= $data['type'] === $t ? 'selected' : '' ?>><?= h($t) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (hasError($errors, 'type')): ?>
                <p id="<?= errId('type') ?>" class="error"><?= h($errors['type']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Commentaires -->
        <div class="field">
            <label for="commentaires">Commentaires (facultatif)</label>
            <textarea
                id="commentaires" name="commentaires" rows="4" maxlength="<?= $maxCommentLength ?>"
                class="<?= hasError($errors,'commentaires') ? 'invalid' : '' ?>"
                <?= ariaInvalid($errors, 'commentaires') ?>
            ><?= h($data['commentaires']) ?></textarea>
            <div class="hint">Maximum <?= $maxCommentLength ?> caractères.</div>
            <?php if (hasError($errors, 'commentaires')): ?>
                <p id="<?= errId('commentaires') ?>" class="error"><?= h($errors['commentaires']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Photo (facultatif) -->
        <div class="field">
            <label for="photo">Photo (facultatif)</label>
            <input
                type="file" id="photo" name="photo" accept="image/*"
                class="<?= hasError($errors,'photo') ? 'invalid' : '' ?>"
                <?= ariaInvalid($errors, 'photo') ?>
            >
            <div class="hint">JPEG, PNG, GIF ou WEBP, 2 Mo max.</div>
            <?php if (hasError($errors, 'photo')): ?>
                <p id="<?= errId('photo') ?>" class="error"><?= h($errors['photo']) ?></p>
            <?php endif; ?>
        </div>

        <!-- Conditions -->
        <div class="field">
            <label>
                <input
                    type="checkbox" name="conditions" value="1" required
                    class="<?= hasError($errors,'conditions') ? 'invalid' : '' ?>"
                <?= ariaInvalid($errors, 'conditions') ?>
                <!-- Intentionally NOT pre-checked on error per requirement -->
                >
                J’accepte le règlement de l’événement *
            </label>
            <?php if (hasError($errors, 'conditions')): ?>
                <p id="<?= errId('conditions') ?>" class="error"><?= h($errors['conditions']) ?></p>
            <?php endif; ?>
        </div>

        <div class="actions">
            <button type="submit">S’inscrire</button>
        </div>
    </form>
<?php endif; ?>

</body>
</html>
