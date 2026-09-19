<?php
require_once "config/conexao.php";
$stmt = $pdo->query("SELECT alimento, SUM(quantidade) AS total, unidade, COUNT(*) AS qtd_doacoes FROM doacoes GROUP BY alimento, unidade ORDER BY total DESC");
$alimentos = $stmt->fetchAll();
$labels = []; $totais = [];
foreach($alimentos as $a) { $labels[] = $a["alimento"] . " (" . $a["unidade"] . ")"; $totais[] = (float)$a["total"]; }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Mural Público - Transparência</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <h1>Mural Público <small style="font-size:0.8rem; color:var(--accent-green);">vFinal</small></h1>
            <a href="login.php" class="btn-outline">Acesso Restrito / Login</a>
        </div>
    </header>
    <main class="container">
        <section class="card">
            <h2>📊 Distribuição de Alimentos Arrecadados</h2>
            <div style="max-height: 300px; position: relative; margin-top: 1rem;"><canvas id="chartDoacoes"></canvas></div>
        </section>
        <section class="card">
            <h2>📋 Resumo de Arrecadação por Alimento</h2>
            <div class="table-responsive">
                <table>
                    <thead><tr><th>Alimento</th><th>Doações Realizadas</th><th>Total Arrecadado</th></tr></thead>
                    <tbody>
                        <?php if (count($alimentos) > 0): foreach ($alimentos as $row): ?>
                            <tr><td><strong><?= htmlspecialchars($row["alimento"]) ?></strong></td><td><?= $row["qtd_doacoes"] ?> doação(ões)</td><td><span class="code-badge"><?= number_format($row["total"], 1, ",", ".") ?> <?= $row["unidade"] ?></span></td></tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="3" style="text-align:center;">Nenhuma doação registrada até o momento.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <script>
        new Chart(document.getElementById("chartDoacoes").getContext("2d"), {
            type: "bar",
            data: { labels: <?= json_encode($labels) ?>, datasets: [{ label: "Total Arrecadado", data: <?= json_encode($totais) ?>, backgroundColor: "rgba(56, 189, 248, 0.7)", borderColor: "#38bdf8", borderWidth: 1, borderRadius: 6 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: "rgba(255,255,255,0.05)" }, ticks: { color: "#94a3b8" } }, x: { grid: { color: "rgba(255,255,255,0.05)" }, ticks: { color: "#94a3b8" } } } }
        });
    </script>
    <footer class="footer-autoria">
        Código de autoria de Pedro Coutinho RU:3593047 UNINTER - CURSO ANALISE E DESENVOLVIMENTO DE SISTEMAS - POLO POUSO ALEGRE MG.
    </footer>
</body>
</html>