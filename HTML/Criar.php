<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $preco = $_POST['preco'];
    $ano = $_POST['ano'];
    $modelo = $_POST['modelo'];
    $quilometragem = $_POST['quilometragem'];
    $imagens = [];
    if (isset($_FILES['imagem'])) {
      $total = min(count($_FILES['imagem']['name']), 6);
      for ($i = 0; $i < $total; $i++) {
        if ($_FILES['imagem']['error'][$i] == 0) {
          $ext = pathinfo($_FILES['imagem']['name'][$i], PATHINFO_EXTENSION);
          $img = 'img_' . time() . rand(100,999) . "_" . $i . '.' . $ext;
          move_uploaded_file($_FILES['imagem']['tmp_name'][$i], '../Imagens/' . $img);
          $imagens[] = $img;
        }
      }
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Akemi_Motors";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

  $img_principal = isset($imagens[0]) ? $imagens[0] : '';
  $stmt = $conn->prepare("INSERT INTO carros (modelo, preco, quilometragem, ano, imagem) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssis", $modelo, $preco, $quilometragem, $ano, $img_principal);
  $stmt->execute();
  $id = $stmt->insert_id;
  $stmt->close();

    if (!is_dir('../Carros_site')) {
        mkdir('../Carros_site', 0777, true);
    }
    $pagina = fopen("../Carros_site/carro_$id.php", "w");
    $main_img = isset($imagens[0]) ? $imagens[0] : '';
    $miniaturas_html = '';
    foreach ($imagens as $idx => $img) {
      $miniaturas_html .= "<img class='carro-miniatura' src='../Imagens/$img' alt='Miniatura' onclick='trocarImagemPrincipal(\"../Imagens/$img\")'>\n";
    }
    $imagens_html = "<div class='carro-imagens-galeria'>\n  <img id='imagemPrincipal' class='carro-img-principal' src='../Imagens/$main_img' alt='Imagem principal'>\n  <div class='carro-miniaturas'>$miniaturas_html</div>\n</div>";
    $header = "<div id='TopoDaPag'><h1>AKEMI MOTORS</h1></div>";
  $conteudo = "<!doctype html>\n<html lang='en'>\n<head>\n<meta charset='utf-8'>\n<title>Carro $modelo</title>\n<link rel='stylesheet' href='../Css/Carros.css'>\n<link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Kaushan+Script'>\n<link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Merienda'>\n</head>\n<body>\n$header\n<div class='carro-pagina'>\n  <div class='carro-imagens-galeria'>$imagens_html</div>\n  <div class='carro-info'>\n    <h1>Modelo: $modelo</h1>\n    <p>Preço: R$ $preco</p>\n    <p>Ano: $ano</p>\n    <p>Quilometragem: $quilometragem km</p>\n    <a href='..\HTML\PaginaPrincipal.php' class='btn btn-primary'>Voltar</a>\n  </div>\n</div>\n<script>\nfunction trocarImagemPrincipal(src) {\n  document.getElementById('imagemPrincipal').src = src;\n}\n</script>\n</body>\n</html>";
    fwrite($pagina, $conteudo);
    fclose($pagina);
    $conn->close();
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
          <label class="form-label">Modelo</label>
          <input type="text" name="modelo" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Ano</label>
          <input type="text" name="ano" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Preço</label>
          <input type="text" name="preco" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Quilometragem</label>
          <input type="text" name="quilometragem" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Imagens</label>
          <input type="file" name="imagem[]" class="form-control" accept="image/*" multiple required onchange="previewImagens(event)">
        </div>
  <div id="previewImagens" style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:20px;"></div>
  <input type="hidden" name="ordem_imagens" id="ordemImagens">
        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    let imagensPreview = [];
    function previewImagens(event) {
      imagensPreview = [];
      const files = event.target.files;
      for (let i = 0; i < files.length && i < 6; i++) {
        const file = files[i];
        imagensPreview.push({file, idx: i});
      }
      renderPreview();
    }

    let dragSrcIdx = null;
    function dragStart(e) {
      dragSrcIdx = Number(e.target.dataset.idx);
      e.dataTransfer.effectAllowed = 'move';
    }
    function dragOver(e) {
      e.preventDefault();
      e.dataTransfer.dropEffect = 'move';
    }
    function dropImg(e) {
      e.preventDefault();
      const tgtIdx = Number(e.target.dataset.idx);
      if (dragSrcIdx !== null && dragSrcIdx !== tgtIdx) {
        const moved = imagensPreview.splice(dragSrcIdx, 1)[0];
        imagensPreview.splice(tgtIdx, 0, moved);
        imagensPreview.forEach((img, i) => img.idx = i);
        renderPreview();
      }
      dragSrcIdx = null;
    }

    function renderPreview() {
      const preview = document.getElementById('previewImagens');
      preview.innerHTML = '';
      imagensPreview.forEach((imgObj, i) => {
        const reader = new FileReader();
        reader.onload = function(e) {
          const wrapper = document.createElement('div');
          wrapper.style.display = 'inline-block';
          wrapper.style.position = 'relative';
          wrapper.style.margin = '10px';
          wrapper.style.verticalAlign = 'top';

          const img = document.createElement('img');
          img.src = e.target.result;
          img.style.maxWidth = '220px';
          img.style.maxHeight = '180px';
          img.style.borderRadius = '15px';
          img.style.display = 'block';
          img.draggable = true;
          img.dataset.idx = i;
          img.addEventListener('dragstart', dragStart);
          img.addEventListener('dragover', dragOver);
          img.addEventListener('drop', dropImg);

          wrapper.appendChild(img);
          preview.appendChild(wrapper);
        }
        reader.readAsDataURL(imgObj.file);
      });
      atualizarOrdemInput();
    }

    function atualizarOrdemInput() {
      document.getElementById('ordemImagens').value = imagensPreview.map(img => img.idx).join(',');
    }
    </script>
  </body>
</html>
