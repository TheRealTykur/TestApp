<?php

$json = file_get_contents('php://input');

if ($json != null)
{
    $obj = json_decode($json,true);    // Parse JSON format to PHP object
    $category = $obj['category'];
    $db = new PDO("sqlite:content.db");
    $sql = "SELECT * FROM menu WHERE category='$category'";
    $stmt = $db->query($sql);
    $menu = $stmt->fetchall(PDO::FETCH_ASSOC);    // return menu as an associative array
    $db = NULL;

    echo json_encode($menu);  // Display messages in JSON format
}

?>
