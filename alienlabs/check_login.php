<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function check_login() {
    return isset($_SESSION['user_id']);
}
?>
