<?php
include 'db.php';

$id = $_GET['id'] ?? null;
$errors = [];
$success = '';

if (!$id) {
    die("Invalid User ID.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/i", $email)) {
        $errors[] = "Invalid email format.";
    }

    if (!preg_match('/^01[3-9][0-9]{8}$/', $phone)) {
        $errors[] = "Invalid phone number.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE users SET username=?, email=?, phone=? WHERE id=?");
        $stmt->bind_param("sssi", $username, $email, $phone, $id);

        if ($stmt->execute()) {
            $success = "User updated successfully.";
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
    }
}

$result = $conn->prepare("SELECT * FROM users WHERE id = ?");
$result->bind_param("i", $id);
$result->execute();
$user = $result->get_result()->fetch_assoc();

if (!$user) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <?php if (!empty($success)): ?>
        <meta http-equiv="refresh" content="2;url=create.php">
    <?php endif; ?>
</head>
<body>

<h2>Edit User</h2>

<form method="POST" autocomplete="off">
    <label>Username:</label><br>
    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>"><br><br>

    <label>Email:</label><br>
    <input type="text" name="email" value="<?= htmlspecialchars($user['email']) ?>"><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>"><br><br>

    <button type="submit">Update</button>
</form>

<?php if (!empty($success)): ?>
    <p style="color: green;"><strong><?= htmlspecialchars($success) ?></strong></p>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <ul style="color: red;">
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>
</html>
