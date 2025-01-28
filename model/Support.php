<?php

require_once "Connection.php";

class Supports
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

    // CRUD operations

    /**
     * Create a new support ticket
     * @param $req
     * @return mixed (array|null)
     */
    function create($req)
    {
        // SQL query to insert a new support ticket
        // Can improve with attachment field
        $sql = "INSERT INTO supports
        (
            subject,
            description,
            reported_email,
            type,
            status,
            created_by,
            user_id
        ) VALUES 
        (
            :subject,
            :description,
            :reported_email,
            :type,
            :status,
            :created_by,
            :user_id
        )";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':subject', $req['subject'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $req['description'], PDO::PARAM_STR);
        $stmt->bindParam(':reported_email', $req['reported_email'], PDO::PARAM_STR);
        $stmt->bindParam(':type', $req['type'], PDO::PARAM_STR);
        $stmt->bindParam(':status', $req['status'], PDO::PARAM_STR);
        $stmt->bindParam(':created_by', $req['created_by'], PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $req['user_id'], PDO::PARAM_INT);

        // Execute the query
        // Return true if the query is successful

        $result = $stmt->execute();

        // Return the request if the query is successfull
        // Can be changed with specific value
        if ($result) {

            return $req;
        } else {

            return null;
        }
    }

    /**
     * Read all support tickets
     * @return mixed (array|null)
     */
    function read() 
    {
        $sql = "
            SELECT 
                id, 
                subject,
                description,
                reported_email,
                type,
                status,
                created_by
            FROM 
                supports
            ORDER BY 
                status DESC
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
     * Read all support tickets by user id
     * @param $userId
     * @return mixed (array|null)
     */
    function readByUserId($userId) 
    {

        $sql = "
            SELECT 
                id, 
                subject,
                status  
            FROM 
                supports 
            WHERE 
                user_id = :user_id
            ORDER BY 
                status DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        
        $success = $stmt->execute();

        if ($success) {

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        } else {

            return null;
        }

    }


    /**
     * Read a support ticket by id
     * @param $id
     * @return mixed (array|null)
     */
    function readById($id) 
    {

        $sql = "
            SELECT 
                id, 
                subject,
                description,
                reported_email,
                answer,
                type,
                status,
                created_by
            FROM 
                supports 
            WHERE 
                id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $success = $stmt->execute();

        if ($success) {

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;

        } else {

            return null;
        }

    }

    /**
     * Update a support ticket
     * @param $id
     * @param $status
     * @param $answer
     * @return mixed (array|null)
     */
    function update($id, $status, $answer) 
    {

        $sql = "
            UPDATE 
                supports 
            SET 
                status = :status,
                answer = :answer
            WHERE 
                id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':answer', $answer, PDO::PARAM_STR);

        $success = $stmt->execute();

        if ($success) {

            return [
                "id" => $id,
                "status" => $status,
                "answer" => $answer
            ];

        } else {

            return null;
        }

    }


    /**
     * Update a support ticket status
     * @param $id
     * @param $status
     * @return mixed (array|null)
     */
    function updateStatus($id, $status) 
    {

        $sql = "
            UPDATE 
                supports 
            SET 
                status = :status
            WHERE 
                id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

        $success = $stmt->execute();

        if ($success) {

            return [
                "id" => $id,
                "status" => $status
            ];

        } else {

            return null;
        }

    }

    // Delete a support ticket
    function delete() 
    {

    }

}