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
        if (isset($_POST["cpf"])) { $pdo->prepare("UPDATE doadores SET cpf = ? WHERE usuario_id = ?")->execute([trim($_POST["cpf"]), $id]); }
        if (!empty($nova_senha)) {
            if ($nova_senha === $_POST["confirma_senha"]) {
                $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?")->execute([password_hash($nova_senha, PASSWORD_DEFAULT), $id]);
                $pdo->prepare("UPDATE doadores SET senha_plana_temp = ? WHERE usuario_id = ?")->execute([$nova_senha, $id]);
            } else { throw new Exception("As senhas não coincidem!"); }
        }
        $pdo->commit(); header("Location: usuarios.php"); exit;
    } catch (Exception $e) { $pdo->rollBack(); $erro = $e->getMessage(); }
}
$u = $pdo->prepare("SELECT u.*, d.cpf FROM usuarios u LEFT JOIN doadores d ON d.usuario_id = u.id WHERE u.id = ?"); $u->execute([$id]); $user = $u->fetch();
?>
<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><title>Editar Usuário</title><link rel="stylesheet" href="css/style.css"></head>
<body class="center-body"><div class="card login-card" style="max-width: 500px;">
    <h2>✏ Editar Usuário</h2>
    <?php if($erro): ?><div class="alert erro"><?= $erro ?></div><?php endif; ?>
    <form method="POST">
        <div class="form-row"><div class="form-group flex-1"><label>Nome</label><input type="text" name="nome" value="<?= $user["nome"] ?>" required></div><div class="form-group flex-1"><label>Sobrenome</label><input type="text" name="sobrenome" value="<?= $user["sobrenome"] ?>" required></div></div>
        <div class="form-group"><label>Login (Usuário)</label><input type="text" name="usuario" value="<?= $user["usuario"] ?>" required></div>
        <?php if($user["tipo"] === "DOADOR"): ?><div class="form-group"><label>CPF</label><input type="text" name="cpf" value="<?= $user["cpf"] ?>"></div><?php endif; ?>
        <hr class="divider">
        <div class="form-group"><label>Nova Senha <small>(Deixe em branco p/ manter)</small></label><input type="password" name="nova_senha"></div>
        <div class="form-group"><label>Confirmar Nova Senha</label><input type="password" name="confirma_senha"></div>
        <button type="submit" class="btn">Salvar Alterações</button><a href="usuarios.php" class="btn-outline" style="margin-top:1rem; display:block;">Cancelar</a>
    </form>
</div>
    <footer class="footer-autoria">
        Código de autoria de Pedro Coutinho RU:3593047 UNINTER - CURSO ANALISE E DESENVOLVIMENTO DE SISTEMAS - POLO POUSO ALEGRE MG.
    </footer>
</body>
</html>