<?php

require_once __DIR__ . "/../service/SupportService.php";

class SupportController
{

    // Create a new support ticket
    function create($req)
    {
        $supportService = new SupportService();

        try {

            $result = $supportService->create($req);

            // Send email to the support team
            // Can be changed with support email
            $supportService->sendSupportTicketEmail(
                "nekoowaves@gmail.com",
                $req['subject'],
                $req['description'],
                $req['reported_email']
            );

            return [
                "success" => true,
                "message" => "Support ticket created successfully",
                "data" => $result
            ];

        } catch (PDOException $e) {

            error_log("(CONTROLLER) Error creating support ticket: " . $e->getMessage());

            return [
                "success" => false,
                "message" => $e->getMessage()
            ];

        } catch (ResponseError $e) {

            error_log("(CONTROLLER) Error creating support ticket: " . $e->getMessage());

            return [
                "success" => false,
                "message" => $e->getMessage()
            ];

        }

        
    }

    // List all support tickets by user id
    function list($userId)
    {
        $supportService = new SupportService();

        try {

            $result = $supportService->list($userId);

            return [
                "success" => true,
                "message" => "Support ticket retrieved successfully",
                "data" => $result
            ];

        } catch (PDOException $e) {

            error_log("(CONTROLLER) Error retrieving support ticket: " . $e->getMessage());

            return [
                "success" => false,
                "message" => $e->getMessage()
            ];

        }
    }
}