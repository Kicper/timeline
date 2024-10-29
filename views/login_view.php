<?php
session_start();

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/UserController.php';

$database = new Database();
$db = $database->getConnection();

$loginMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userController = new UserController($db);
    if ($userController->login($username, $password)) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit();
    } else {
        $loginMessage = 'Login failed. Please check your credentials.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            position: relative;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            text-align: center;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            max-width: 300px;
            width: 100%;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            padding: 10px 20px;
            font-size: 1em;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .login-message {
            color: red;
            font-size: 1em;
            margin-bottom: 20px;
        }

        .return-button {
            font-size: 1em;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .return-button:hover {
            background-color: #0056b3;
        }

        .top-right-corner {
            position: absolute;
            top: 10px;
            right: 20px;
        }
    </style>
</head>
<body>
    <div class="top-right-corner">
        <a href="index.php"><button class="return-button">Return to the Timeline</button></a>
    </div>

    <div class="container">
        <h1>Login</h1>

        <?php if (!empty($loginMessage)): ?>
            <p class="login-message"><?= htmlspecialchars($loginMessage); ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php?action=login">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Log In</button>
        </form>
    </div>
</body>
</html>