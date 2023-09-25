<?php
session_start();

// usuário não logado, redirecionando para o login
if (!isset($_SESSION['id'])) {
    header("Location: /login.php");
}

$id_usuario = $_SESSION['id'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("localhost", "root", "", "xss_server"); 

if ($mysqli->connect_error) {
    echo "<script>alert(\"Erro no banco de dados\");</script>";
    goto end;
}

/* 
 * PROFILE
 */

$result = $mysqli->query("SELECT username, foto, criado FROM usuarios WHERE id = {$id_usuario};");

if ($result->num_rows <= 0) {
    echo "<script>alert(\"Erro ao buscar dados do usuário\");</script>";
    goto end;
}

$row = $result->fetch_row();

$username = $row[0];
$foto = "/imgs/" . $row[1];
$criado = new DateTime($row[2]);

/*
 * POSTS
 */

$posts = array();
$result = $mysqli->query("SELECT posts.id, usuarios.username, usuarios.foto, posts.conteudo, posts.criado FROM posts 
                          INNER JOIN usuarios ON usuarios.id = posts.usuario
                          WHERE posts.usuario = {$id_usuario}
                          ORDER BY posts.criado DESC;");

while ($row = $result->fetch_row()) {
    $post = array(
        "id"        => $row[0],
        "username"  => $row[1],
        "foto"      => $row[2],
        "conteudo"  => explode("\n", $row[3]),
        "criado"    => new DateTime($row[4])
    );
    array_push($posts, $post);
}

unset($result);

$mysqli->close();

end:
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/geral.css">
    <link rel="stylesheet" href="/styles/perfil.css">
    <link rel="stylesheet" href="/styles/form.css">
    <link rel="stylesheet" href="/styles/posts.css">
    <title>Perfil - XSSocial</title>
</head>
<body>
    <nav>
        <div class="content">
            <div class="content_container">
                <h1>XSSocial</h1>
                <span class="divisor"></span>
                <a href="/posts.php">Todos os posts</a>
            </div>
            <div class="content_container">
                <?php echo "<a href=\"/\">{$username}</a>"; ?>
                <span class="divisor"></span>
                <a href="/logoff.php">Logoff</a>
            </div>
        </div>
    </nav>
    
    <main>
        <div class="content">
            <div class="container">
                <div class="perfil">
                    <div class="imagem">
                        <?php echo "<img src=\"{$foto}\" alt=\"{$username}\">"; ?>
                    </div>
        
                    <div class="username">
                        <?php echo "<h1>{$username}</h1>"; ?>
                        <?php echo "<span>Membro desde {$criado->format("d/m/Y")}</span>"; ?>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="titulo">
                    <h1>Seus Posts</h1>
                    <hr>
                </div>

                <div class="posts">
                    <?php
                    foreach ($posts as $post) {
                    echo "<div class=\"post\">
                        <div class=\"post-imagem\">
                            <img src=\"/imgs/{$post["foto"]}\" alt=\"{$post["username"]}\">
                        </div>
                        <div class=\"post-conteudo\">
                            <div class=\"post-usuario\">
                                <span class=\"post-username\">{$post["username"]}</span>
                                <span class=\"divisor\"></span>
                                <span class=\"post-criado\">{$post["criado"]->format("d/m/Y")}</span>
                            </div>
                            <div class=\"post-texto\">";
                    foreach($post["conteudo"] as $p) {
                        echo "<p class=\"post-paragrafo\">{$p}</p>";
                    }
                    echo "</div>
                        </div>
                    </div>";
                    }
                    ?>
                </div>
            </div>

            <div class="container">
                <div class="titulo">
                    <h1>Alterar senha</h1>
                    <hr>
                </div>
                
                <form action="/muda_senha.php">
                    <div class="form-input">
                        <label for="senha_atual">Senha Atual:</label>
                        <input type="password" id="senha_atual" name="senha_atual" size="20">
                    </div>
                    <div class="form-input">
                        <label for="nova_senha">Nova Senha:</label>
                        <input type="password" id="nova_senha" name="nova_senha" size="20">
                    </div>
                    <div class="form-input">
                        <label for="nova_senha_confirma">Confirme a Nova Senha:</label>
                        <input type="password" id="nova_senha_confirma" name="nova_senha_confirma" size="20">
                    </div>

                    <button type="Submit">Alterar</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>