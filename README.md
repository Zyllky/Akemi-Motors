<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Akemi_Motors";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
$sql = "SELECT * FROM carros ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akemi Motors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="\Carro Site\Css\PaginaPrincipal.css">
  </head>
  <body>
<!-- FONTES -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Kaushan+Script">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Merienda">
<!-- CORES DA PAGINA
Background: #EEE6D9
Background Barra de Pesquisa: #fdf9f1ff
Fundo Pesquisar: #f5efe4ff
Botão Pesquisar: #BC002D
-->

<!-- Topo Da Pag -->
    <div id=TopoDaPag>
    <h1>AKEMI MOTORS</h1>
</div>


<div id=Box class="cards-container">

  
<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $modelo = htmlspecialchars($row['modelo']);
        $preco = htmlspecialchars($row['preco']);
        $ano = htmlspecialchars($row['ano']);
        $quilometragem = htmlspecialchars($row['quilometragem']);
        $imagem = htmlspecialchars($row['imagem']);
        echo "<div class='card-box'>";
        echo "<img src='../Imagens/$imagem' class='card-img-top' alt='Imagem do $modelo' style='max-width:400px'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'> $modelo</h5>";
        echo "<p class='card-text'>Preço: R$ $preco</p>";
        echo "<p class='card-text'>Ano: $ano</p>";
        echo "<p class='card-text'>Quilometragem: $quilometragem km</p>";
        echo "<a href='../Carros_site/carro_$id.php' class='btn btn-primary'>Ver detalhes</a>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>Nenhum carro cadastrado ainda.</p>";
}
$conn->close();
?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>
