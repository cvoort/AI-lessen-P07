<?php

namespace classes;

use Exception;

class AIWrapper
{
//    private $ingredients = [];
//    private $response = '';
    private $apiKey;
    private $model;
    private $apiUrl = "https://api.openai.com/v1/chat/completions";

    public function __construct($apiKey, $model = 'gpt-3.5-turbo'){
        // Controleer of config beschikbaar is
//        if (!defined('API_KEY')) {
//            require_once __DIR__ . '/../config/config.php';
//        }
        $this->apiKey = $apiKey;
        $this->model = $model;
    }

    /**
     * @throws Exception
     */
    private function callOpenAI($prompt)
    {
//        $url = "https://api.openAI.io/v1/chat/completions";
//        $headers = [
//            'Content-Type: application/json',
//            'Authorization: Bearer ' . $this->apiKey,
//        ];

        try {
            $data = [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'Je bent een expert chef.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.7
            ];


            // API-verzoek versturen met cURL
            $ch = curl_init($this->apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if (curl_errno($ch)) {
                throw new Exception('cUrl error: ' . curl_error($ch));
            }

            curl_close($ch);

            return $this->handleResponse($response, $httpCode);
        } catch (Exception $e) {
            $error = $e->getMessage();
            return $error;
        }
    }

    /**
     * @throws Exception
     */
    private function handleResponse($response, $httpCode) {
        if ($httpCode != 200) {
            $error = json_decode($response, true);
            $message = isset($error['error']['message']) ?
                $error['error']['message'] : 'Onbekende API fout';
            throw new Exception('API error (Code: ' . $httpCode . '): ' . $message);
        }

        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('JSON decode error: ' . json_last_error_msg());
        }

        if (!isset($decoded['choices'][0]['message']['content'])) {
            throw new Exception('Onverwachte API response structuur');
        }

        return $decoded['choices'][0]['message']['content'];
    }


//    public function processInput($ingredients){
//        if (empty($ingredients)) {
//            throw new \Exception('Geen ingredienten opgegeven');
//        }
//
//        $this->ingredients = $ingredients;
//        // Later hier API aanroepen
////        $apiKey = API_KEY;
////        $systemPrompt = "Je bent een chef-kok. Maak een recept met deze ingrediënten:";
////        $this->response = $this->callOpenAI($systemPrompt . $ingredients, $apiKey, $model);
//        return true;
//    }

    /**
     * @throws Exception
     */
    public function generateRecipe($ingredients){
        if (!is_array($ingredients)) {
            throw new Exception('Ingrediënten moeten als array worden doorgegeven');
        }

        if (count($ingredients) === 0) {
            throw new Exception('Geef minimaal 1 ingrediënt op ');
        }

        // Voorlopig een standaard bericht teruggeven
        $ingredientsList = implode(', ', $ingredients);

        $prompt = <<<EOT
Geef me een recept op basis van deze ingrediënten: $ingredientsList.
Retourneer ALLEEN een JSON object met de volgende structuur:
{
    \"naam\": \"[receptnaam]\",
    \"ingrediënten\": [\"ingrediënt1\", \"ingrediënt2\", ...],
    \"bereidingstijd\": \"[tijd in minuten]\",
    \"stappen\": [\"stap1\", \"stap2\", ...],
    \"moeilijkheidsgraad\": \"[makkelijk/gemiddeld/moeilijk]\"
}
EOT;


        return $this->callOpenAI($prompt);
    }
}