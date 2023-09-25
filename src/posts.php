<?php
session_start();

// usuário não logado, redirecionando para o login
if (!isset($_SESSION['id'])) {
    header("Location: /login.php");
}

$id_usuario = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    goto get;
}

$conteudo = trim($_POST['conteudo']);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("localhost", "root", "", "xss_server"); 

if ($mysqli->connect_error) {
    echo "<script>alert(\"Erro no banco de dados\");</script>";
    goto end;
}

$mysqli->query("INSERT INTO posts (usuario, conteudo) VALUES (\"{$id_usuario}\",\"{$conteudo}\");");

$mysqli->close();

get:

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("localhost", "root", "", "xss_server"); 

if ($mysqli->connect_error) {
    echo "<script>alert(\"Erro no banco de dados\");</script>";
    goto end;
}

/* 
 * PROFILE
 */

$result = $mysqli->query("SELECT username FROM usuarios WHERE id = {$id_usuario};");

if ($result->num_rows <= 0) {
    echo "<script>alert(\"Erro ao buscar dados do usuário\");</script>";
    goto end;
}

$row = $result->fetch_row();

$username = $row[0];

/*
 * POSTS
 */

$posts = array();
$result = $mysqli->query("SELECT posts.id, usuarios.username, usuarios.foto, posts.conteudo, posts.criado FROM posts 
                          INNER JOIN usuarios ON usuarios.id = posts.usuario
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
                <div class="titulo">
                    <h1>Escreva um Novo Post</h1>
                    <hr>
                </div>

                <form action="/posts.php" method="post">
                    <div class="form-input">
                        <textarea name="conteudo" id="conteudo" size="500"></textarea>
                    </div>
                    <button type="Submit">Postar</button>
                </form>
            </div>

            <div class="container">
                <div class="titulo">
                    <h1>Posts da Sua Rede</h1>
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
        </div>
    </main>
</body>
</html>