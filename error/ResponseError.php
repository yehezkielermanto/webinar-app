<?php

class ResponseError extends Error
{
    
    function __construct($message)
    {
        parent::__construct($message);
    }
    
}