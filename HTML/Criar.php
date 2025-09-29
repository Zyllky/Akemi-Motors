<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $preco = $_POST['preco'];
    $ano = $_POST['ano'];
    $modelo = $_POST['modelo'];
    $km = $_POST['km'];
    $img = '';
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $img = 'img_' . time() . rand(100,999) . '.' . $ext;
        move_uploaded_file($_FILES['imagem']['tmp_name'], '../Css/' . $img);
    }
    $carros = [];
    if (file_exists('../carros.json')) {
        $carros = json_decode(file_get_contents('../carros.json'), true);
    }
    $id = uniqid();
    $carro = [
        'id' => $id,
        'preco' => $preco,
        'ano' => $ano,
        'modelo' => $modelo,
        'km' => $km,
        'img' => $img
    ];
    $carros[] = $carro;
    file_put_contents('../carros.json', json_encode($carros));
    $pagina = fopen("carro_$id.php", "w");
    $conteudo = "<!doctype html>\n<html lang='en'>\n<head>\n<meta charset='utf-8'>\n<title>Carro $modelo</title>\n<link rel='stylesheet' href='../Css/PaginaPrincipal.css'>\n</head>\n<body>\n<div id='carro'>\n<h1>Modelo: $modelo</h1>\n<img src='../Css/$img' style='max-width:400px'><br>\n<p>Preço: R$ $preco</p>\n<p>Ano: $ano</p>\n<p>Quilometragem: $km km</p>\n<a href='PaginaPrincipal.php'>Voltar</a>\n</div>\n</body>\n</html>";
    fwrite($pagina, $conteudo);
    fclose($pagina);
    header('Location: PaginaPrincipal.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Carro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="\Carro Site\Css\Criar.css">  
    
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Kaushan+Script">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Merienda">

</head>
  <body>
    <div id=TopoDaPag>
      <h1>Cadastrar Carro</h1>
    </div>
    <div class="container">
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label class="form-label">Preço</label>
          <input type="text" name="preco" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Ano</label>
          <input type="text" name="ano" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Modelo</label>
          <input type="text" name="modelo" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Quilometragem</label>
          <input type="text" name="km" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Imagem</label>
          <input type="file" name="imagem" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
