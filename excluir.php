<?php
require "db.php";

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { die("ID inválido."); }

$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: listar.php");
    exit;
} else {
    echo "Erro ao excluir: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
