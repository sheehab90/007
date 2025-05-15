<?php
include 'db.php';

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>User List</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f7f9fc;
    padding: 20px;
  }
  h2 {
    color: #333;
    margin-bottom: 20px;
  }
  table {
    border-collapse: collapse;
    width: 100%;
    max-width: 800px;
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
  }
  th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }
  th {
    background-color: #4A90E2;
    color: white;
    font-weight: 600;
  }
  tr:hover {
    background-color: #f1faff;
  }
  a {
    text-decoration: none;
    color: #4A90E2;
    font-weight: 600;
    margin: 0 5px;
    transition: color 0.3s;
  }
  a:hover {
    color: #357ABD;
  }
  .action-links {
    white-space: nowrap;
  }
</style>
</head>
<body>
<div style="width: 600px;">
<table>
    <h2 style="text-align: center;">User List</h2>
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td class="action-links">
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> | 
                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>
</body>
</html>
