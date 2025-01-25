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

    // CRUD FUNCTIONS

    // Create a new user
    function create() {

    }

    // Read all users
    function read() {

    }

    // Update a user
    function update() {

    }

    // Delete a user
    function delete() {

    }
  
}