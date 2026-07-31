<?php

require_once dirname(__DIR__) . '/services/NotificationService.php';


class NotificationController
{

    public function sendReminder()
    {

        header('Content-Type: application/json');


        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            echo json_encode([
                "success" => false,
                "message" => "Invalid request method"
            ]);

            return;
        }


        $email = $_POST['to_email'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $body = $_POST['body'] ?? '';


        if(empty($email)) {

            echo json_encode([
                "success" => false,
                "message" => "Email is required"
            ]);

            return;

        }


        $notification = new NotificationService();


        echo json_encode(
            $notification->sendEmail(
                $email,
                $subject,
                $body
            )
        );

    }

}