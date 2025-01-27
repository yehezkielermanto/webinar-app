<?php

require_once __DIR__ . "/../model/Support.php";

class SupportService
{
    // CRUD operations

    // Create a new support ticket
    function create($req)
    {
        $support = new Supports();

        $req['status'] = "PENDING";

        return $support->create($req);
    }

    function sendSupportTicketEmail($to, $subject, $description, $from): void
    {
        // Send email to the support team
        
        $result  = mail($to, $subject, $description, "From: $from");

        if (!$result) {
            throw new ResponseError("Failed to send email");
        }
        
    }

    function list($userId): array
    {
        $support = new Supports();

        return $support->readByUserId($userId);
    }
}
