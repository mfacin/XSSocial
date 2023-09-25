<?php
session_start();

// usuário logado, redirecionando para a home
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
    echo "<script>alert(\"Erro no banco de dados\");</script>";
    goto end;
} 

$senha = sha1($senha);

$result = $mysqli->query("SELECT id FROM usuarios WHERE username = \"{$username}\" AND senha = \"{$senha}\";");

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
    <link rel="stylesheet" href="/styles/geral.css">
    <link rel="stylesheet" href="/styles/form.css">
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
    <nav>
        <div class="content">
            <h1>XSSocial</h1>
        </div>
    </nav>

    <main>
        <div class="content">
            <div class="container">
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
                    <a href="/cadastro.php" class="botao">Cadastrar</a>
                </form>
            </div>
        </div>
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