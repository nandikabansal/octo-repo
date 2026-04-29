<?php
session_start();

$getResult = '';
$postResult = '';
$loginResult = '';
$cookieResult = '';

function clean_value($value)
{
    return htmlspecialchars(trim($value ?? ''), ENT_QUOTES, 'UTF-8');
}

if (isset($_GET['submit_get'])) {
    $name = clean_value($_GET['name'] ?? '');
    $email = clean_value($_GET['email'] ?? '');
    $password = clean_value($_GET['password'] ?? '');

    if (!filter_var($_GET['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
        $getResult = 'Invalid email format.';
    } else {
        $getResult = 'GET: Name = ' . $name . ', Email = ' . $email . ', Password = ' . $password;
    }
}

if (isset($_POST['submit_post'])) {
    $name = clean_value($_POST['name'] ?? '');
    $email = clean_value($_POST['email'] ?? '');
    $password = clean_value($_POST['password'] ?? '');

    if (!filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
        $postResult = 'Invalid email format.';
    } else {
        $postResult = 'POST: Name = ' . $name . ', Email = ' . $email . ', Password = ' . $password;
        setcookie('username', $name, time() + 3600);
        $cookieResult = 'Cookie saved for username: ' . $name;
    }
}

if (isset($_POST['login'])) {
    $username = clean_value($_POST['username'] ?? '');
    $loginPassword = $_POST['login_password'] ?? '';

    if ($username === 'admin' && $loginPassword === '1234') {
        $_SESSION['username'] = $username;
        $loginResult = 'Login successful.';
    } else {
        $loginResult = 'Invalid login.';
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}
?>
<!doctype html>
<html>
<head>
    <title>PHP Form Example</title>
</head>
<body>
    <h2>GET Form</h2>
    <form method="get">
        Name: <input type="text" name="name"><br><br>
        Email: <input type="text" name="email"><br><br>
        Password: <input type="password" name="password"><br><br>
        <button type="submit" name="submit_get">Submit GET</button>
    </form>
    <p><?php echo $getResult; ?></p>

    <h2>POST Form</h2>
    <form method="post">
        Name: <input type="text" name="name"><br><br>
        Email: <input type="text" name="email"><br><br>
        Password: <input type="password" name="password"><br><br>
        <button type="submit" name="submit_post">Submit POST</button>
    </form>
    <p><?php echo $postResult; ?></p>
    <p><?php echo $cookieResult; ?></p>
    <p>Saved cookie username: <?php echo clean_value($_COOKIE['username'] ?? 'none'); ?></p>

    <h2>Session Login</h2>
    <?php if (isset($_SESSION['username'])): ?>
        <p>Welcome, <?php echo clean_value($_SESSION['username']); ?>!</p>
        <a href="?logout=1">Logout</a>
    <?php else: ?>
        <form method="post">
            Username: <input type="text" name="username"><br><br>
            Password: <input type="password" name="login_password"><br><br>
            <button type="submit" name="login">Login</button>
        </form>
        <p>Use admin / 1234</p>
    <?php endif; ?>
    <p><?php echo $loginResult; ?></p>
</body>
</html>
