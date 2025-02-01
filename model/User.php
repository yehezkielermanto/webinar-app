<?php

require_once "Connection.php";

class User
{
    private $conn;

    // Constructor to connect to the database
    function __construct()
    {
        $this->conn = Connection::connect();
    }

    // CRUD operations

    // Create a new user
    function create($req) 
    {
        // SQL query to insert a new user
        $sql = "INSERT INTO users
        (
            fullname,
            username,
            password,
            email,
            phone,
            institution,
            address,
            gender,
            role,
            status_verification,
            vkey,
            type,
            status
        ) VALUES 
        (
            :fullname,
            :username,
            :password,
            :email,
            :phone,
            :institution,
            :address,
            :gender,
            :role,
            :status_verification,
            :vkey,
            :type,
            :status
        )";
        
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':fullname', $req['fullname'], PDO::PARAM_STR);
        $stmt->bindParam(':username', $req['username'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $req['password'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $req['email'], PDO::PARAM_STR);
        $stmt->bindParam(':phone', $req['phone'], PDO::PARAM_STR);
        $stmt->bindParam(':institution', $req['institution'], PDO::PARAM_STR);
        $stmt->bindParam(':address', $req['address'], PDO::PARAM_STR);
        $stmt->bindParam(':gender', $req['gender'], PDO::PARAM_STR);
        $stmt->bindParam(':role', $req['role'], PDO::PARAM_STR);
        $stmt->bindParam(':status_verification', $req['status_verification'], PDO::PARAM_STR);
        $stmt->bindParam(':vkey', $req['vkey'], PDO::PARAM_STR);
        $stmt->bindParam(':type', $req['type'], PDO::PARAM_STR);
        $stmt->bindParam(':status', $req['status'], PDO::PARAM_STR);

        $success = $stmt->execute();

        // If the query is successful, return the last inserted ID
        if ($success) {

            return [
                "id" => $this->conn->lastInsertId(),
                "username" => $req['username'],
                "email" => $req['email']
            ];
        } else {
            
            return null;
        }
    }

    // Read all users
    function read() 
    {
        

    }

    // Read a user
    function readUnique($username) 
    {
        $sql = 
        "
            SELECT user_id, username, password, role, email 
            FROM users 
            WHERE username = :username
        ";
        

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        $success = $stmt->execute();

        if ($success) {

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } else {

            return null;
        }
    }

    // Update a user
    function update() 
    {

    }

    // Delete a user
    function delete() 
    {

    }

    function count($username) : int
    {
        $sql = "SELECT COUNT(username) FROM users WHERE username = :username";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->fetchColumn();

        return $count;
    }
  
}