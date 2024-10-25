<?php
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
</head>
<body>
    <h1>Login</h1>

    <?php if (!empty($loginMessage)): ?>
        <p style="color: red;"><?= htmlspecialchars($loginMessage); ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?action=login">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Log In</button>
    </form>

    <div>
        <a href="index.php"><button>Return to the Timeline</button></a>
    </div>
</body>
</html>