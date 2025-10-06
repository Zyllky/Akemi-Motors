<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Akemi_Motors";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
if (isset($_POST['apagar'])) {
  $id = intval($_POST['apagar']);
  // Apagar todas as imagens do carro
  $sql = "SELECT imagem FROM carros WHERE id=$id";
  $res = $conn->query($sql);
  if ($res && $row = $res->fetch_assoc()) {
    $img_principal = $row['imagem'];
    if ($img_principal && file_exists("../Imagens/$img_principal")) {
      unlink("../Imagens/$img_principal");
    }
  }
  // Apagar imagens extras
  $carro_file = "../Carros_site/carro_$id.php";
  if (file_exists($carro_file)) {
    $conteudo = file_get_contents($carro_file);
    preg_match_all("/src='..\/Imagens\/(img_[^']+)'/", $conteudo, $matches);
    if (!empty($matches[1])) {
      foreach ($matches[1] as $img) {
        $img_path = "../Imagens/$img";
        if (file_exists($img_path)) {
          unlink($img_path);
        }
      }
    }
    unlink($carro_file);
  }
  $conn->query("DELETE FROM carros WHERE id=$id");
  echo "<p>Carro apagado com sucesso!</p>";
}
$sql = "SELECT * FROM carros ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Deletar Carro</title>
  <link rel="stylesheet" href="../Css/Deletar.css">
</head>
<body>
  <div id="TopoDaPag"><h1>Deletar Carro</h1></div>
  <div class="container">
    <h3>Carros cadastrados:</h3>
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
          echo "<td><form method='POST' style='display:inline-block;margin:0;'><button type='submit' name='apagar' value='" . $row['id'] . "' class='btn btn-danger btn-sm' style='width:100px;'>Apagar</button></form></td>";
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
