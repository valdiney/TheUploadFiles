<?php
// displaying errors in PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
