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
}