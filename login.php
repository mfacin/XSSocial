<?php
session_start();

if (isset($_SESSION['id'])) {
    header("Location: /");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    goto end;
}

$username = trim($_POST['username']);
$senha = trim($_POST['senha']);

if ($username === "" || $senha === "") {
    echo "<script>alert(\"Os campos não podem estar vazios\");</script>";
    goto end;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("localhost", "root", "", "xss_server"); 

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} 

$senha = sha1($senha);

$result = $mysqli->query("SELECT id, username, senha FROM usuarios WHERE username = \"{$username}\" AND senha = \"{$senha}\";");

if ($result->num_rows <= 0) {
    echo "<script>alert(\"Login ou senha incorretos\");</script>";
    goto end;
}

$row = mysqli_fetch_row($result);
$id = $row[0];

$mysqli->close();

$_SESSION['id'] = $id;
header("Location: /");

end:
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
    <title>Login - XSSocial</title>

    <style>
        #cadastrar {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>XSSocial</h1>
    </header>

    <main>
        <form action="/login.php" id="login" method="post">
            <div class="form-input">
                <label for="username">Nome de usuário:</label>
                <input type="text" id="username" name="username" size="20">
            </div>
            <div class="form-input">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" size="20">
            </div>
            <button type="Submit">Login</button>
            <div id="cadastrar">
                <a href="/cadastro.php">Cadastrar</a>
            </div>
        </form>
    </main>

    <script>
        let form = document.getElementById("login");
        let username = document.getElementById("username");
        let senha = document.getElementById("senha");

        form.addEventListener("submit", e => {
            e.preventDefault();

            if (username.value.trim() === "" || senha.value.trim() === "") {
                alert("Os campos não podem estar vazios");
                return;
            }

            form.submit()
        })
    </script>

    <footer></footer>
    
</body>
</html>