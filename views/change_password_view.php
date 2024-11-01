<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
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

        input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"],
        .return-button {
            padding: 10px 20px;
            font-size: 1em;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover,
        .return-button:hover {
            background-color: #0056b3;
        }

        .top-right-corner {
            position: absolute;
            top: 10px;
            right: 20px;
        }

        .message {
            color: red;
            font-size: 1em;
            margin-bottom: 20px;
        }

        .success {
            color: green;
        }
    </style>
</head>

<body>
    <div class="top-right-corner">
        <a href="index.php"><button class="return-button">Return to the Timeline</button></a>
    </div>

    <div class="container">
        <h1>Change Password</h1>

        <?php if (!empty($errorMessage)): ?>
            <p class="message"><?= htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php?action=changePassword">
            <input type="password" name="current_password" placeholder="Current Password" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
            <button type="submit">Update Password</button>
        </form>
    </div>
</body>

</html>