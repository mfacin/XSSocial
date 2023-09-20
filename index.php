<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: /login.php");
}

echo $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="/logoff.php">Logoff</a>
</body>
</html>