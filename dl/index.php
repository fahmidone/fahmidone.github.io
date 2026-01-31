<?php
session_start();

// --- PASSWORD ---
$PASSWORD = "FAHMIDHERE";
// ---------------------

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Check if user is logged in
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Handle Login Attempt
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['password']) && $_POST['password'] === $PASSWORD) {
        $_SESSION['logged_in'] = true;
        $is_logged_in = true;
    } else {
        $error = "Invalid password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storage@Fahmid</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f4f7f9; color: #333; display: flex; justify-content: center; padding-top: 50px; }
        .container { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); width: 100%; max-width: 500px; }
        h2 { margin-top: 0; color: #222; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; }
        input[type="password"] { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        button { background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold; width: 100%; }
        button:hover { background: #0056b3; }
        ul { list-style: none; padding: 0; margin: 20px 0; }
        li { padding: 12px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; }
        li a { text-decoration: none; color: #007bff; word-break: break-all; }
        .logout { font-size: 0.8rem; color: #888; text-decoration: none; float: right; }
        .error { color: #d9534f; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="container">
    <?php if (!$is_logged_in): ?>
        <h2>Private Storage</h2>
        <form method="POST">
            <input type="password" name="password" placeholder="Enter Password" autofocus>
            <button type="submit">Unlock Files</button>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        </form>
    <?php else: ?>
        <a href="?logout=1" class="logout">Logout</a>
        <h2>My Files</h2>
        <ul>
            <?php
            $files = scandir(".");
            $count = 0;
            foreach ($files as $file) {
                // Exclude hidden files, the script itself, and any error logs
                if ($file !== "." && $file !== ".." && $file !== "index.php" && $file !== "error_log") {
                    echo "<li><a href='$file' target='_blank'>$file</a></li>";
                    $count++;
                }
            }
            if ($count === 0) echo "<li>No files found.</li>";
            ?>
        </ul>
    <?php endif; ?>
</div>

</body>
</html>
