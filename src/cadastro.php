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
$senha_confirma = trim($_POST['senha_confirma']);
$foto_usuario = $_FILES['foto'];

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
    echo "<script>alert(\"Erro no banco de dados\");</script>";
    goto end;
}

$temp = explode(".", $foto_usuario["name"]);
$nome_arquivo = sha1($foto_usuario['name']) . '.' . end($temp);
$caminho_foto = "/imgs/" . $nome_arquivo;

if (!move_uploaded_file($foto_usuario['tmp_name'], $caminho_foto)) {
    echo "<script>alert(\"Erro no upload da foto\");</script>";
    goto end;
}

$senha = sha1($senha);

$mysqli->query("INSERT INTO usuarios (username, senha, foto) VALUES (\"{$username}\", \"{$senha}\", \"{$nome_arquivo}\");");

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
    <link rel="stylesheet" href="/styles/geral.css">
    <link rel="stylesheet" href="/styles/form.css">
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
    <nav>
        <div class="content">
            <h1>XSSocial</h1>
        </div>
    </nav>

    <main>
        <div class="content">
            <div class="container">
                <form enctype="multipart/form-data" action="/cadastro.php" id="cadastro" method="post">
                    <div class="form-input">
                        <label for="foto">Foto de usuário:</label>
                        <input type="file" id="foto" name="foto">
                    </div>
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
                    <a href="/login.php" class="botao">Login</a>
                </form>
            </div>
        </div>
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