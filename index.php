<?php
require_once("upfiles/UploadFiles.php");
use upfiles\UploadFiles as Up;

if (isset($_GET["enviar"]))
{
    $up = new upfiles\Up();
    $up->setInputFile($_FILES["arquivo"]);
    $up->sendTo("arquivos/");
    $up->SetMaxFileSize(1);
    $extensoes = array("jpg", "png", "gif", "pdf", "doc", "docx", "html", "txt", "avi", "mp4");
    $up->setExtensions($extensoes);

    if ($up->getErros() == 1)
    {
        echo "Erro ( Clítico ) referente ao tamanho máximo configurado no php.ini, por favor, entre em contato com os administradores do sistema";
    }
    elseif ($up->getErros() == 2)
    {
        echo "Os argumentos passados nos métodos (setExtensions e sendTo) precisam ser do tipo Array...";
    }
    elseif ($up->getErros() == 3)
    {
        echo "Ultrapaçou o tamanho limite para Upload definido pelo sistema";
    }
    elseif ($up->getErros() == 4)
    {
        echo "Esse formato de arquivo não é permitido pelo sistema";
    }
    elseif ($up->move())
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
<?php if (isset($_GET["enviar"])): ?>
    <a href="<?php echo $up->getPath(); ?>">Caminho do arquivo</a>
<?php endif; ?>
</body>

</html>