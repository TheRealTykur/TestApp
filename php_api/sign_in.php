<?php
session_start();
include "functions.php";

    $json = file_get_contents('php://input'); // Get JSON inputs, store in variable
    $obj = json_decode($json, true);
    $email = $obj['email'];
    $password = $obj['password'];
    $validEmail = false;
    $validPassword = false;

    if ($email != NULL) 
    {
        $validEmail = true;
    }
    else 
    {
        $msgs['emailErr'] = "Email address is required";
    }

    if ($password != NULL) 
    {
        $validPassword = true;
    }
    else 
    {
        $msgs['passErr'] = "Password is required";
    }

    if ($validEmail && $validPassword)
    {
        $record = getUserRecord($email);
        $hashed = $record['password'];
        
        // Use built in function to compare entered password to hashed password in database
        if ($record && password_verify($password, $hashed)) 
        {    
            $_SESSION['record'] = $record;        
            $msgs['succ'] = "Success";
        }
        else 
        {
            $msgs['incorrect'] = "Incorrect Email/Password Entry";
        }
    }
    echo json_encode($msgs);  // Output messages in JSON format
?>
