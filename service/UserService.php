<?php

require_once __DIR__ . "/../model/User.php";
require_once __DIR__ . "/../error/ResponseError.php";

class UserService 
{

    // CRUD operations

    // Create a new user
    function register($req) 
    {
        
        $user = new User();

        $countUser = $user->count($req['username']);

        // Check if the username already exists
        if ($countUser > 0) {
            throw new ResponseError("Username already exists");
        }

        // Hash the password
        $req['password'] = password_hash($req['password'], PASSWORD_DEFAULT);

        // Set the role to USER by default
        $req['role'] = "USER";

        // Set the status_verification to 0 by default
        $req['status_verification'] = 0;

        // Set the vkey to a random string
        $req['vkey'] = md5(time() . $req['username']);

        // Set the type to INTERNAL by default
        $req['type'] = "INTERNAL";

        // Set the status to 1 by default
        $req['status'] = 1;

        return $user->create($req);
    }

    function login($req) 
    {

        $user = new User();

        $userExists = $user->readUnique($req['username']);

        if (!$userExists) {
            throw new ResponseError("Username or password is wrong");
        }

        if (!password_verify($req['password'], $userExists['password'])) {
            throw new ResponseError("Username or password is wrong");
        } 

        return $userExists;
    }
        

}