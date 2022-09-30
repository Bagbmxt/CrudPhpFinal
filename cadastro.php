<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/192d859c0f.js" crossorigin="anonymous"></script> 
    <title>Document</title>
</head>
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
                <a class="nav-link" href="">Vazio</a>
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
            
            
            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
<body>
<center><h1>Cadastro de PDF e JPG</h1> </center>
<br><br><br>

<?php
// Inicialize a sessão
session_start();
 
// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
  
    exit;
}


include("config.php");


if(isset($_GET['deletar'])) {

    $id = intval($_GET['deletar']);
    $sql_query = $pdo->query("SELECT * FROM arquivos WHERE id = '$id'") or die($mysqli->error); 
    $arquivo = $sql_query->fetch();  

    if(unlink($arquivo['path'])) {
        $deu_certo = $pdo->query("DELETE FROM arquivos WHERE id = '$id'") or die ($mysqli->error);
        if($deu_certo)
        echo "<center><b>Arquivo excluído com sucesso!!</b><center><br><br>";
      
    }

    
}

if(isset($_FILES['arquivo'])) {
    $arquivo = $_FILES['arquivo'];

    if($arquivo['error'])
        die("Falha ao enviar arquivo");


    if($arquivo['size'] > 102097152)
        die("Arquivo muito grande!! max: 40MB");

    $pasta = "arquivos/";
    $nomeDoArquivo = $arquivo['name'];
    $novoNomeDoArquivo = uniqid();
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

    if($extensao != "jpg" && $extensao != 'pdf')
        die ("Tipo de arquivo não aceito");
       
        
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
    $deu_certo = move_uploaded_file($arquivo["tmp_name"], $path);
    if($deu_certo) {
        $pdo->query("INSERT INTO arquivos (nome, path) VALUES('$nomeDoArquivo','$path')") or die($mysqli->error);
       echo "<center><b>Arquivo enviado com sucesso! Para acessá-lo, <a target=\"_blank\" href=\"arquivos/$novoNomeDoArquivo.$extensao\">Clique aqui.</a></b></center><br><br>";
    }else
        echo "<p>Falha ao enviar arquivo</p>";
        

}

$sql_query = $pdo->query("SELECT * FROM arquivos") or die($sql->error);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/192d859c0f.js" crossorigin="anonymous"></script> 

    <title>Upload de Arquivo</title>
</head>
<body id="index">
  <center>
    <form method="POST" enctype="multipart/form-data" action="">
      <p>  <label for="">Selecione o arquivo</label>
        <input name="arquivo" type="file"></p>
        <button name="upload" type="submit">Enviar arquivo </button>
       
    </form>
    <br><br>
    
 
    <table  border="1" cellpadding="10">
        <thead >
        <h3>Lista de Arquivos em PDF</h3>
            <th>Preview</th>
            <th>Nome</th>
            <th>Data de Envio</th>
            <th>Ver</th>
            <th>Deletar</th>
            
        </thead>
        <tbody>
            <?php
            

            while($arquivo = $sql_query->fetch()) {
            ?>
            <tr>
                <td><img height="50" src="<?php echo $arquivo['path']; ?>" alt=""></td>
                <td><?php echo $arquivo['nome']; ?></td>
                 <td><?php echo date("d/m/Y H:i", strtotime($arquivo['data_upload'])); ?></td>
                <td><a target="_blank" href="<?php echo $arquivo['path']; ?>"><i class="fa-solid fa-magnifying-glass btnlupa"></i></a></td>
                <th><a href="index.php?deletar=<?php echo $arquivo['id']; ?>"><i class="fa-solid fa-circle-xmark btndel"></i></a></td>
               
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
         
    </center>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</html>