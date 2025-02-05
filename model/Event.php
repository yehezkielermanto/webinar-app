<?php

require_once "Connection.php";

class Event 
{
    private $conn;

    /**
     * Supports constructor.
     * Create a new connection to the database
     */
    function __construct()
    {
        $this->conn = Connection::connect();
    }

    /**
     * Create a new event
     * @return mixed (array|null)
     */
    function read()
    {
        $sql = 
        "
            SELECT
                id,
                poster_url,
                event_name,
                background_online_url,
                title,
                description,
                date,
                start_time,
                end_time,
                type,
                link,
                speaker,
                published,
                is_internal,
                status,
                attendance_type,
                slug,
                remark
            FROM
                events
        ";

        $stmt = $this->conn->prepare($sql);
        
        $success = $stmt->execute();

        if ($success) {

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } else {

            return null;
        }
    }

    /**
     * Get event by id
     * @param $id
     * @return mixed (array|null)
     */
    function readById($id)
    {

        $sql = 
        "
            SELECT
                id,
                poster_url,
                event_name,
                background_online_url,
                title,
                description,
                date,
                start_time,
                end_time,
                type,
                link,
                speaker,
                published,
                is_internal,
                status,
                attendance_type,
                slug,
                remark
            FROM
                events
            WHERE
                id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        $success = $stmt->execute();

        if ($success) {

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

        } else {

            return null;
        }

    }


    /**
     * Update event status
     * @param $id
     * @return bool
     */
    function updatePublishedById($id)
    {
        $sql = 
        "
            UPDATE
                events
            SET
                published = 1
            WHERE
                id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        $success = $stmt->execute();

        if ($success) {

            return true;

        } else {

            return false;
        }
        
    }

}