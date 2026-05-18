<?php
require __DIR__ . '/../model/database.php';
$db = new Database();
$conn = $db->connectDB();
$conn->exec("ALTER TABLE tbl_adoption_request ADD COLUMN address VARCHAR(255) NULL AFTER fullName");
echo "ALTER OK";
