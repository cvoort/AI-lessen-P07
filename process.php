<?php
// Inclusief de AIWrapper klasse
use classes\AIWrapper;

require_once 'classes/AIWrapper.php';
require_once 'config/config.php';

$recipe = '';
$error = '';

// Controleer of het formulier is verzonden
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['ingredients'])) {
    try {
//        // Valideer en verwerk de ingrediënten
//        $ingredientsInput = trim($_POST['ingredients']);
//        if (empty($ingredientsInput)) {
//            throw new \Exception('Geen ingrediënten opgegeven');
//        }
//
//        // Splits de ingrediënten op komma's en verwijder witruimte
//        $ingredients = array_map('trim', explode(',', $ingredientsInput));

        $ingredients = explode(', ', $_POST['ingredients']);
        $ingredients = array_map('trim', $ingredients);

        // Maak een nieuwe instantie van de AIWrapper
        $wrapper = new AIWrapper(API_KEY);

        // Verwerk de ingrediënten
//        $wrapper->processInput($ingredients);
        $recipe = $wrapper->generateRecipe($ingredients);


        // Haal het antwoord op
//        $response = $wrapper->getResponse();

        // Stuur terug naar index met antwoord
//        header('Location: index.php?message=' . urlencode($response));
//        exit;
    } catch (\Exception $e) {
        // Stuur terug naar index met foutmelding
//        header('Location: index.php?message=Fout: ' . urlencode($e->getMessage()));
        $error = $e->getMessage();
        exit;
    }
} else {
    // Als het formulier niet correct is verzonden
    header('Location: index.php?message=Ongeldig verzoek');
    exit;
}