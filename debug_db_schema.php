<?php
try {
    $db = new PDO('mysql:host=localhost;port=3307;dbname=furryup_db', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $db->query('DESCRIBE tbl_adoption_request');
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        echo implode('|', $row) . PHP_EOL;
    }
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage();
}
