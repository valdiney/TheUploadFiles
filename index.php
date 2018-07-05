<?php
require_once("upfiles/UploadFiles.php");

if (isset($_GET["enviar"]))
{
    $up = new upfiles\UploadFiles();

    $up->file($_FILES["arquivo"]);
    $up->folder("arquivos/");
    $up->maxSize(4);
    $up->extensions(array("png","jpg","jpeg","gif","pdf","doc","docx","html","txt","avi","mp4", "zip"));

    if ($up->getErrors() == 1) {
        echo "Formato não esperado";
        return false;
    }

    if ($up->getErrors() == 2) {
        echo "O tamanho limite para Upload é de 4MB";
        return false;
    }

    if ($up->getErrors() == 3) {
        echo "Formato não identificado. Por favor, tente novamente.";
        return false;
    }

    if ($up->getErrors() == 4) {
        echo "Erro interno. Diretório não encontrado.";
        return false;
    }

    try {
        $up->move();
        echo "Upload feito com Sucesso!";
    } catch(\Exception $e) {
        echo "Ocorreu um erro ao tentar fazer o Upload: " . $e->getMessage();
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
    <a href="<?php echo $up->destinationPath(); ?>">Caminho do arquivo</a>
<?php endif;?>
</body>

</html>