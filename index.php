<?php
// Configuratie
$apiKey = "KEY GOES HERE";
$model = "MODEL GOES HERE";

// Functie voor API-verzoek
function callOpenAI($prompt, $apiKey, $model)
{
    $url = "https://api.openAI.io/v1/";
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
    ];

    $data = [
        'model' => $model,
        'messages' => [['role' => 'system', 'content' => 'Je bent een behulpzame assistent.'],
            ['role' => 'user', 'content' => $prompt]]
    ];

    // API-verzoek versturen met cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $notes = $_POST["notes"];
    $systemPrompt = "Je bent een expert in teksten samenvatten. Je taak is om de belangrijkste informatie uit een tekst te halen";
    $response = callOpenAI($systemPrompt . $notes, $apiKey, $model);
    echo "<div class='recipe'>" . nl2br($response['choices'][0]['message']['content']) . "</div>";
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<main>
    <form method="post">
        <h2>
            Samenvatting assistent
        </h2>
        <textarea name="notes" id="notes" cols="30" rows="10" placeholder="Vul hier de tekst in"></textarea>
        <button type="submit">Maak samenvatting</button>
    </form>
</main>
</body>
</html>
