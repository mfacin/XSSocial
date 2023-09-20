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
$senha_confirma = trim($_POST['senha_confirma']);

if ($username === "" || $senha === "" || $senha_confirma === "") {
    echo "<script>alert(\"Os campos não podem estar vazios\");</script>";
    goto end;
}

if ($senha !== $senha_confirma) {
    echo "<script>alert(\"As senhas não condizem\");</script>";
    goto end;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("localhost", "root", "", "xss_server"); 

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} 

$senha = sha1($senha);

$mysqli->query("INSERT INTO usuarios (username, senha) VALUES (\"{$username}\", \"{$senha}\");");

$id = $mysqli->insert_id;

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
    <title>Cadastrar - XSSocial</title>

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
        <form action="/cadastro.php" id="cadastro" method="post">
            <div class="form-input">
                <label for="username">Nome de usuário:</label>
                <input type="text" id="username" name="username" size="20">
            </div>
            <div class="form-input">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" size="20">
            </div>
            <div class="form-input">
                <label for="senha_confirma">Confirme a Senha:</label>
                <input type="password" id="senha_confirma" name="senha_confirma" size="20">
            </div>
            <button type="Submit">Cadastrar</button>
            <div id="cadastrar">
                <a href="/login.php">Login</a>
            </div>
        </form>
    </main>

    <script>
        let form = document.getElementById("cadastro");
        let username = document.getElementById("username");
        let senha = document.getElementById("senha");
        let senha_confirma = document.getElementById("senha_confirma");

        form.addEventListener("submit", e => {
            e.preventDefault();

            if (username.value.trim() === "" || senha.value.trim() === "" || senha_confirma.value.trim() === "") {
                alert("Os campos não podem estar vazios");
                return;
            }

            if (senha.value !== senha_confirma.value) {
                alert("As senhas não condizem");
                return;
            }

            form.submit()
        })
    </script>

    <footer></footer>
    
</body>
</html>