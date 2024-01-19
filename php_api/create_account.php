<?php
session_start();
include "functions.php";

    $json = file_get_contents('php://input'); // Get JSON inputs, store in variable
    
    $obj = json_decode($json,true); // Parse JSON format to PHP object
    
    // Set user variables from input
    $fname = $obj['fname'];
    $lname = $obj['lname'];
    $email = $obj['email'];
    $password1 = $obj['password1'];
    
    $inserted = true;

    if ($fname != NULL && $lname != NULL && $email != NULL && !doesEmailExist($email) && $password1 != NULL)
    {
        $hashed = password_hash($password1, PASSWORD_DEFAULT);
        $inserted = insertUserRecord($fname, $lname, $email, $hashed);

        if ($inserted)
        {
            $msgs['suc'] = "Success";
            $record = getUserRecord($email);
            $_SESSION['record'] = $record;
        }
        else
        {
            $msgs['fail'] = "Register failed: Check connection";
        }
    }
    else
    {
        if ($fname == NULL)
        {
            $msgs['fnameErr'] = "First name is required"; 
        }
        if ($lname == NULL)
        {
            $msgs['lnameErr'] = "Last name is required";
        }
        if ($email == NULL)
        {
            $msgs['eErr'] = "Email address is required";
        }
        if (doesEmailExist($email))
        {
            $msgs['eTaken'] = "The email you entered is already being used";
        }
        if ($password1 == NULL)
        {
            $msgs['passReq'] = "Password is required";
        }
    }
    echo json_encode($msgs);  // Display messages in JSON format
?>
