<?php
require 'config.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    // Deleta apenas se o item for do usuário logado
    $stmt = $pdo->prepare("DELETE FROM notas WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$id, $_SESSION["usuario_id"]]);
}

header("Location: dashboard.php");
exit;
