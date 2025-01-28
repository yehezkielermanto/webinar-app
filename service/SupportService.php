<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once __DIR__ . "/../model/Support.php";


class SupportService
{
    // CRUD operations

    /**
     * Create a new support ticket
     * @param $req
     * @return mixed (array|null)
     */
    function create($req)
    {
        $support = new Supports();

        $req['status'] = "PENDING";

        return $support->create($req);
    }

    /**
     * Get all support tickets
     * @return mixed (array|null)
     */
    function get()
    {
        $support = new Supports();

        return $support->read();
    }

    /**
     * Get support ticket by ID
     * @param $id
     * @return mixed (array|null)
     */
    function getbyId($id)
    {
        $support = new Supports();

        return $support->readById($id);
    }

    /**
     * Send email to the support team
     * @param $to
     * @param $subject
     * @param $description
     * @param $from
     */
    function sendSupportTicketEmail($to, $subject, $description, $from): void
    {
        $mail = new PHPMailer(true);

        // Set mailer to use SMTP
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "ekaadev9@gmail.com";
        $mail->Password = "cvay lkhq ylug fbtv";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($from);
        $mail->addAddress($to);
        $mail->addReplyTo($from);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $description;

        $result = $mail->send();
        
        if (!$result) {
            throw new ResponseError("Failed to send email");
        }
        
    }

    /**
     * Get all support tickets by user ID
     * @param $userId
     * @return mixed (array|null)
     */
    function list($userId): array
    {
        $support = new Supports();

        return $support->readByUserId($userId);
    }

    /**
     * Update support ticket status
     * @param $req
     * @return mixed (array|null)
     */
    function update($req)
    {
        $support = new Supports();

        return $support->update($req['id'], $req['status'], $req['description']);
    }


    /**
     * Update support ticket status
     * @param $req
     * @return mixed (array|null)
     */
    function updateStatus($req)
    {
        $support = new Supports();

        return $support->updateStatus($req['id'], $req['status']);
    }
}
