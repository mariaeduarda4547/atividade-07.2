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
<head>
    <meta charset="utf-8">
    <title>Editar usuário</title>
    <style>
        /* Variáveis de Estilo - Mantendo a consistência */
        :root {
            --primary-color: #1a1541;
            --secondary-color: #755f8b;
            --text-color-dark: #232224;
            --text-color-medium: #765992;
            --text-color-light: #9e90c4;
            --background-color-start: #f1eaf7;
            --background-color-end: #7d57e7;

            --shadow-strong: 0 15px 35px rgba(0, 0, 0, 0.2);

            --spacing-small: 8px;
            --spacing-medium: 15px;
            --spacing-large: 30px;
            --border-radius-large: 20px;
            --border-radius-medium: 12px;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            /* Gradiente de fundo */
            background: linear-gradient(45deg, var(--background-color-start), var(--background-color-end));
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Contêiner do Formulário (Estilo Vidro Fosco) */
        .form-container {
            background: rgba(255, 255, 255, 0.1); /* fundo translúcido */
            backdrop-filter: blur(10px); /* desfoque no fundo */
            -webkit-backdrop-filter: blur(10px); /* suporte Safari */
            
            padding: 40px 35px;
            border-radius: var(--border-radius-large);
            box-shadow: var(--shadow-strong);

            border: 1px solid rgba(255, 255, 255, 0.4); /* borda semi-transparente */

            width: 100%;
            max-width: 420px;
            text-align: center;

            animation: fadeIn 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        }


        h2 {
            margin-bottom: var(--spacing-large);
            color: var(--primary-color); /* Usando primary-color para destaque */
            font-weight: 600;
            font-size: clamp(24px, 5vw, 28px);
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: var(--spacing-small);
            font-weight: 500;
            color: var(--text-color-medium);
        }

        input {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: var(--spacing-medium);
            border: 1px solid #ccc; /* Cor de borda neutra */
            border-radius: var(--border-radius-medium);
            font-size: 15px;
            transition: all 0.3s ease-in-out;
            box-sizing: border-box; /* Garante que padding não aumente o width */
        }

        input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 8px rgba(120, 90, 180, 0.4); /* Sombra roxa no foco */
            outline: none;
        }

        /* Estilo do Botão Salvar (Principal) */
        button[type="submit"] {
            width: 100%;
            padding: 14px 16px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: white; /* Cor branca para texto em fundos escuros */
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: var(--border-radius-medium);
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            margin-bottom: var(--spacing-medium);
        }

        button[type="submit"]:hover {
            /* Gradiente reverso no hover para um efeito visual interessante */
            background: linear-gradient(-90deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-3px) scale(1.02);
        }

        /* Estilo do Link Cancelar (Secundário) */
        .action-group {
            display: flex;
            gap: var(--spacing-medium);
            justify-content: space-between;
            align-items: center;
        }
        
        /* Ajuste do botão e link para ficarem lado a lado (opcional, mas recomendado) */
        .action-group button {
            flex: 2; /* Faz o botão ser maior */
            margin: 0;
        }

        .action-group a {
            flex: 1; /* Faz o link ocupar o restante do espaço */
            display: block;
            padding: 14px 16px;
            text-align: center;
            border-radius: var(--border-radius-medium);
            font-weight: 600;
            color: var(--secondary-color);
            border: 2px solid var(--secondary-color);
            transition: all 0.3s ease-in-out;
        }
        
        .action-group a:hover {
            background-color: var(--secondary-color);
            color: white;
            text-decoration: none;
            border-color: var(--secondary-color);
            transform: translateY(-1px);
        }


        /* Animação para a entrada do formulário */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    </head>
<body>
    <div class="form-container">
        <h2>Editar usuário #<?= (int)$usuario['id'] ?></h2>
        <form method="post" action="salvar.php">
            <input type="hidden" name="id" value="<?= (int)$usuario['id'] ?>">

            <label for="nome">Nome:</label>
            <input id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
            
            <div class="action-group">
                <button type="submit">Salvar Alterações</button>
                <a href="listar.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>