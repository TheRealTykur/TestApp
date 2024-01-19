<?php
session_start();

    include "functions.php";

    $json = file_get_contents('php://input');  // Get JSON inputs, store in variable
    
    
    $obj = json_decode($json,true); // Parse JSON format to PHP object

    if (isset($_SESSION['record'])) 
    {
        $record = $_SESSION['record'];
        $email = $record['email'];
        $item_id = $obj['item_id'];
        $task = $obj['task'];
        if ($task == 'delete')
        {
            deleteItem($email, $item_id);
        }
        if ($task == 'changeQ') {
            $quantity = $obj['newQuant'];
            changeQuantity($quantity, $email, $item_id);
        }
    }
    $record = $_SESSION['record'];
    $email = $record['email'];
    $db = new PDO("sqlite:content.db");
    $sql = "SELECT * FROM cart WHERE email='$email'";
    $stmt = $db->query($sql);

    $cart = $stmt->fetchall(PDO::FETCH_ASSOC); // return cart as an associative array

    $db = NULL;

    echo json_encode($cart);  // Display messages in JSON format
?>
