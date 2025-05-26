<?php require 'config.php';

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    if (empty($nome) || empty($email) || empty($_POST["senha"])) {
        $erro = "Todos os campos são obrigatórios.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $erro = "E-mail já registrado.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $email, $senha]);
            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Registro</h2>
        <?php if ($erro): ?><p class="erro"><?= $erro ?></p><?php endif; ?>
        <form method="POST">
            <input type="text" name="nome" placeholder="Nome completo">
            <input type="email" name="email" placeholder="E-mail">
            <input type="password" name="senha" placeholder="Senha">
            <button type="submit">Registrar</button>
        </form>
        <a href="login.php">Já tem conta? Entrar</a>
    </div>
</body>
</html>