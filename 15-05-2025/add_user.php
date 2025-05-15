<?php
include 'db_config.php';

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
        $stmt = $conn->prepare("INSERT INTO users (username, email, phone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $phone);
        $stmt->execute();
        $stmt->close();

        header("Location: show_list.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 20px 25px;
            border-radius: 10px;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .back-btn,
        .submit-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
            background-color: dimgrey;
            color: white;
        }
        .back-btn {
            background-color: #6c757d;
        }
        .submit-btn:hover {
            background-color: #000 ;
        }
        .back-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add New User</h2>
    <form method="POST">
        <label for="username">User Name:</label>
        <input type="text" name="username" id="username" required>
        
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required>
       
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required>
     
        <div class="button-container">
            <input type="submit" value="Add User" class="submit-btn">
            <a href="show_list.php" class="back-btn">Back to User List</a>
        </div>
    </form>
</div>

</body>
</html>
