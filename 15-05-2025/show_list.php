<?php
include 'db_config.php';
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List</title>
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .add_btn {
            display: inline-block;
            margin-bottom: 20px;
            margin-top: 20px;
            padding: 10px;
            background-color: #000;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            margin: 0 auto;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #000;
            color: white;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .actions a {
            margin-right: 8px;
            font-weight: 500;
            color: #007bff;
            text-decoration: none;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .actions a:last-child {
            color: #dc3545;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Users' List</h2>
   

    <table>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th></tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= $row["username"] ?></td>
            <td><?= $row["email"] ?></td>
            <td><?= $row["phone"] ?></td>
            <td class="actions">
                <a href="edit_user.php?id=<?= $row['id'] ?>">Edit</a>
                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php } ?>


    </table>
     <a href="add_user.php" class="add_btn">Add New User</a>
</div>

</body>
</html>
