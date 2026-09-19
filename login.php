<?php
require_once "config/conexao.php";
$erro = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->execute([trim($_POST["usuario"])]);
    $user = $stmt->fetch();
    if ($user && password_verify($_POST["senha"], $user["senha"])) {
        $_SESSION["usuario_id"] = $user["id"];
        $_SESSION["usuario_tipo"] = $user["tipo"];
        header("Location: " . ($user["tipo"] === "DOADOR" ? "painel_doador.php" : "painel_adm.php"));
        exit;
    } else { $erro = "Usuário ou senha incorretos!"; }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Login - PousoAlegre Solidária</title><link rel="stylesheet" href="css/style.css"></head>
<body class="center-body">
    <div class="card login-card">
        <h2 style="justify-content:center;">PousoAlegre Solidária <small style="font-size:0.8rem; color:var(--accent-blue);">vFinal</small></h2>
        <?php if($erro): ?><div class="alert erro"><?= $erro ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group"><label>Usuário</label><input type="text" name="usuario" required placeholder="Digite seu usuário"></div>
            <div class="form-group"><label>Senha</label><input type="password" name="senha" required placeholder="Digite sua senha"></div>
            <button type="submit" class="btn">Entrar no Sistema</button>
        </form>
        <div style="text-align:center; margin-top:1.5rem;"><a href="index.php" class="btn-outline" style="display:inline-block; width:100%;">&larr; Voltar ao Mural Público</a></div>
    </div>
    <footer class="footer-autoria">
        Código de autoria de Pedro Coutinho RU:3593047 UNINTER - CURSO ANALISE E DESENVOLVIMENTO DE SISTEMAS - POLO POUSO ALEGRE MG.
    </footer>
</body>
</html>