<?php
include 'db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: create.php");
    exit;
} else {
    echo "Error deleting user.";
}

$stmt->close();
?>