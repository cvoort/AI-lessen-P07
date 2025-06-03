<?php

namespace classes;

class RecipeFormatter
{
    public function formatRecipe(string $rawOutput): ?Recipe {
        try {
            // Probeer de output te decoderen als JSON
            $data = json_decode($rawOutput, true);

            // Controleer of de benodigde velden aanwezig zijn
            if (!$data || !isset($data['naam']) || !isset($data['ingrediënten']) || !isset($data['bereidingstijd']) ||
                !isset($data['stappen']) || !isset($data['moeilijkheidsgraad'])) {
                return null;
            }

            return new Recipe(
                $data['naam'],
                $data['ingrediënten'],
                $data['bereidingstijd'],
                $data['stappen'],
                $data['moeilijkheidsgraad']
            );
        } catch (\Exception $e) {
            // Bij fouten return null
            return null;
        }
    }
//
//    // Voeg deze methode toe aan je RecipeFormatter class
//    public function tryExtractRecipe(string $rawOutput): ?Recipe {
//        // Eerst proberen als JSON te parsen
//        $recipe = $this->formatRecipe($rawOutput);
//        if ($recipe) return $recipe;
//        // Als dat mislukt, proberen we een minder strenge methode
//        // Bijvoorbeeld: reguliere expressies gebruiken om data te extraheren
//        $naam = $this->extractName($rawOutput);
//        $ingrediënten = $this->extractIngredients($rawOutput);
//        // ... andere extracties
//        if ($naam && !empty($ingrediënten)) {
//            return new Recipe($naam, $ingrediënten, "Onbekend", [], "Onbekend");
//        }
//        return null;
//    }
//
//    private function extractName(string $rawOutput): ?string {
//        /* ... */
//    }
}