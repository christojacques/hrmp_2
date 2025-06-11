<?php
require_once 'private/protection.php'; // connect to DB

$passwordInput = $_POST['password'] ?? '';

if (password_verify($passwordInput, $fetch_employee['password'])) {
    echo 'valid';
} else {
     echo 'invalid';
}