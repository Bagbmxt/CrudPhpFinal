<?php
// Inicialize a sessão
session_start();
 
// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bem vindo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php">Home</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="login.php">Login</a>
              </li>
            
              <li class="nav-item">
                <a class="nav-link" href="reset-password.php">Redefinia sua senha</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="register.php">Cadastre-se</a>
              </li>
              <li class="nav-item">
                <b><a class="nav-link" href="welcome.php">Sair</a></b>
              </li>
        </nav>


    <h1 class="my-5">Oi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Bem vindo ao nosso site.</h1>
    <p>
    <a href="index.php" class="btn btn-primary ml-3">Vá para o Site</a><br><br>
        <a href="reset-password.php" class="btn btn-warning ml-3">Redefina sua senha</a><br><br>
        <a href="logout.php" class="btn btn-danger ml-3">Sair da conta</a><br>
    </p>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</html>