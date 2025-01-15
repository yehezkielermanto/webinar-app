<?php

function getConnection(): PDO
{
        $host = "localhost";
        $database = "ifukdcco_webinar";
        $username = "ifukdcco_webinar";
        $password = "hhR2I2n2k2";

        return new PDO("mysql:host=$host;dbname=$database", $username, $password);
}