<?php

class Supports
{
    private $conn;

    // Constructor to connect to the database
    function __construct()
    {
        $this->conn = Connection::connect();
    }

    // CRUD FUNCRTIONS

    // Create a new support ticket
    function create() {

    }

    // Read all support tickets
    function read() {

    }

    // Update a support ticket
    function update() {

    }

    // Delete a support ticket
    function delete() {

    }

}