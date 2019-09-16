<?php
// sql to create table
$users = "CREATE TABLE users (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$settings = "CREATE TABLE settings (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($users) === TRUE && $conn->query($settings) === TRUE) {
    echo "All Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
    // echo "Error creating table: " . $conn->error ."<a href='setup-config.php?step=2&refresh=1'> Install Again</a>";
}