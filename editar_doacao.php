<?php
require_once "config/conexao.php";
if (!isset($_SESSION["usuario_tipo"]) || ($_SESSION["usuario_tipo"] !== "ADM_PRINCIPAL" && $_SESSION["usuario_tipo"] !== "ADM")) { header("Location: login.php"); exit; }
$id = $_GET["id"] ?? null; if (!$id) { header("Location: painel_adm.php"); exit; }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo->prepare("UPDATE doacoes SET alimento = ?, quantidade = ?, unidade = ?, instituicao_id = ?, data_doacao = ? WHERE id = ?")->execute([trim($_POST["alimento"]), $_POST["quantidade"], $_POST["unidade"], $_POST["instituicao_id"], $_POST["data_doacao"], $id]);
    header("Location: painel_adm.php"); exit;
}
$d = $pdo->prepare("SELECT * FROM doacoes WHERE id = ?"); $d->execute([$id]); $d = $d->fetch();
$instituicoes = $pdo->query("SELECT * FROM instituicoes")->fetchAll();
?>
<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><title>Editar Doação</title><link rel="stylesheet" href="css/style.css"></head>
<body class="center-body"><div class="card login-card" style="max-width: 500px;">
    <h2>✏ Editar Doação</h2>
    <form method="POST">
        <div class="form-group"><label>Alimento</label><input type="text" name="alimento" value="<?= $d["alimento"] ?>" required></div>
        <div class="form-row"><div class="form-group flex-1"><label>Qtd</label><input type="number" step="0.1" name="quantidade" value="<?= $d["quantidade"] ?>" required></div><div class="form-group flex-1"><label>Unidade</label><select name="unidade"><option value="kg" <?= $d["unidade"]=="kg"?"selected":"" ?>>kg</option><option value="litros" <?= $d["unidade"]=="litros"?"selected":"" ?>>L</option><option value="unidades" <?= $d["unidade"]=="unidades"?"selected":"" ?>>un</option></select></div></div>
        <div class="form-group"><label>Instituição</label><select name="instituicao_id"><?php foreach($instituicoes as $i): ?><option value="<?= $i["id"] ?>" <?= $d["instituicao_id"]==$i["id"]?"selected":"" ?>><?= $i["nome"] ?></option><?php endforeach; ?></select></div>
        <div class="form-group"><label>Data</label><input type="date" name="data_doacao" value="<?= $d["data_doacao"] ?>" required></div>
        <button type="submit" class="btn">Salvar Alterações</button>
        <a href="painel_adm.php" class="btn-outline" style="margin-top:1rem; display:block;">Cancelar</a>
    </form>
</div>
    <footer class="footer-autoria">
        Código de autoria de Pedro Coutinho RU:3593047 UNINTER - CURSO ANALISE E DESENVOLVIMENTO DE SISTEMAS - POLO POUSO ALEGRE MG.
    </footer>
</body>
</html>