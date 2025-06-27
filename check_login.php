<?php
session_start();
if (isset($_SESSION['dangnhap'])) {
    echo json_encode([
        'loggedIn' => true,
        'username' => $_SESSION['dangnhap']
    ]);
} else {
    echo json_encode(['loggedIn' => false]);
}
?>
