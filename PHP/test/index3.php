<?php
    if (!empty($_POST)){

        $nom = filter_var($_POST['nom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $nom = filter_input(INPUT_POST,'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        echo "<p>" . $nom . "</p>";


//echo "<p>" . $_POST['nom'] . "</p>";
}



?>

<form>
    <label> Nom :</label>
    <input type="text" name="nom">
    <button>ok</button>
</form>
