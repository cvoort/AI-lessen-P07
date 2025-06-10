<?php
//global $error, $recipe;

use classes\AIWrapper;
use classes\RecipeFormatter;
use classes\Recipe;

require_once 'config/config.php';
require_once 'classes/AIWrapper.php';
require_once 'classes/RecipeFormatter.php';
require_once 'classes/Recipe.php';
//require 'process.php';

$recepten = [];
$error = '';

// Controleer of het formulier is verzonden
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['ingredients'])) {
    try {
        $ingredients = explode(', ', $_POST['ingredients']);
        $ingredients = array_map('trim', $ingredients);

        // Maak een nieuwe instantie van de AIWrapper
        $wrapper = new AIWrapper(API_KEY);

        // Verwerk de ingrediënten
        $rawOutput = $wrapper->generateRecipe($ingredients);

        // Gebruik de formatter om de output te verwerken
        $formatter = new RecipeFormatter();
        $recepten = $formatter->formatRecipe($rawOutput);

    } catch (\Exception $e) {
        // Stuur terug naar index met foutmelding
//        header('Location: index.php?message=Fout: ' . urlencode($e->getMessage()));
        $error = $e->getMessage();
        exit;
    }
}
//else {
    // Als het formulier niet correct is verzonden
//    header('Location: index.php?message=Ongeldig verzoek');
//    exit;
//}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <title>AI recept generator</title>
    <link rel="stylesheet" href=css/style.css>
</head>
<body>
<div class="container">
    <h1>AI Recept Generator</h1>

    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <p>Voer hieronder je ingrediënten in en ontvang een recept!</p>

<!--    <form action="process.php" method="POST">-->
    <form method="POST">
        <div class="form-group">
            <label for="ingredients">Ingrediënten (gescheiden door komma's):</label>
            <textarea name="ingredients" id="ingredients" rows="3" required
                      placeholder="bijv. ui, knoflook, tomaat, pasta"><?php
                echo isset($_POST['ingredients']) ? htmlspecialchars($_POST['ingredients']) : '';
                ?></textarea>
        </div>
        <button type="submit">Genereer Recept</button>
    </form>


    <?php if ($recepten) : ?>

    <div class="recipe-card">
        <h2> <?=htmlspecialchars($recepten->naam) ?></h2>
        <div class="recipe-details">
            <p><strong>Bereidingstijd:</strong> <?= htmlspecialchars($recepten->bereidingstijd)?> </p>
            <p><strong>Moeilijkheidsgraad:</strong> <?= htmlspecialchars($recepten->moeilijkheidsgraad) ?></p>
        </div>

        <h3>Ingrediënten:</h3>
        <ul>
            <?php foreach ($recepten->ingredienten as $ingredient) {
                echo '<li>' . htmlspecialchars($ingredient) . '</li>';
            } ?>
        </ul>

        <h3>Bereidingswijze:</h3>
        <ol>
            <?php foreach ($recepten->stappen as $stap) {
                echo '<li>' . htmlspecialchars($stap) . '</li>';
            } ?>
        </ol>
    </div>
    <?php endif ?>
</div>
</body>
</html>