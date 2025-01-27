<?php

require_once "Connection.php";

class Supports
{
    private $conn;

    // Constructor to connect to the database
    function __construct()
    {
        $this->conn = Connection::connect();
    }

    // CRUD operations

    // Create a new support ticket
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

    // Read all support tickets
    function read() 
    {

    }

    // Update a support ticket
    function update() 
    {

    }

    // Delete a support ticket
    function delete() 
    {

    }

}