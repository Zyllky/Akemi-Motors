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
  <title>Listar Carros</title>
  <link rel="stylesheet" href="../Css/Listar.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Kaushan+Script">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Merienda">
</head>
<body>
  <div id="TopoDaPag"><h1>Carros Cadastrados</h1></div>
  <div class="container">
    <table class="adm-table">
      <tr>
        <th>ID</th>
        <th>Modelo</th>
        <th>Preço</th>
        <th>Ano</th>
        <th>Quilometragem</th>
        <th>Imagem</th>
        <th>Ações</th>
      </tr>
      <?php
      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['id'] . "</td>";
          echo "<td>" . htmlspecialchars($row['modelo']) . "</td>";
          echo "<td>R$ " . htmlspecialchars($row['preco']) . "</td>";
          echo "<td>" . htmlspecialchars($row['ano']) . "</td>";
          echo "<td>" . htmlspecialchars($row['quilometragem']) . " km</td>";
          echo "<td><img src='../Imagens/" . htmlspecialchars($row['imagem']) . "' style='max-width:80px'></td>";
          echo "<td><form method='POST' action='Deletar.php' style='display:inline-block;margin:0;'><button type='submit' name='apagar' value='" . $row['id'] . "' class='btn btn-danger btn-sm' style='width:100px;'>Apagar</button></form></td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='7'>Nenhum carro cadastrado.</td></tr>";
      }
      $conn->close();
      ?>
    </table>
    <a href="ADM.php" class="btn btn-primary" style="margin-top:20px;display:inline-block;">Voltar</a>
  </div>
</body>
</html>
