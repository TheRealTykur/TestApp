<?php
session_start();

include "functions.php";

    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);
    $order_id = $obj['sendOrder'];
    $record = $_SESSION['record'];
    $email = $record['email'];

    cancelOrder($order_id,$email);

    $db = new PDO("sqlite:content.db");
    $sql = "SELECT * FROM orderInfo WHERE email='$email' AND status='Pending' OR status='In Progress'";
    $stmt = $db->query($sql);
    $orderInfo = $stmt->fetchall(PDO::FETCH_ASSOC);  // return cart as an associative array
    $db = NULL;

    echo json_encode($orderInfo);
?>