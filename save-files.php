<?php
// displaying errors in PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_POST["enviar"]))
{
    header('Location: index.php');
    exit();
}

require_once("vendor/autoload.php");
$up = new UPFiles\UploadFiles();

$up->file($_FILES["arquivo"]);
$up->folder("arquivos/");
$up->maxSize(4);
$up->extensions(array("png","jpg","jpeg","gif","pdf","doc","docx","html","txt","avi","mp4", "zip"));

$error = null;

switch($up->getErrors()) {
    case 1:
        $error = "Formato não esperado";
        break;
    case 2:
        $error = "O tamanho limite para Upload é de 4MB";
        break;
    case 3:
        $error = "Formato não identificado. Por favor, tente novamente.";
        break;
    case 4:
        $error = "Erro interno. Diretório não encontrado.";
        break;
}

try {
    if ($error!==null) {
        throw new Exception($error);
    }
    $up->move();
    echo "Upload feito com Sucesso! <br>";
    echo "<a href=\"{$up->destinationPath()}\">Caminho do arquivo.</a>";
} catch(\Exception $e) {
    echo "Ocorreu um erro ao tentar fazer o Upload: " . $e->getMessage();
} finally {
    echo "<br>";
    echo "<a href=\"index.php\">Enviar outro arquivo.</a>";
}
