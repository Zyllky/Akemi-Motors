<?php
session_start();
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';
    // Usuario e senha
    $usuario_correto = 'Zyllky';
    $senha_correta = 'Senha7587';
    if ($usuario === $usuario_correto && $senha === $senha_correta) {
        $_SESSION['logado'] = true;
        header('Location: ADM.php');
        exit();
    } else {
        $erro = 'Usuário ou senha incorretos!';
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="\Akemi-Motors\Css\Login.css">
</head>
  <body>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Kaushan+Script">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Merienda">


<!-- TOPO DA PAG -->
    <div id=TopoDaPag>
    <h1>Login</h1>
   </div> 
<!-- LOGIN -->

<div id=Login class="container-login">
    <div class="login-box">
        <h2 style="color: #BC002D;">Login Administração</h2>
        <?php if ($erro) echo '<div class="alert alert-danger">'.$erro.'</div>'; ?>
        <form method="post">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuário</label>
                <input id=CampoTexto type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input id=CampoTexto type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <button id=Botão type="submit" class="btn btn-login w-100">Entrar</button>
        </form>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>