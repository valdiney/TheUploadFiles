<?php
require_once("class/TheUploadFiles.class.php");

if (isset($_GET["enviar"]))
{
    $up = new TheUploadFiles();
    $up->setInputFile($_FILES["arquivo"]);
    $up->sendTo("arquivos/");
    $extensoes = array("jpg","png","gif","pdf","doc","docx","html","txt");
    $up->setExtensions($extensoes);
    if ($up->move())
    {
        echo "Arquivo enviado com Sucesso";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Teste de uso da Class TheUploadFiles</title>
</head>

<body>
<form method="post" action="index.php?enviar" enctype="multipart/form-data">
    <input type="file" name="arquivo">
    <button type="submit">Enviar</button>
</form>
</body>

</html>