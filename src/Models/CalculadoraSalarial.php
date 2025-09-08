<?php
namespace App\Models;

class CalculadoraSalarial
{
    private const DEDUCCION_SALUD = 0.04; // 4%
    private const DEDUCCION_PENSION = 0.04; // 4%

    public function calcularSalarioNeto(float $salarioBruto): float
    {
        $descuentoSalud = $salarioBruto * self::DEDUCCION_SALUD;
        $descuentoPension = $salarioBruto * self::DEDUCCION_PENSION;

        $salarioNeto = $salarioBruto - $descuentoSalud - $descuentoPension;

        return $salarioNeto;
    }
}