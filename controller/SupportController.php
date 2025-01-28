<?php

require_once __DIR__ . "/../service/SupportService.php";

class SupportController
{

    /**
     * Create a new support ticket
     * @param $req
     * @return mixed (array|null)
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

    /**
     * Get all support tickets
     * @return mixed (array|null)
     * @throws PDOException
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
     * Get support ticket by ID
     * @param $id
     * @return mixed (array|null)
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
     * @return mixed (array|null)
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
     * @return mixed (array|null)
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
     * @return mixed (array|null)
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