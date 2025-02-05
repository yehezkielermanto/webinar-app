<?php 

require_once __DIR__ . "/../model/Event.php";

class EventsService
{
    /**
     * Get all events
     * @return array|null
     */
    function get()
    {
        $event = new Event();

        return $event->read();
    }

    /**
     * Get event by id
     * @param int $id
     * @return array|null
     */
    function getById($id)
    {
        $event = new Event();

        return $event->readById($id);
    }

    function putPublish($id)
    {
        $event = new Event();

        return $event->updatePublishedById($id);
    }
}