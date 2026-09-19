<?php
require_once "config/conexao.php";
if (!isset($_SESSION["usuario_tipo"]) || $_SESSION["usuario_tipo"] !== "DOADOR") { header("Location: login.php"); exit; }
$usuario_id = $_SESSION["usuario_id"];
$stmt = $pdo->prepare("SELECT d.alimento, d.quantidade, d.unidade, d.data_doacao, inst.nome AS inst_nome FROM doacoes d JOIN doadores do ON d.doador_id = do.id JOIN instituicoes inst ON d.instituicao_id = inst.id WHERE do.usuario_id = ? ORDER BY d.data_doacao DESC");
$stmt->execute([$usuario_id]); $minhas_doacoes = $stmt->fetchAll();
$total_comunidade = $pdo->query("SELECT SUM(quantidade) AS total FROM doacoes WHERE unidade = 'kg'")->fetch()['total'] ?? 0;
?>
<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><title>Área do Doador</title><link rel="stylesheet" href="css/style.css"></head>
<body>
    <header class="header"><div class="header-content"><h1>Minha Área de Doador</h1><div style="display:flex; gap:0.5rem;"><a href="index.php" class="btn-outline">Mural Público</a><a href="logout.php" class="btn-delete">Sair</a></div></div></header>
    <main class="container">
        <div class="grid-forms">
            <div class="card" style="text-align:center;"><h3 style="color:var(--text-muted); font-size:0.9rem;">MINHAS DOAÇÕES</h3><p style="font-size: 2.5rem; color:var(--accent-blue); font-weight:bold;"><?= count($minhas_doacoes) ?></p></div>
            <div class="card" style="text-align:center;"><h3 style="color:var(--text-muted); font-size:0.9rem;">TOTAL DA COMUNIDADE (KG)</h3><p style="font-size: 2.5rem; color:var(--accent-green); font-weight:bold;"><?= number_format($total_comunidade, 1, ',', '.') ?></p></div>
        </div>
        <section class="card">
            <h2>Meu Fluxo de Doações</h2>
            <div class="table-responsive">
                <table>
                    <thead><tr><th>Data</th><th>Alimento</th><th>Quantidade</th><th>Instituição Destino</th></tr></thead>
                    <tbody>
                        <?php foreach ($minhas_doacoes as $d): ?>
                            <tr><td><?= date('d/m/Y', strtotime($d['data_doacao'])) ?></td><td><strong><?= $d['alimento'] ?></strong></td><td><span class="code-badge"><?= $d['quantidade'] ?> <?= $d['unidade'] ?></span></td><td><?= $d['inst_nome'] ?></td></tr>
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