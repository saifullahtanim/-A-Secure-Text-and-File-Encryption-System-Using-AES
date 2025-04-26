<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include("config/connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text_id'])) {
    $id = intval($_POST['text_id']);

    $stmt = $con->prepare("DELETE FROM credentials WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: dashboard.php");
exit();
?>
