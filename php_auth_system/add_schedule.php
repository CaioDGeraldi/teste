<?php require 'config.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$erro = "";
$sucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $programa = trim($_POST["programa"]);
    $inicio = $_POST["inicio"];
    $fim = $_POST["fim"];

    if (empty($programa) || empty($inicio) || empty($fim)) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif ($inicio >= $fim) {
        $erro = "Horário de início deve ser menor que o de fim.";
    } else {
        // Verificar conflito de horário
        $stmt = $pdo->prepare("SELECT * FROM programacoes WHERE (inicio < ? AND fim > ?)");
        $stmt->execute([$fim, $inicio]);
        if ($stmt->rowCount() > 0) {
            $erro = "Já existe uma programação nesse intervalo.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO programacoes (usuario_id, programa, inicio, fim) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_SESSION["usuario_id"], $programa, $inicio, $fim]);
            $sucesso = "Programação registrada com sucesso!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nova Programação</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <h2>Nova Programação</h2>
    <?php if ($erro): ?><p class="erro"><?= $erro ?></p><?php endif; ?>
    <?php if ($sucesso): ?><p class="sucesso"><?= $sucesso ?></p><?php endif; ?>
    <form method="POST">
        <input type="text" name="programa" placeholder="Nome do Programa">
        <input type="datetime-local" name="inicio">
        <input type="datetime-local" name="fim">
        <button type="submit">Salvar Programação</button>
    </form>
    <a href="dashboard.php">Voltar ao Dashboard</a>
</div>
</body>
</html>