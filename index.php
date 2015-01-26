<?php
require_once("class/TheUploadFiles.class.php");

if (isset($_GET["enviar"]))
{
    $up = new TheUploadFiles();
    $up->setInputFile($_FILES["arquivo"]);
    $up->sendTo("arquivos/");
    $up->SetMaxFileSize(1);
    $extensoes = array("jpg","png","gif","pdf","doc","docx","html","txt","avi","mp4");
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
<br>
<a href="<?php echo $up->getPath(); ?>">Caminho do arquivo</a>
</body>

</html>