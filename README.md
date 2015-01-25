# TheUploadFiles
Class PHP para efetuar o Upload de arquivos
<p>
	Para fazer uso da class basta chamá-la, instanciá-la e passar os valores exigidos para os seus métodos e em seguida  chamar o método que realiza o upload.
</p>

<h3>Exemplo de uso:</h3>
```php
<?php
require_once("class/TheUploadFiles.class.php");

if (isset($_GET["enviar"]))
{
	/*Instanciando o objeto*/
    $up = new TheUploadFiles(); 

    /*Passando o nome do campo File*/
    $up->setInputFile($_FILES["arquivo"]); 
    
    /*Passando o nome da pasta de destino*/
    $up->sendTo("arquivos/"); 
    
    /*Exemplo de um Array de extensões que você deseja permitir*/
    $extensoes = array("jpg","png","gif","pdf","doc","docx","html","txt"); 

    /*Passando o Array para o método*/
    $up->setExtensions($extensoes);
    
    /*Método que manda os arquivos para pata de destino*/
    if ($up->move())
    {
        echo "Arquivo enviado com Sucesso";
    }
}
?>
```
<h3>Lembrando que</h3>
<p>
    No PHP com configuração padrão o limite de Upload´s está direcionado a aceitar até <b>2Mb</b>. Sendo assim recomenda-se que se for o caso de fazer o Upload de arquivos maiores consulte o seu <b>PHP.ini</b> e efetue as possíveis mudanças.
</p>
<p>
    No seu <b>PHP.ini</b> pesquise por : <b>upload_max_filesize</b>  e atribua ao mesmo um valor maior 
</p>

```txt
/*Padrão*/
upload_max_filesize = 2M

/*Mude para ou mais*/
upload_max_filesize = 10M
```