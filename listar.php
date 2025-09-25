<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Lista de usuários</title>
    <style>
        /* Variáveis de Estilo - Copiadas do CSS original para consistência */
        :root {
            --primary-color: #1a1541;
            --secondary-color: #755f8b;
            --text-color-dark: #232224;
            --text-color-medium: #765992;
            --text-color-light: #9e90c4;
            --background-color-start: #f1eaf7;
            --background-color-end: #7d57e7;

            --shadow-subtle: 0 4px 12px rgba(163, 146, 146, 0.1);
            --shadow-strong: 0 15px 35px rgba(0, 0, 0, 0.2);

            --spacing-small: 8px;
            --spacing-medium: 15px;
            --spacing-large: 30px;
            --border-radius-large: 20px;
            --border-radius-medium: 12px;
        }

        /* Estilo do Corpo (Mantendo o fundo gradiente) */
        body {
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Altera para alinhar ao topo, já que a lista pode ser longa */
            min-height: 100vh;
            background: linear-gradient(45deg, var(--background-color-start), var(--background-color-end));
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 40px 20px;
            box-sizing: border-box;
            color: var(--text-color-dark);
        }

        /* Contêiner da Lista (Com o estilo "vidro fosco" do formulário) */
        .list-container {
            background: rgba(255, 255, 255, 0.15); /* fundo translúcido um pouco mais forte */
            backdrop-filter: blur(12px); /* Desfoque sutil */
            -webkit-backdrop-filter: blur(12px); 
            
            padding: var(--spacing-large);
            border-radius: var(--border-radius-large);
            box-shadow: var(--shadow-strong);

            border: 1px solid rgba(255, 255, 255, 0.4); /* borda branca semi-transparente */

            width: 100%;
            max-width: 800px; /* Mais largo para a tabela */
            text-align: center;
            animation: fadeIn 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        /* Título */
        h2 {
            margin-top: 0;
            margin-bottom: var(--spacing-medium);
            color: var(--primary-color);
            font-weight: 600;
            font-size: clamp(26px, 5vw, 32px);
        }

        /* Parágrafos e Links (Para 'Cadastrar novo' e 'Ninguém cadastrado') */
        p {
            margin-top: 10px;
            margin-bottom: var(--spacing-medium);
            font-size: 16px;
            color: var(--text-color-medium);
        }

        a {
            color: var(--secondary-color);
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease-in-out;
        }

        a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        /* Tabela de Usuários */
        table {
            width: 100%;
            border-collapse: collapse; /* Remove as bordas duplas */
            margin-top: var(--spacing-medium);
            background-color: rgba(255, 255, 255, 0.75); /* Fundo sutil para a tabela */
            border-radius: var(--border-radius-medium);
            overflow: hidden; /* Para garantir que as bordas arredondadas funcionem */
            box-shadow: var(--shadow-subtle);
            text-align: left;
        }

        /* Cabeçalho da Tabela */
        th {
            background-color: var(--primary-color);
            color: #fff;
            padding: 14px var(--spacing-medium);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
        }
        
        /* Células da Tabela */
        td {
            padding: 12px var(--spacing-medium);
            border-bottom: 1px solid #e0e0e0;
            font-size: 15px;
            color: var(--text-color-dark);
            vertical-align: middle;
        }
        
        /* Linhas Ímpares (Striping) */
        tr:nth-child(even) {
            background-color: rgba(245, 245, 245, 0.8);
        }

        /* Efeito Hover nas Linhas */
        tr:hover {
            background-color: rgba(220, 220, 220, 0.8);
            transition: background-color 0.3s ease;
        }

        /* Estilo para a coluna de Ações */
        td:last-child {
            white-space: nowrap; /* Impede que os links quebrem a linha */
        }
        
        /* Animação */
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
    <div class="list-container">
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
        <h2>Usuários cadastrados</h2>
        <p><a href="form.html">Cadastrar novo</a></p>

        <?php if (empty($usuarios)): ?>
            <p>Ninguém cadastrado ainda.</p>
        <?php else: ?>
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
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
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>