<?php
require "db.php";

$id    = (int)($_POST["id"] ?? 0);      // se vier >0, é edição
$nome  = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");

// validações simples
if ($nome === "" || $email === "") {
    die("Preencha nome e e-mail.");
}

if ($id > 0) {
    // UPDATE
    $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) { die("Erro ao preparar: " . mysqli_error($conn)); }

    mysqli_stmt_bind_param($stmt, "ssi", $nome, $email, $id);
    $ok = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    if ($ok) {
        header("Location: listar.php");  // PRG: evita re-envio do form
        exit;
    } else {
        die("Erro ao atualizar: " . mysqli_error($conn));
    }

} else {
    // INSERT
    $sql = "INSERT INTO usuarios (nome, email) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) { die("Erro ao preparar: " . mysqli_error($conn)); }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $email);
    $ok = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    if ($ok) {
        header("Location: listar.php");  // após inserir, vai para a lista
        exit;
    } else {
        die("Erro ao inserir: " . mysqli_error($conn));
    }
}
?>
