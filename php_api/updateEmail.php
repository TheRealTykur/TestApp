<?php
session_start();
include "functions.php";

  $record = $_SESSION['record'];
  $email = $record['email'];
  $hashed = $record['password'];

  $json = file_get_contents('php://input');
  $obj = json_decode($json,true);
  $emailNew = $obj['emailUp'];
   
  $passEntered = $obj['currPass'];

  $passMatch = false;
  $updatedE = false;

  if ($emailNew != NULL && !updateEmailExist($emailNew,$hashed) && $passEntered != NULL)
  {
    $passMatch = password_verify($passEntered, $hashed);
    if ($passMatch)
    {
      $updatedE = updateEmail($emailNew,$hashed);
      if ($updatedE)
      {
        $newRecord = getUserRecord($emailNew);
        $_SESSION['record'] = $newRecord;
        $msgs['succ'] = "Successfully Updated";
      }
      else
      {
        $msgs['fail'] = "Could not insert";
      }
    }
    else 
    {
      $msgs['incorPass'] = "Invalid email/password combo";
    }
  }
  else
  {
    if ($emailNew == NULL) 
    {
      $msgs['eErr'] = "Valid email address is required";
    }
    if (updateEmailExist($emailNew,$hashed))
    {
      $msgs['eTaken'] = "The email address entered is already taken";
    }
    if ($passEntered == NULL)
    {
      $msgs['emptPass'] = "Current password is required";
    }
  }
  echo json_encode($msgs);  // Display messages in JSON format

?>