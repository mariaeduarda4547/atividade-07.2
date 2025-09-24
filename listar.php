<?php
require "db.php";

$sql = "SELECT id, nome, email FROM usuarios ORDER BY id DESC";
$result = $conn->query($sql);

$usuarios = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
    $result->free();
}

$conn->close();
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Lista de usuários</title>
</head>
<body>
    <h2>Usuários cadastrados</h2>
    <p><a href="form.html">Cadastrar novo</a></p>

    <?php if (empty($usuarios)): ?>
        <p>Ninguém cadastrado ainda.</p>
    <?php else: ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= (int)$u['id'] ?></td>
                <td><?= htmlspecialchars($u['nome']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                    <a href="editar.php?id=<?= (int)$u['id'] ?>">Editar</a> |
                    <a href="excluir.php?id=<?= (int)$u['id'] ?>"
                       onclick="return confirm('Tem certeza que deseja excluir este usuário?');">
                       Excluir
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
