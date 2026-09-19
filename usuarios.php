<?php
require_once "config/conexao.php";
if (!isset($_SESSION["usuario_tipo"]) || ($_SESSION["usuario_tipo"] !== "ADM_PRINCIPAL" && $_SESSION["usuario_tipo"] !== "ADM")) { header("Location: login.php"); exit; }
if (isset($_GET["excluir_usuario"])) { $pdo->prepare("DELETE FROM usuarios WHERE id = ? AND tipo != 'ADM_PRINCIPAL'")->execute([$_GET["excluir_usuario"]]); header("Location: usuarios.php"); exit; }
$usuarios_sistema = $pdo->query("SELECT u.id, u.usuario, u.nome, u.sobrenome, u.tipo, d.cpf, d.senha_plana_temp FROM usuarios u LEFT JOIN doadores d ON d.usuario_id = u.id ORDER BY u.id DESC")->fetchAll();
?>
<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><title>Usuários e Senhas</title><link rel="stylesheet" href="css/style.css"></head>
<body>
    <header class="header"><div class="header-content"><h1>🔑 Gestão de Usuários</h1><a href="painel_adm.php" class="btn-outline">Voltar ao Painel</a></div></header>
    <main class="container">
        <section class="card">
            <h2>Lista de Acessos e CPFs</h2>
            <div class="table-responsive">
                <table>
                    <thead><tr><th>Nome</th><th>Tipo</th><th>Login</th><th>CPF</th><th>Senha Temp.</th><th>Ações</th></tr></thead>
                    <tbody>
                        <?php foreach ($usuarios_sistema as $u): ?>
                            <tr><td><strong><?= $u["nome"]." ".$u["sobrenome"] ?></strong></td><td><?= $u["tipo"] ?></td><td><code class="code-badge"><?= $u["usuario"] ?></code></td><td><?= $u["cpf"] ?: "-" ?></td><td><?= $u["senha_plana_temp"] ? "<code style='color:var(--accent-green);'>".$u["senha_plana_temp"]."</code>" : "Protegida" ?></td><td><a href="editar_usuario.php?id=<?= $u["id"] ?>" class="btn-outline">Editar</a> <?php if($u["tipo"] !== "ADM_PRINCIPAL"): ?><a href="usuarios.php?excluir_usuario=<?= $u["id"] ?>" class="btn-delete" onclick="return confirm('Excluir este usuário?')">Excluir</a><?php endif; ?></td></tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <footer class="footer-autoria">
        Código de autoria de Pedro Coutinho RU:3593047 UNINTER - CURSO ANALISE E DESENVOLVIMENTO DE SISTEMAS - POLO POUSO ALEGRE MG.
    </footer>
</body>
</html>