<?php
$conn = new mysqli("localhost", "root", "", "bookmyshow");

if ($conn->connect_error) {
    die("DB Connection Failed");
}
?>