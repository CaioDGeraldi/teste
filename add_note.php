<?php require 'config.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = trim($_POST["titulo"]);
    $conteudo = trim($_POST["conteudo"]);

    if (empty($titulo) || empty($conteudo)) {
        $erro = "Título e conteúdo são obrigatórios.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO notas (usuario_id, titulo, conteudo) VALUES (?, ?, ?)");
        $stmt->execute([$_SESSION["usuario_id"], $titulo, $conteudo]);
        $sucesso = "Nota registrada com sucesso!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nova Nota</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <h2>Nova Nota</h2>
    <?php if ($erro): ?><p class="erro"><?= $erro ?></p><?php endif; ?>
    <?php if ($sucesso): ?><p class="sucesso"><?= $sucesso ?></p><?php endif; ?>
    <form method="POST">
        <input type="text" name="titulo" placeholder="Título da Nota">
        <textarea name="conteudo" placeholder="Conteúdo" rows="5" style="width: 80%; margin: 10px auto;"></textarea>
        <button type="submit">Salvar Nota</button>
    </form>
    <a href="dashboard.php">Voltar ao Dashboard</a>
</div>
</body>
</html>