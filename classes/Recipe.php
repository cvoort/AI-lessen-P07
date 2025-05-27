<?php

namespace classes;

class Recipe
{
    public string $naam;
    public array $ingredienten;
    public string $bereidingstijd;
    public array $stappen;
    public string $moeilijkheidsgraad;

    public function __construct(string $naam,
                                array $ingredienten,
                                string $bereidingstijd,
                                array $stappen,
                                string $moeilijkheidsgraad) {
        $this->naam = $naam;
        $this->ingredienten = $ingredienten;
        $this->bereidingstijd = $bereidingstijd;
        $this->stappen = $stappen;
        $this->moeilijkheidsgraad = $moeilijkheidsgraad;
    }
}