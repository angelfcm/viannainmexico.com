<?php

$hostname = "sql166.main-hosting.eu";
$database = "u777516773_viann";
$username = "u777516773_admin";
$password = "TD!C]z3,H_Ts";

// Create connection
$conn = new mysqli($hostname, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";