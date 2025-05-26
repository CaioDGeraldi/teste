<?php require 'config.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$notas = $pdo->query("SELECT * FROM notas ORDER BY id DESC")->fetchAll();
$programacoes = $pdo->query("SELECT * FROM programacoes ORDER BY inicio DESC")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="dashboard">
    <h1>Bem-vindo, <?= $_SESSION["usuario_nome"] ?>!</h1>
    <p><a href="add_note.php">Criar Nota</a> | <a href="add_schedule.php">Nova Programação</a> | <a class="logout" href="logout.php">Sair</a></p>

    <h3>Notas</h3>
<ul>
<?php foreach ($notas as $nota): ?>
    <li>
        <strong><?= htmlspecialchars($nota["titulo"]) ?></strong>: <?= htmlspecialchars($nota["conteudo"]) ?>
        <a href="delete_note.php?id=<?= $nota["id"] ?>"
           onclick="return confirm('Deseja realmente excluir esta nota?');"
           style="color: red; float: right;">Excluir</a>
    </li>
<?php endforeach; ?>
</ul>



    <h3>Programações</h3>
    <ul>
        <?php foreach ($programacoes as $prog): ?>
            <li><strong><?= htmlspecialchars($prog["programa"]) ?></strong>: <?= $prog["inicio"] ?> até <?= $prog["fim"] ?></li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>