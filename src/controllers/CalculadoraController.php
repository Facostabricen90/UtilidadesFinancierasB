<?php
namespace App\Controllers;

use App\Models\CalculadoraFinanciera;
use App\Models\CalculadoraSalarial;

class CalculadoraController
{
    private $resultado = null;
    private $error = null;

    public function interesCompuesto()
    {
        if (isset($_POST['capital'], $_POST['tasa'], $_POST['anios']) &&
            is_numeric($_POST['capital']) && is_numeric($_POST['tasa']) && is_numeric($_POST['anios'])) {
            
            $capital = (float)$_POST['capital'];
            $tasa = (float)$_POST['tasa'] / 100;
            $anios = (int)$_POST['anios'];

            $calculadora = new CalculadoraFinanciera();
            $this->resultado = $calculadora->calcularInteresCompuesto($capital, $tasa, $anios);
        } else {
            $this->error = "Por favor, ingresa todos los valores numéricos para el interés compuesto.";
        }
    }

    public function salarioNeto()
    {
        if (isset($_POST['salarioBruto']) && is_numeric($_POST['salarioBruto'])) {
            $salarioBruto = (float)$_POST['salarioBruto'];

            $calculadora = new CalculadoraSalarial();
            $this->resultado = $calculadora->calcularSalarioNeto($salarioBruto);
        } else {
            $this->error = "Por favor, ingresa un valor numérico para el salario bruto.";
        }
    }
    
    public function getResultado()
    {
        return $this->resultado;
    }
    
    public function getError()
    {
        return $this->error;
    }
}