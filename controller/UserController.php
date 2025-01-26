<?php

require_once __DIR__ . "/../service/UserService.php";

class UserController 
{
    function register($req)
    {
        $userService = new UserService();

        try {
            $result = $userService->register($req);

            return $result;
        
        } catch (ResponseError $e) {
            
            return $e->getMessage();
    
        } catch (PDOException $e) {
            
            return $e->getMessage();
        }
    }
}