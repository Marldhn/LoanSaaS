<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';


class NotificationService
{

    public function sendEmail($to, $subject, $body)
    {

        $mailConfig = require dirname(__DIR__) . '/core/mail.php';


        $mail = new PHPMailer(true);


        try {

            $mail->isSMTP();

            $mail->Host = $mailConfig['host'];
            $mail->SMTPAuth = true;

            $mail->Username = $mailConfig['username'];
            $mail->Password = $mailConfig['password'];

            $mail->SMTPSecure = $mailConfig['encryption'];
            $mail->Port = $mailConfig['port'];


            $mail->setFrom(
                $mailConfig['from_email'],
                $mailConfig['from_name']
            );


            $mail->addAddress($to);


            $mail->isHTML(true);

            $mail->Subject = $subject;

            $mail->Body = nl2br($body);

            $mail->AltBody = $body;


            $mail->send();


            return [
                "success" => true
            ];


        } catch(Exception $e) {

            return [
                "success" => false,
                "message" => $mail->ErrorInfo
            ];

        }

    }

}