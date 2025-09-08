<?php
namespace App\Models;

class CalculadoraFinanciera
{
    public function calcularInteresCompuesto(float $capital, float $tasaInteresAnual, int $anios): float
    {
        $montoFinal = $capital * pow((1 + $tasaInteresAnual), $anios);
        return $montoFinal;
    }
}