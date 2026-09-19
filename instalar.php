<?php
// ==========================================
// INSTALADOR DEFINITIVO - VERSÃO FINAL 2.0
// ==========================================

$dir = __DIR__;

// 1. Criar estrutura de pastas
if (!file_exists($dir . '/config')) mkdir($dir . '/config', 0777, true);
if (!file_exists($dir . '/css')) mkdir($dir . '/css', 0777, true);

// 2. Função para salvar arquivos via Nowdoc (Seguro contra erros de aspas)
function salvar($caminho, $conteudo) {
    global $dir;
    file_put_contents($dir . '/' . $caminho, trim($conteudo));
}

// ==========================================
// ARQUIVO: config/conexao.php
// ==========================================
salvar('config/conexao.php', <<<'PHP'
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$host = "localhost";
$db   = "gestao_doacoes";
$user = "root";
$pass = ""; 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
PHP
);

// ==========================================
// ARQUIVO: css/style.css
// ==========================================
salvar('css/style.css', <<<'CSS'
:root {
    --bg-main: #0b0f19;
    --bg-card: rgba(23, 32, 54, 0.7);
    --border-card: rgba(255, 255, 255, 0.08);
    --accent-blue: #38bdf8;
    --accent-purple: #818cf8;
    --accent-green: #34d399;
    --accent-red: #f87171;
    --text-primary: #f8fafc;
    --text-muted: #94a3b8;
}
* { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; }
body { background: var(--bg-main); color: var(--text-primary); min-height: 100vh; background-image: radial-gradient(at 0% 0%, rgba(56, 189, 248, 0.12) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(129, 140, 248, 0.12) 0px, transparent 50%); background-attachment: fixed; padding-bottom: 2rem; }
.header { background: rgba(11, 15, 25, 0.8); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border-card); padding: 1.2rem 2rem; position: sticky; top: 0; z-index: 100; }
.header-content { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; }
.header h1 { font-size: 1.5rem; background: linear-gradient(90deg, var(--accent-blue), var(--accent-purple)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: 800; }
.container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
.card { background: var(--bg-card); backdrop-filter: blur(16px); border: 1px solid var(--border-card); border-radius: 16px; padding: 1.8rem; margin-bottom: 2rem; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37); }
.card h2 { font-size: 1.25rem; margin-bottom: 1.2rem; color: var(--accent-blue); display: flex; align-items: center; gap: 0.5rem; }
.grid-forms { display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
.form-row { display: flex; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap; }
.form-group { display: flex; flex-direction: column; gap: 0.4rem; margin-bottom: 1rem; flex: 1; }
.flex-1 { flex: 1; min-width: 140px; }
.flex-2 { flex: 2; min-width: 220px; }
label { font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
input, select { background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border-card); border-radius: 8px; padding: 0.75rem 1rem; color: #fff; font-size: 0.95rem; outline: none; transition: 0.2s; width: 100%; }
input:focus, select:focus { border-color: var(--accent-blue); box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2); }
.btn { background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple)); color: #fff; border: none; padding: 0.8rem 1.5rem; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.2s; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; width: 100%; }
.btn:hover { opacity: 0.9; transform: translateY(-1px); }
.btn-success { background: linear-gradient(135deg, #10b981, #059669); }
.btn-outline { background: transparent; border: 1px solid var(--border-card); color: var(--text-primary); padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-size: 0.9rem; text-align: center; }
.btn-outline:hover { background: rgba(255, 255, 255, 0.05); }
.btn-delete { background: rgba(248, 113, 113, 0.15); color: var(--accent-red); border: 1px solid rgba(248, 113, 113, 0.3); padding: 0.35rem 0.7rem; border-radius: 6px; text-decoration: none; font-size: 0.8rem; font-weight: bold; }
.btn-delete:hover { background: var(--accent-red); color: #fff; }
.table-responsive { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; text-align: left; margin-top: 1rem; }
th { background: rgba(15, 23, 42, 0.8); padding: 1rem; font-size: 0.85rem; color: var(--text-muted); text-transform: uppercase; border-bottom: 1px solid var(--border-card); }
td { padding: 1rem; border-bottom: 1px solid var(--border-card); font-size: 0.95rem; }
tr:hover td { background: rgba(255, 255, 255, 0.02); }
.alert { padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; font-weight: 600; text-align: center; }
.alert.sucesso { background: rgba(52, 211, 153, 0.15); border: 1px solid var(--accent-green); color: var(--accent-green); }
.alert.erro { background: rgba(248, 113, 113, 0.15); border: 1px solid var(--accent-red); color: var(--accent-red); }
.code-badge { background: rgba(56, 189, 248, 0.15); color: var(--accent-blue); padding: 0.3rem 0.6rem; border-radius: 6px; font-family: monospace; font-weight: bold; }
.center-body { display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 1rem; }
.login-card { width: 100%; max-width: 420px; }
.divider { border: 0; height: 1px; background: var(--border-card); margin: 1.5rem 0; }
CSS
);

// ==========================================
// ARQUIVO: login.php
// ==========================================
salvar('login.php', <<<'PHP'
<?php
require_once "config/conexao.php";
$erro = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST["usuario"]);
    $senha = $_POST["senha"];
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch();
    if ($user && password_verify($senha, $user["senha"])) {
        $_SESSION["usuario_id"] = $user["id"];
        $_SESSION["usuario_tipo"] = $user["tipo"];
        if ($user["tipo"] === "DOADOR") {
            header("Location: painel_doador.php");
        } else {
            header("Location: painel_adm.php");
        }
        exit;
    } else {
        $erro = "Usuário ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Login - PousoAlegre Solidária</title><link rel="stylesheet" href="css/style.css"></head>
<body class="center-body">
    <div class="card login-card">
        <h2 style="justify-content:center;">PousoAlegre Solidária <small style="font-size:0.8rem; color:var(--accent-blue);">vFinal 2.0</small></h2>
        <?php if($erro): ?><div class="alert erro"><?= $erro ?></div><?php endif; ?>
        <form method="POST" action="login.php">
            <div class="form-group"><label>Usuário</label><input type="text" name="usuario" required placeholder="Digite seu usuário"></div>
            <div class="form-group"><label>Senha</label><input type="password" name="senha" required placeholder="Digite sua senha"></div>
            <button type="submit" class="btn">Entrar no Sistema</button>
        </form>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 15px; text-align: center; line-height: 1.4;">
            Esqueceu sua senha? Entre em contato com o administrador do sistema para solicitar a redefinição.
        </p>
        <div style="text-align:center; margin-top:1.5rem;">
            <a href="index.php" class="btn-outline" style="display:inline-block; width:100%;">&larr; Voltar à Visualização Pública</a>
        </div>
    </div>
</body>
</html>
PHP
);

// ==========================================
// ARQUIVO: index.php (Mural Público)
// ==========================================
salvar('index.php', <<<'PHP'
<?php
require_once "config/conexao.php";
$stmt = $pdo->query("SELECT alimento, SUM(quantidade) AS total, unidade, COUNT(*) AS qtd_doacoes FROM doacoes GROUP BY alimento, unidade ORDER BY total DESC");
$alimentos = $stmt->fetchAll();
$labels = []; $totais = [];
foreach($alimentos as $a) {
    $labels[] = $a["alimento"] . " (" . $a["unidade"] . ")";
    $totais[] = (float)$a["total"];
}
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
            <h1>Mural Público <small style="font-size:0.8rem; color:var(--accent-green);">v2.0</small></h1>
            <a href="login.php" class="btn-outline">Acesso Restrito / Login</a>
        </div>
    </header>
    <main class="container">
        <section class="card">
            <h2>📊 Distribuição de Alimentos Arrecadados</h2>
            <div style="max-height: 300px; position: relative; margin-top: 1rem;">
                <canvas id="chartDoacoes"></canvas>
            </div>
        </section>
        <section class="card">
            <h2>📋 Resumo de Arrecadação por Alimento</h2>
            <div class="table-responsive">
                <table>
                    <thead><tr><th>Alimento</th><th>Doações Realizadas</th><th>Total Arrecadado</th></tr></thead>
                    <tbody>
                        <?php if (count($alimentos) > 0): ?>
                            <?php foreach ($alimentos as $row): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($row["alimento"]) ?></strong></td>
                                <td><?= $row["qtd_doacoes"] ?> doação(ões)</td>
                                <td><span class="code-badge"><?= number_format($row["total"], 1, ",", ".") ?> <?= $row["unidade"] ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3" style="text-align:center;">Nenhuma doação registrada até o momento.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <script>
        const ctx = document.getElementById("chartDoacoes").getContext("2d");
        new Chart(ctx, {
            type: "bar",
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: "Total Arrecadado",
                    data: <?= json_encode($totais) ?>,
                    backgroundColor: "rgba(56, 189, 248, 0.7)",
                    borderColor: "#38bdf8",
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { beginAtZero: true, grid: { color: "rgba(255,255,255,0.05)" }, ticks: { color: "#94a3b8" } },
                    x: { grid: { color: "rgba(255,255,255,0.05)" }, ticks: { color: "#94a3b8" } }
                }
            }
        });
    </script>
</body>
</html>
PHP
);

// ==========================================
// ARQUIVO: painel_adm.php
// ==========================================
salvar('painel_adm.php', <<<'PHP'
<?php
require_once "config/conexao.php";
if (!isset($_SESSION["usuario_tipo"]) || ($_SESSION["usuario_tipo"] !== "ADM_PRINCIPAL" && $_SESSION["usuario_tipo"] !== "ADM")) { header("Location: login.php"); exit; }
$mensagem = ""; $tipo_mensagem = "";

if (isset($_GET["excluir_doacao"])) {
    $stmt = $pdo->prepare("DELETE FROM doacoes WHERE id = ?");
    $stmt->execute([$_GET["excluir_doacao"]]);
    $mensagem = "Doação excluída com sucesso!"; $tipo_mensagem = "sucesso";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["cadastrar_doacao_novo"])) {
        $nome = trim($_POST["nome_doador"]); $sobrenome = trim($_POST["sobrenome_doador"]);
        $cpf = trim($_POST["cpf_doador"]); $email = trim($_POST["email_doador"]);
        $usuario_auto = strtolower(preg_replace("/[^a-zA-Z0-9]/", "", $nome)) . rand(10, 99);
        $senha_auto = "doar" . rand(1000, 9999); $senha_hash = password_hash($senha_auto, PASSWORD_DEFAULT);

        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, senha, nome, sobrenome, tipo) VALUES (?, ?, ?, ?, 'DOADOR')");
            $stmt->execute([$usuario_auto, $senha_hash, $nome, $sobrenome]);
            $usuario_id = $pdo->lastInsertId();

            $stmt2 = $pdo->prepare("INSERT INTO doadores (usuario_id, email, cpf, senha_plana_temp) VALUES (?, ?, ?, ?)");
            $stmt2->execute([$usuario_id, $email, $cpf, $senha_auto]);
            $doador_id = $pdo->lastInsertId();

            $stmt3 = $pdo->prepare("INSERT INTO doacoes (doador_id, instituicao_id, alimento, quantidade, unidade, data_doacao) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt3->execute([$doador_id, $_POST["instituicao_id"], trim($_POST["alimento"]), $_POST["quantidade"], $_POST["unidade"], $_POST["data_doacao"]]);
            $pdo->commit();
            $mensagem = "Doador e Doação salvos! 👤 Login: $usuario_auto | 🔑 Senha: $senha_auto"; $tipo_mensagem = "sucesso";
        } catch (Exception $e) { $pdo->rollBack(); $mensagem = "Erro: " . $e->getMessage(); $tipo_mensagem = "erro"; }
    }
    elseif (isset($_POST["cadastrar_doacao_existente"])) {
        try {
            $stmt = $pdo->prepare("INSERT INTO doacoes (doador_id, instituicao_id, alimento, quantidade, unidade, data_doacao) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$_POST["doador_id"], $_POST["instituicao_id"], trim($_POST["alimento"]), $_POST["quantidade"], $_POST["unidade"], $_POST["data_doacao"]]);
            $mensagem = "Nova doação vinculada ao doador com sucesso!"; $tipo_mensagem = "sucesso";
        } catch (Exception $e) { $mensagem = "Erro: " . $e->getMessage(); $tipo_mensagem = "erro"; }
    }
}

$instituicoes = $pdo->query("SELECT * FROM instituicoes ORDER BY nome ASC")->fetchAll();
$doadores = $pdo->query("SELECT d.id, u.nome, u.sobrenome, d.cpf, u.usuario FROM doadores d JOIN usuarios u ON d.usuario_id = u.id ORDER BY u.nome ASC")->fetchAll();
$doacoes = $pdo->query("SELECT d.id, d.alimento, d.quantidade, d.unidade, d.data_doacao, u.nome AS d_nome, u.sobrenome AS d_sob, inst.nome AS i_nome FROM doacoes d JOIN doadores do ON d.doador_id = do.id JOIN usuarios u ON do.usuario_id = u.id JOIN instituicoes inst ON d.instituicao_id = inst.id ORDER BY d.data_doacao DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Painel Gestor</title><link rel="stylesheet" href="css/style.css"></head>
<body>
    <header class="header">
        <div class="header-content">
            <h1>Painel Administrativo <small style="font-size:0.8rem; color:var(--accent-green);">v2.0</small></h1>
            <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
                <a href="usuarios.php" class="btn-outline">🔑 Usuários e Senhas</a>
                <a href="index.php" class="btn-outline">Mural Público</a>
                <a href="logout.php" class="btn-delete">Sair</a>
            </div>
        </div>
    </header>
    <main class="container">
        <?php if ($mensagem): ?><div class="alert <?= $tipo_mensagem ?>"><?= $mensagem ?></div><?php endif; ?>
        <div class="grid-forms">
            <section class="card" style="border-top: 4px solid var(--accent-blue);">
                <h2>🔄 Lançar Doação (Doador Existente)</h2>
                <form method="POST">
                    <input type="hidden" name="cadastrar_doacao_existente" value="1">
                    <div class="form-group">
                        <label>Buscar Doador (Nome, CPF ou Login)</label>
                        <select name="doador_id" required>
                            <option value="">Selecione um doador cadastrado...</option>
                            <?php foreach ($doadores as $d): ?>
                                <option value="<?= $d["id"] ?>"><?= $d["nome"]." ".$d["sobrenome"] ?> | CPF: <?= $d["cpf"] ?: "Não informado" ?> (<?= $d["usuario"] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group flex-2"><label>Alimento</label><input type="text" name="alimento" required></div>
                        <div class="form-group flex-1"><label>Qtd</label><input type="number" step="0.1" name="quantidade" required></div>
                        <div class="form-group flex-1"><label>Unid</label><select name="unidade"><option value="kg">kg</option><option value="litros">L</option><option value="unidades">un</option></select></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group flex-2"><label>Instituição</label><select name="instituicao_id" required><?php foreach ($instituicoes as $i): ?><option value="<?= $i["id"] ?>"><?= $i["nome"] ?></option><?php endforeach; ?></select></div>
                        <div class="form-group flex-1"><label>Data</label><input type="date" name="data_doacao" value="<?= date("Y-m-d") ?>" required></div>
                    </div>
                    <button type="submit" class="btn">Vincular Doação</button>
                </form>
            </section>
            <section class="card" style="border-top: 4px solid var(--accent-green);">
                <h2>👤 Lançar Doação (NOVO Doador)</h2>
                <form method="POST">
                    <input type="hidden" name="cadastrar_doacao_novo" value="1">
                    <div class="form-row">
                        <div class="form-group flex-1"><label>Nome</label><input type="text" name="nome_doador" required></div>
                        <div class="form-group flex-1"><label>Sobrenome</label><input type="text" name="sobrenome_doador" required></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group flex-1"><label>CPF</label><input type="text" name="cpf_doador" placeholder="Apenas números"></div>
                        <div class="form-group flex-1"><label>E-mail</label><input type="email" name="email_doador"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group flex-2"><label>Alimento</label><input type="text" name="alimento" required></div>
                        <div class="form-group flex-1"><label>Qtd</label><input type="number" step="0.1" name="quantidade" required></div>
                        <div class="form-group flex-1"><label>Unid</label><select name="unidade"><option value="kg">kg</option><option value="litros">L</option><option value="unidades">un</option></select></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group flex-2"><label>Instituição</label><select name="instituicao_id" required><?php foreach ($instituicoes as $i): ?><option value="<?= $i["id"] ?>"><?= $i["nome"] ?></option><?php endforeach; ?></select></div>
                        <div class="form-group flex-1"><label>Data</label><input type="date" name="data_doacao" value="<?= date("Y-m-d") ?>" required></div>
                    </div>
                    <button type="submit" class="btn btn-success">Cadastrar e Lançar</button>
                </form>
            </section>
        </div>
        <section class="card">
            <h2>📦 Registro Geral de Doações</h2>
            <div class="table-responsive">
                <table>
                    <thead><tr><th>Data</th><th>Doador</th><th>Alimento</th><th>Quantidade</th><th>Instituição</th><th>Ações</th></tr></thead>
                    <tbody>
                        <?php foreach ($doacoes as $d): ?>
                            <tr>
                                <td><?= date("d/m/Y", strtotime($d["data_doacao"])) ?></td>
                                <td><strong><?= $d["d_nome"] . " " . $d["d_sob"] ?></strong></td>
                                <td><?= $d["alimento"] ?></td>
                                <td><span class="code-badge"><?= $d["quantidade"] ?> <?= $d["unidade"] ?></span></td>
                                <td><?= $d["i_nome"] ?></td>
                                <td>
                                    <a href="editar_doacao.php?id=<?= $d["id"] ?>" class="btn-outline">Editar</a>
                                    <a href="painel_adm.php?excluir_doacao=<?= $d["id"] ?>" class="btn-delete" onclick="return confirm('Excluir este lançamento?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body></html>
PHP
);

// ==========================================
// ARQUIVO: editar_doacao.php
// ==========================================
salvar('editar_doacao.php', <<<'PHP'
<?php
require_once "config/conexao.php";
if (!isset($_SESSION["usuario_tipo"]) || ($_SESSION["usuario_tipo"] !== "ADM_PRINCIPAL" && $_SESSION["usuario_tipo"] !== "ADM")) { header("Location: login.php"); exit; }
$id = $_GET["id"] ?? null; if (!$id) { header("Location: painel_adm.php"); exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("UPDATE doacoes SET alimento = ?, quantidade = ?, unidade = ?, instituicao_id = ?, data_doacao = ? WHERE id = ?");
    $stmt->execute([trim($_POST["alimento"]), $_POST["quantidade"], $_POST["unidade"], $_POST["instituicao_id"], $_POST["data_doacao"], $id]);
    header("Location: painel_adm.php"); exit;
}
$doacao = $pdo->prepare("SELECT * FROM doacoes WHERE id = ?"); $doacao->execute([$id]); $d = $doacao->fetch();
$instituicoes = $pdo->query("SELECT * FROM instituicoes")->fetchAll();
?>
<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><title>Editar Doação</title><link rel="stylesheet" href="css/style.css"></head>
<body class="center-body"><div class="card login-card" style="max-width: 500px;">
    <h2>✏ Editar Doação</h2>
    <form method="POST">
        <div class="form-group"><label>Alimento</label><input type="text" name="alimento" value="<?= $d["alimento"] ?>" required></div>
        <div class="form-row">
            <div class="form-group flex-1"><label>Qtd</label><input type="number" step="0.1" name="quantidade" value="<?= $d["quantidade"] ?>" required></div>
            <div class="form-group flex-1"><label>Unidade</label><select name="unidade">
                <option value="kg" <?= $d["unidade"]=="kg"?"selected":"" ?>>kg</option>
                <option value="litros" <?= $d["unidade"]=="litros"?"selected":"" ?>>L</option>
                <option value="unidades" <?= $d["unidade"]=="unidades"?"selected":"" ?>>un</option>
            </select></div>
        </div>
        <div class="form-group"><label>Instituição</label><select name="instituicao_id">
            <?php foreach($instituicoes as $i): ?><option value="<?= $i["id"] ?>" <?= $d["instituicao_id"]==$i["id"]?"selected":"" ?>><?= $i["nome"] ?></option><?php endforeach; ?>
        </select></div>
        <div class="form-group"><label>Data</label><input type="date" name="data_doacao" value="<?= $d["data_doacao"] ?>" required></div>
        <button type="submit" class="btn">Salvar Alterações</button>
        <a href="painel_adm.php" class="btn-outline" style="margin-top:1rem; display:block;">Cancelar</a>
    </form>
</div></body></html>
PHP
);

// ==========================================
// ARQUIVO: usuarios.php
// ==========================================
salvar('usuarios.php', <<<'PHP'
<?php
require_once "config/conexao.php";
if (!isset($_SESSION["usuario_tipo"]) || ($_SESSION["usuario_tipo"] !== "ADM_PRINCIPAL" && $_SESSION["usuario_tipo"] !== "ADM")) { header("Location: login.php"); exit; }

if (isset($_GET["excluir_usuario"])) {
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ? AND tipo != 'ADM_PRINCIPAL'");
    $stmt->execute([$_GET["excluir_usuario"]]);
    header("Location: usuarios.php"); exit;
}
$usuarios_sistema = $pdo->query("SELECT u.id, u.usuario, u.nome, u.sobrenome, u.tipo, d.cpf, d.senha_plana_temp FROM usuarios u LEFT JOIN doadores d ON d.usuario_id = u.id ORDER BY u.id DESC")->fetchAll();
?>
<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><title>Usuários e Senhas</title><link rel="stylesheet" href="css/style.css"></head>
<body>
    <header class="header">
        <div class="header-content">
            <h1>🔑 Gestão de Usuários</h1>
            <a href="painel_adm.php" class="btn-outline">Voltar ao Painel</a>
        </div>
    </header>
    <main class="container">
        <section class="card">
            <h2>Lista de Acessos e CPFs</h2>
            <div class="table-responsive">
                <table>
                    <thead><tr><th>Nome</th><th>Tipo</th><th>Login</th><th>CPF</th><th>Senha Temp.</th><th>Ações</th></tr></thead>
                    <tbody>
                        <?php foreach ($usuarios_sistema as $u): ?>
                            <tr>
                                <td><strong><?= $u["nome"] . " " . $u["sobrenome"] ?></strong></td>
                                <td><?= $u["tipo"] ?></td>
                                <td><code class="code-badge"><?= $u["usuario"] ?></code></td>
                                <td><?= $u["cpf"] ?: "-" ?></td>
                                <td><?= $u["senha_plana_temp"] ? "<code style='color:var(--accent-green);'>".$u["senha_plana_temp"]."</code>" : "Protegida" ?></td>
                                <td>
                                    <a href="editar_usuario.php?id=<?= $u["id"] ?>" class="btn-outline">Editar</a>
                                    <?php if($u["tipo"] !== "ADM_PRINCIPAL"): ?>
                                        <a href="usuarios.php?excluir_usuario=<?= $u["id"] ?>" class="btn-delete" onclick="return confirm('Excluir este usuário?')">Excluir</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body></html>
PHP
);

// ==========================================
// ARQUIVO: editar_usuario.php
// ==========================================
salvar('editar_usuario.php', <<<'PHP'
<?php
require_once "config/conexao.php";
if (!isset($_SESSION["usuario_tipo"]) || ($_SESSION["usuario_tipo"] !== "ADM_PRINCIPAL" && $_SESSION["usuario_tipo"] !== "ADM")) { header("Location: login.php"); exit; }
$id = $_GET["id"] ?? null; if (!$id) { header("Location: usuarios.php"); exit; }
$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nova_senha = $_POST["nova_senha"] ?? "";
    try {
        $pdo->beginTransaction();
        $pdo->prepare("UPDATE usuarios SET nome = ?, sobrenome = ?, usuario = ? WHERE id = ?")->execute([trim($_POST["nome"]), trim($_POST["sobrenome"]), trim($_POST["usuario"]), $id]);
        if (isset($_POST["cpf"])) {
            $pdo->prepare("UPDATE doadores SET cpf = ? WHERE usuario_id = ?")->execute([trim($_POST["cpf"]), $id]);
        }
        if (!empty($nova_senha)) {
            if ($nova_senha === $_POST["confirma_senha"]) {
                $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?")->execute([$senha_hash, $id]);
                $pdo->prepare("UPDATE doadores SET senha_plana_temp = ? WHERE usuario_id = ?")->execute([$nova_senha, $id]);
            } else {
                throw new Exception("As senhas não coincidem!");
            }
        }
        $pdo->commit();
        header("Location: usuarios.php"); exit;
    } catch (Exception $e) { $pdo->rollBack(); $erro = $e->getMessage(); }
}
$u = $pdo->prepare("SELECT u.*, d.cpf FROM usuarios u LEFT JOIN doadores d ON d.usuario_id = u.id WHERE u.id = ?"); $u->execute([$id]); $user = $u->fetch();
?>
<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><title>Editar Usuário</title><link rel="stylesheet" href="css/style.css"></head>
<body class="center-body"><div class="card login-card" style="max-width: 500px;">
    <h2>✏ Editar Usuário</h2>
    <?php if($erro): ?><div class="alert erro"><?= $erro ?></div><?php endif; ?>
    <form method="POST">
        <div class="form-row">
            <div class="form-group flex-1"><label>Nome</label><input type="text" name="nome" value="<?= $user["nome"] ?>" required></div>
            <div class="form-group flex-1"><label>Sobrenome</label><input type="text" name="sobrenome" value="<?= $user["sobrenome"] ?>" required></div>
        </div>
        <div class="form-group"><label>Login (Usuário)</label><input type="text" name="usuario" value="<?= $user["usuario"] ?>" required></div>
        <?php if($user["tipo"] === "DOADOR"): ?>
            <div class="form-group"><label>CPF</label><input type="text" name="cpf" value="<?= $user["cpf"] ?>"></div>
        <?php endif; ?>
        <hr class="divider">
        <div class="form-group"><label>Nova Senha <small>(Deixe em branco p/ manter)</small></label><input type="password" name="nova_senha"></div>
        <div class="form-group"><label>Confirmar Nova Senha</label><input type="password" name="confirma_senha"></div>
        <button type="submit" class="btn">Salvar Alterações</button>
        <a href="usuarios.php" class="btn-outline" style="margin-top:1rem; display:block;">Cancelar</a>
    </form>
</div></body></html>
PHP
);

// ==========================================
// ARQUIVO: painel_doador.php
// ==========================================
salvar('painel_doador.php', <<<'PHP'
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
    <header class="header">
        <div class="header-content">
            <h1>Minha Área de Doador</h1>
            <div style="display:flex; gap:0.5rem;">
                <a href="index.php" class="btn-outline">Mural Público</a>
                <a href="logout.php" class="btn-delete">Sair</a>
            </div>
        </div>
    </header>
    <main class="container">
        <div class="grid-forms">
            <div class="card" style="text-align:center;">
                <h3 style="color:var(--text-muted); font-size:0.9rem;">MINHAS DOAÇÕES</h3>
                <p style="font-size: 2.5rem; color:var(--accent-blue); font-weight:bold;"><?= count($minhas_doacoes) ?></p>
            </div>
            <div class="card" style="text-align:center;">
                <h3 style="color:var(--text-muted); font-size:0.9rem;">TOTAL DA COMUNIDADE (KG)</h3>
                <p style="font-size: 2.5rem; color:var(--accent-green); font-weight:bold;"><?= number_format($total_comunidade, 1, ',', '.') ?></p>
            </div>
        </div>
        <section class="card">
            <h2>Meu Fluxo de Doações</h2>
            <div class="table-responsive">
                <table>
                    <thead><tr><th>Data</th><th>Alimento</th><th>Quantidade</th><th>Instituição Destino</th></tr></thead>
                    <tbody>
                        <?php foreach ($minhas_doacoes as $d): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($d['data_doacao'])) ?></td>
                                <td><strong><?= $d['alimento'] ?></strong></td>
                                <td><span class="code-badge"><?= $d['quantidade'] ?> <?= $d['unidade'] ?></span></td>
                                <td><?= $d['inst_nome'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body></html>
PHP
);

// ==========================================
// ARQUIVO: logout.php
// ==========================================
salvar('logout.php', <<<'PHP'
<?php
session_start();
session_destroy();
header("Location: index.php");
exit;
?>
PHP
);

// ==========================================
// BANCO DE DADOS (Criação e Inserção Inicial)
// ==========================================
try {
    $pdo = new PDO("mysql:host=localhost", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $sql_db = <<<SQL
    CREATE DATABASE IF NOT EXISTS gestao_doacoes DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    USE gestao_doacoes;

    DROP TABLE IF EXISTS doacoes;
    DROP TABLE IF EXISTS doadores;
    DROP TABLE IF EXISTS instituicoes;
    DROP TABLE IF EXISTS usuarios;

    CREATE TABLE usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario VARCHAR(50) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        nome VARCHAR(50) NOT NULL,
        sobrenome VARCHAR(50) NOT NULL,
        responsabilidade VARCHAR(100) DEFAULT 'Usuário do Sistema',
        tipo ENUM('ADM_PRINCIPAL', 'ADM', 'DOADOR') NOT NULL,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE instituicoes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        bairro VARCHAR(100) NOT NULL,
        responsavel VARCHAR(100) NOT NULL,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE doadores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        email VARCHAR(100) NULL,
        telefone VARCHAR(20) NULL,
        cpf VARCHAR(14) NULL UNIQUE,
        tipo_doador ENUM('Física', 'Jurídica') DEFAULT 'Física',
        senha_plana_temp VARCHAR(50),
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
    );

    CREATE TABLE doacoes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        doador_id INT NOT NULL,
        instituicao_id INT NOT NULL,
        alimento VARCHAR(100) NOT NULL,
        quantidade DECIMAL(10,2) NOT NULL,
        unidade VARCHAR(10) NOT NULL,
        data_doacao DATE NOT NULL,
        FOREIGN KEY (doador_id) REFERENCES doadores(id) ON DELETE CASCADE,
        FOREIGN KEY (instituicao_id) REFERENCES instituicoes(id) ON DELETE CASCADE
    );
SQL;
    $pdo->exec($sql_db);
    
    // Inserir Admin e Instituições Iniciais
    $senha_adm = password_hash('adm1', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT IGNORE INTO usuarios (usuario, senha, nome, sobrenome, responsabilidade, tipo) VALUES ('pedro01', ?, 'Pedro Henrique', 'Coutinho Silva', 'Administrador Principal', 'ADM_PRINCIPAL')");
    $stmt->execute([$senha_adm]);

    $pdo->exec("INSERT IGNORE INTO instituicoes (nome, bairro, responsavel) VALUES 
        ('Asilo São Vicente de Paulo', 'Centro', 'Maria Silva'),
        ('Sopa dos Pobres', 'São João', 'João Santos'),
        ('Comunidade Acolhedora', 'Fátima', 'Ana Oliveira')");

    $status_db = "<p style='color: #34d399;'>✔ Banco de dados recriado e populado com sucesso!</p>";
} catch (Exception $e) {
    $status_db = "<p style='color: #f87171;'>✖ Erro no Banco: " . $e->getMessage() . "</p>";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Instalação Final 2.0</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="center-body">
    <div class="card login-card" style="text-align: center;">
        <h2 style="justify-content: center; color: var(--accent-blue);">🚀 Sistema Final Instalado!</h2>
        <p style="color: var(--text-muted); margin: 1rem 0;">A pasta foi reorganizada, o banco de dados foi recriado com colunas corretas e todas as funcionalidades estão 100% integradas.</p>
        <?= $status_db ?>
        <hr class="divider">
        <p style="font-size: 0.9rem; text-align:left; color:var(--text-primary);">
            <strong>Credenciais do Administrador:</strong><br>
            Usuário: <code style="color:var(--accent-green);">pedro01</code><br>
            Senha: <code style="color:var(--accent-green);">adm1</code>
        </p>
        <div style="display:flex; gap:10px; margin-top:1.5rem;">
            <a href="index.php" class="btn-outline" style="flex:1;">Mural Público</a>
            <a href="login.php" class="btn" style="flex:1;">Acessar Painel</a>
        </div>
    </div>
</body>
</html>