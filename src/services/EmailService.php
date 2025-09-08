<?php
namespace App\Services;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class EmailService
{
    private $mailer;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config.php';
        $transport = Transport::fromDsn($config['mailer_dsn']);
        $this->mailer = new Mailer($transport);
    }

    public function enviarCorreoSalario(string $destinatario, float $salarioBruto, float $salarioNeto): bool
    {
        $email = (new Email())
            ->from('no-reply@utilidadesfinancieras.com')
            ->to($destinatario)
            ->subject('Resultado de Cálculo de Salario Neto')
            ->html("
                <h1>Cálculo de Salario Neto</h1>
                <p>Hola,</p>
                <p>Aquí está el resultado de tu cálculo:</p>
                <ul>
                    <li><strong>Salario Bruto Ingresado:</strong> $" . number_format($salarioBruto, 2) . "</li>
                    <li><strong>Salario Neto Calculado:</strong> $" . number_format($salarioNeto, 2) . "</li>
                </ul>
                <p>Gracias por usar nuestra aplicación.</p>
            ");

        try {
            $this->mailer->send($email);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}