<?php
require_once "config/conexao.php";
if (!isset($_SESSION["usuario_tipo"]) || ($_SESSION["usuario_tipo"] !== "ADM_PRINCIPAL" && $_SESSION["usuario_tipo"] !== "ADM")) { header("Location: login.php"); exit; }
$mensagem = ""; $tipo_mensagem = "";

if (isset($_GET["excluir_doacao"])) {
    $pdo->prepare("DELETE FROM doacoes WHERE id = ?")->execute([$_GET["excluir_doacao"]]);
    $mensagem = "Doação excluída!"; $tipo_mensagem = "sucesso";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["cadastrar_doacao_novo"])) {
        $nome = trim($_POST["nome_doador"]); $sobrenome = trim($_POST["sobrenome_doador"]);
        $usuario_auto = strtolower(preg_replace("/[^a-zA-Z0-9]/", "", $nome)) . rand(10, 99);
        $senha_auto = "doar" . rand(1000, 9999); $senha_hash = password_hash($senha_auto, PASSWORD_DEFAULT);
        try {
            $pdo->beginTransaction();
            $pdo->prepare("INSERT INTO usuarios (usuario, senha, nome, sobrenome, tipo) VALUES (?, ?, ?, ?, 'DOADOR')")->execute([$usuario_auto, $senha_hash, $nome, $sobrenome]);
            $uid = $pdo->lastInsertId();
            $pdo->prepare("INSERT INTO doadores (usuario_id, email, cpf, senha_plana_temp) VALUES (?, ?, ?, ?)")->execute([$uid, trim($_POST["email_doador"]), trim($_POST["cpf_doador"]), $senha_auto]);
            $did = $pdo->lastInsertId();
            $pdo->prepare("INSERT INTO doacoes (doador_id, instituicao_id, alimento, quantidade, unidade, data_doacao) VALUES (?, ?, ?, ?, ?, ?)")->execute([$did, $_POST["instituicao_id"], trim($_POST["alimento"]), $_POST["quantidade"], $_POST["unidade"], $_POST["data_doacao"]]);
            $pdo->commit();
            $mensagem = "Salvo! 👤 Login: $usuario_auto | 🔑 Senha: $senha_auto"; $tipo_mensagem = "sucesso";
        } catch (Exception $e) { $pdo->rollBack(); $mensagem = "Erro: " . $e->getMessage(); $tipo_mensagem = "erro"; }
    } elseif (isset($_POST["cadastrar_doacao_existente"])) {
        try {
            $pdo->prepare("INSERT INTO doacoes (doador_id, instituicao_id, alimento, quantidade, unidade, data_doacao) VALUES (?, ?, ?, ?, ?, ?)")->execute([$_POST["doador_id"], $_POST["instituicao_id"], trim($_POST["alimento"]), $_POST["quantidade"], $_POST["unidade"], $_POST["data_doacao"]]);
            $mensagem = "Doação vinculada!"; $tipo_mensagem = "sucesso";
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
            <h1>Painel Administrativo</h1>
            <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
                <a href="usuarios.php" class="btn-outline">🔑 Usuários</a>
                <a href="index.php" class="btn-outline">Mural Público</a>
                <a href="logout.php" class="btn-delete">Sair</a>
            </div>
        </div>
    </header>
    <main class="container">
        <?php if ($mensagem): ?><div class="alert <?= $tipo_mensagem ?>"><?= $mensagem ?></div><?php endif; ?>
        <div class="grid-forms">
            <section class="card" style="border-top: 4px solid var(--accent-blue);">
                <h2>🔄 Lançar Doação (Existente)</h2>
                <form method="POST">
                    <input type="hidden" name="cadastrar_doacao_existente" value="1">
                    <div class="form-group"><label>Doador</label><select name="doador_id" required><option value="">Selecione...</option><?php foreach ($doadores as $d): ?><option value="<?= $d["id"] ?>"><?= $d["nome"]." ".$d["sobrenome"] ?> | CPF: <?= $d["cpf"] ?: "-" ?> (<?= $d["usuario"] ?>)</option><?php endforeach; ?></select></div>
                    <div class="form-row"><div class="form-group flex-2"><label>Alimento</label><input type="text" name="alimento" required></div><div class="form-group flex-1"><label>Qtd</label><input type="number" step="0.1" name="quantidade" required></div><div class="form-group flex-1"><label>Unid</label><select name="unidade"><option value="kg">kg</option><option value="litros">L</option><option value="unidades">un</option></select></div></div>
                    <div class="form-row"><div class="form-group flex-2"><label>Instituição</label><select name="instituicao_id" required><?php foreach ($instituicoes as $i): ?><option value="<?= $i["id"] ?>"><?= $i["nome"] ?></option><?php endforeach; ?></select></div><div class="form-group flex-1"><label>Data</label><input type="date" name="data_doacao" value="<?= date("Y-m-d") ?>" required></div></div>
                    <button type="submit" class="btn">Vincular Doação</button>
                </form>
            </section>
            <section class="card" style="border-top: 4px solid var(--accent-green);">
                <h2>👤 Lançar Doação (NOVO)</h2>
                <form method="POST">
                    <input type="hidden" name="cadastrar_doacao_novo" value="1">
                    <div class="form-row"><div class="form-group flex-1"><label>Nome</label><input type="text" name="nome_doador" required></div><div class="form-group flex-1"><label>Sobrenome</label><input type="text" name="sobrenome_doador" required></div></div>
                    <div class="form-row"><div class="form-group flex-1"><label>CPF</label><input type="text" name="cpf_doador"></div><div class="form-group flex-1"><label>E-mail</label><input type="email" name="email_doador"></div></div>
                    <div class="form-row"><div class="form-group flex-2"><label>Alimento</label><input type="text" name="alimento" required></div><div class="form-group flex-1"><label>Qtd</label><input type="number" step="0.1" name="quantidade" required></div><div class="form-group flex-1"><label>Unid</label><select name="unidade"><option value="kg">kg</option><option value="litros">L</option><option value="unidades">un</option></select></div></div>
                    <div class="form-row"><div class="form-group flex-2"><label>Instituição</label><select name="instituicao_id" required><?php foreach ($instituicoes as $i): ?><option value="<?= $i["id"] ?>"><?= $i["nome"] ?></option><?php endforeach; ?></select></div><div class="form-group flex-1"><label>Data</label><input type="date" name="data_doacao" value="<?= date("Y-m-d") ?>" required></div></div>
                    <button type="submit" class="btn btn-success">Cadastrar e Lançar</button>
                </form>
            </section>
        </div>
        <section class="card">
            <h2>📦 Registro de Doações</h2>
            <div class="table-responsive">
                <table>
                    <thead><tr><th>Data</th><th>Doador</th><th>Alimento</th><th>Qtd</th><th>Instituição</th><th>Ações</th></tr></thead>
                    <tbody>
                        <?php foreach ($doacoes as $d): ?>
                            <tr><td><?= date("d/m/Y", strtotime($d["data_doacao"])) ?></td><td><strong><?= $d["d_nome"] . " " . $d["d_sob"] ?></strong></td><td><?= $d["alimento"] ?></td><td><span class="code-badge"><?= $d["quantidade"] ?> <?= $d["unidade"] ?></span></td><td><?= $d["i_nome"] ?></td><td><a href="editar_doacao.php?id=<?= $d["id"] ?>" class="btn-outline">Editar</a> <a href="painel_adm.php?excluir_doacao=<?= $d["id"] ?>" class="btn-delete" onclick="return confirm('Excluir?')">Excluir</a></td></tr>
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