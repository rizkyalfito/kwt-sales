<?php

namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    protected $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->setup();
    }

    protected function setup()
    {
        $config = config('Email');
        
        // Server settings
        $this->mail->isSMTP();
        $this->mail->Host       = $config->SMTPHost ?? 'smtp.gmail.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $config->SMTPUser ?? 'kelompokwanitatani91@gmail.com';
        $this->mail->Password   = $config->SMTPPass ?? 'jmua zdeb esev lvfg';
        $this->mail->SMTPSecure = $config->SMTPCrypto ?? 'tls';
        $this->mail->Port       = $config->SMTPPort ?? 587;

        // Recipients
        $this->mail->setFrom($config->fromEmail ?? 'kelompokwanitatani91@gmail.com', $config->fromName ?? 'Kelompok Wanita Tani');

        // Content
        $this->mail->isHTML(true);
        $this->mail->CharSet = 'UTF-8';
    }

    public function sendResetPasswordEmail($email, $resetLink)
    {
        try {
            $this->mail->addAddress($email);
            $this->mail->Subject = 'Reset Password - Kelompok Wanita Tani';
            
            $this->mail->Body = view('emails/reset-password', [
                'resetLink' => $resetLink,
                'email' => $email
            ]);

            $this->mail->AltBody = "Halo,\n\nAnda telah meminta reset password untuk akun Anda.\n\nSilakan klik link berikut untuk reset password: {$resetLink}\n\nLink ini akan kadaluarsa dalam 1 jam.\n\nJika Anda tidak meminta reset password, abaikan email ini.\n\nTerima kasih,\nKelompok Wanita Tani";

            return $this->mail->send();
        } catch (Exception $e) {
            log_message('error', 'Email could not be sent. Error: ' . $this->mail->ErrorInfo);
            return false;
        }
    }
}
