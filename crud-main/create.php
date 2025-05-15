<?php
include 'db.php';
$errors = [];
$success = "";

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (empty($username)) $errors[] = "Username is required.";

    // Email validation using regex
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$/i", $email)) {
        $errors[] = "Invalid email format.";
    }

    // Phone validation (Bangladeshi format)
    if (!preg_match('/^01[3-9][0-9]{8}$/', $phone)) {
        $errors[] = "Invalid phone number.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO users (username, email, phone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $phone);
        if ($stmt->execute()) {
            $success = "User added successfully.";
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch users
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
</head>
<body>

<h2>Add New User</h2>
<form method="POST" novalidate>
    <label>Username:</label><br>
    <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"><br><br>

    <label>Email:</label><br>
    <input type="text" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"><br><br>

    <button type="submit">Submit</button>
</form>

<?php if (!empty($errors)): ?>
    <div style="color: red;">
        <strong>Errors:</strong><br>
        <?php foreach ($errors as $error): ?>
            - <?= htmlspecialchars($error) ?><br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div style="color: green;">
        <strong><?= $success ?></strong>
    </div>
<?php endif; ?>

<h2>User List</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
