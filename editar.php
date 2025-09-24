<?php
require "db.php";

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { die("ID inválido."); }

$sql = "SELECT id, nome, email FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$usuario = $res->fetch_assoc();

$stmt->close();
$conn->close();

if (!$usuario) { die("Usuário não encontrado."); }
?>
<!doctype html>
<html lang="pt-br">
<head><meta charset="utf-8"><title>Editar usuário</title></head>
<body>
<h2>Editar usuário #<?= (int)$usuario['id'] ?></h2>
<form method="post" action="salvar.php">
    <!-- Se existir este hidden id, o salvar.php fará UPDATE -->
    <input type="hidden" name="id" value="<?= (int)$usuario['id'] ?>">

    <label>Nome:</label><br>
    <input name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required><br><br>

    <label>E-mail:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required><br><br>

    <button type="submit">Salvar</button>
    <a href="listar.php">Cancelar</a>
</form>
</body>
</html>
