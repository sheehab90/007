<?php
include 'db_config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: show_list.php");
    exit;
}

$id = intval($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Email and phone validation
    $email_valid = preg_match("/^[a-zA-Z0-9._%+-]{4,10}@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email);
    $phone_valid = preg_match("/^[0-9]{11}$/", $phone);

    // Show alerts individually
    if (!$email_valid) {
        echo "<script>alert('Invalid email! Email must have 4–10 characters before @ and a valid domain.');</script>";
    }

    if (!$phone_valid) {
        echo "<script>alert('Invalid phone number! It must be 11 digits.');</script>";
    }

    if ($email_valid && $phone_valid) {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $email, $phone, $id);
        $stmt->execute();
        $stmt->close();

        header("Location: show_list.php");
        exit;
}
}

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type='text'],
        input[type='email'],
        input[type='number']
         {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            
            font-size: 14px;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .back-btn,
        .update-btn {
            padding: 10px 15px;
            background-color: #000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .back-btn:hover,
        .update-btn:hover {
            background-color: dimgrey;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit User</h2>
    <form method="POST">
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        <input type="text" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
        <div class="button-container">
            <input type="submit" value="Update" class="update-btn">
            <a href="show_list.php" class="back-btn">Back to User List</a>
        </div>
    </form>
</div>

</body>
</html>
