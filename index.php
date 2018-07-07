<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Teste de uso da Class TheUploadFiles</title>
</head>
<body>
    <form method="post" action="save-files.php" enctype="multipart/form-data">
        <input  type="file" name="arquivo">
        <button type="submit" name="enviar">Enviar</button>
    </form>
    <br>
    <?php if (isset($_GET["enviar"])): ?>
        <a href="<?php echo $up->destinationPath(); ?>">Caminho do arquivo</a>
    <?php endif;?>
</body>
</html>
