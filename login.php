<?php require 'config.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario["senha"])) {
        $_SESSION["usuario_id"] = $usuario["id"];
        $_SESSION["usuario_nome"] = $usuario["nome"];
        header("Location: dashboard.php");
        exit;
    } else {
        $erro = "E-mail ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if ($erro): ?><p class="erro"><?= $erro ?></p><?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="E-mail">
            <input type="password" name="senha" placeholder="Senha">
            <button type="submit">Entrar</button>
        </form>
        <a href="register.php">Criar nova conta</a>
    </div>
</body>
</html>