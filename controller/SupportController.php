<?php

require_once __DIR__ . "/../service/SupportService.php";

class SupportController
{

    /**
     * Create a new support ticket
     * @param $req
     * @return array
     * @throws PDOException
     * @throws ResponseError
     */
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
                $req['reported_email'],
                $result['attachment'] ?? null
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

    /**
     * Get all support tickets
     * @return array
     * @throws PDOException
     * @throws ResponseError
     */
    function get()
    {
        $supportService = new SupportService();

        try {

            $result = $supportService->get();

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


    /**
     * Filter support tickets
     * @param $req
     * @return array
     * @throws PDOException
     */
    function filter($req)
    {
        $supportService = new SupportService();

        try {

            $result = $supportService->filterTickets($req);

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

    /**
     * Get support ticket by ID
     * @param $id
     * @return array
     * @throws PDOException
     */
    function getbyId($id)
    {
        $supportService = new SupportService();

        try {

            $result = $supportService->getbyId($id);

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

    /**
     * Get all support tickets by user ID
     * @param $userId
     * @return array
     * @throws PDOException
     */
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

    /**
     * Update support ticket status
     * @param $req
     * @return array
     * @throws PDOException
     * @throws ResponseError
     */
    function update($req)
    {
        $supportService = new SupportService();

        try {

            $result = $supportService->update($req);


            // Reply email to the support team
            // Can be changed with support email
            $supportService->sendSupportTicketEmail(
                $req['reported_email'],
                $req['subject'],
                $req['description'],
                "nekoowaves@gmail.com"
            );

            return [
                "success" => true,
                "message" => "Support ticket updated successfully",
                "data" => $result
            ];

        } catch (PDOException $e) {

            error_log("(CONTROLLER) Error updating support ticket: " . $e->getMessage());

            return [
                "success" => false,
                "message" => $e->getMessage()
            ];

        } catch (ResponseError $e) {

            error_log("(CONTROLLER) Error updating support ticket: " . $e->getMessage());

            return [
                "success" => false,
                "message" => $e->getMessage()
            ];

        }
    }


    /**
     * Update support ticket status
     * @param $req
     * @return array
     * @throws PDOException
     * @throws ResponseError
     */
    function updateStatus($req)
    {
        $supportService = new SupportService();

        try {

            $result = $supportService->updateStatus($req);

            return [
                "success" => true,
                "message" => "Support ticket status updated successfully",
                "data" => $result
            ];

        } catch (PDOException $e) {

            error_log("(CONTROLLER) Error updating support ticket status: " . $e->getMessage());

            return [
                "success" => false,
                "message" => $e->getMessage()
            ];

        } catch (ResponseError $e) {

            error_log("(CONTROLLER) Error updating support ticket status: " . $e->getMessage());

            return [
                "success" => false,
                "message" => $e->getMessage()
            ];

        }
    }
}