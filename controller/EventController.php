<?php

require_once __DIR__ . "/../service/EventService.php";

class EventController
{
    /**
     * Get all events
     * @return array
     * @throws PDOException
     */
    function get()
    {
        $eventService = new EventsService();

        try {
            
            $result = $eventService->get();

            return [
                "success" => true,
                "message" => "Events fetched successfully",
                "data" => $result
            ];

        } catch (PDOException $e) {

            error_log("(CONTROLLER) Error fetching events: " . $e->getMessage());

            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    /**
     * Get event by id
     * @param int $id
     * @return array
     * @throws PDOException
     */
    function getById($id)
    {
        $eventService = new EventsService();

        try {
            
            $result = $eventService->getById($id);

            return [
                "success" => true,
                "message" => "Event fetched successfully",
                "data" => $result
            ];

        } catch (PDOException $e) {

            error_log("(CONTROLLER) Error fetching event: " . $e->getMessage());

            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }

    /**
     * Publish an event
     * @param int $id
     * @return array
     * @throws PDOException
     */
    function putPublish($id)
    {
        $eventService = new EventsService();

        try {
            
            $result = $eventService->putPublish($id);

            return [
                "success" => true,
                "message" => "Event published successfully",
                "data" => $result
            ];

        } catch (PDOException $e) {

            error_log("(CONTROLLER) Error publishing event: " . $e->getMessage());

            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
    }
}