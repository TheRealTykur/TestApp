<?php
session_start();
include "functions.php";

    $json = file_get_contents('php://input'); // Get JSON inputs, store in variable
    $obj = json_decode($json, true);
    $email = $obj['email'];
    $password = $obj['password'];

    if ($email != NULL && $password != NULL)
    {
        $record = getUserRecord($email);
        
        if ($record && password_verify($password, $record['password'])) 
        {
            $_SESSION['record'] = $record;
            $msgs['succ'] = "Success";
        }
        else 
        {
            $msgs['incorrect'] = "Incorrect Email/Password Entry";
        }
    }
    else
    {
        if ($email != NULL) 
        {
            $msgs['emailErr'] = "Email address is required";
        }
        else
        {
            $msgs['passErr'] = "Password is required";
        }
    }
    echo json_encode($msgs);  // Output messages in JSON format
?>
