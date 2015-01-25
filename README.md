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
    
    /*Método opcional, por padrão a classe permite o tamanho padrão configurado pelo PHP que é 2Mb*/
    $up->setFileSize(4);
    
    /*Exemplo de um Array de extensões que você pode permitir para upload*/
    $extensoes = array("jpg","png","gif","pdf","doc","docx","html","txt"); 

    /*Passando o Array para o método que set seu valor para a class*/
    $up->setExtensions($extensoes);
    
    /*Método que manda os arquivos para pasta de destino*/
    if ($up->move())
    {
        echo "Arquivo enviado com Sucesso";
    }
}
?>

<!--O método "showPath()" mostra o caminho do arquivo juntamente com o seu nome e extensão-->
<a href="<?php echo $up->showPath(); ?>">Caminho do arquivo</a>
```

<h3>Obs:</h3>
<p>
    O método <b>setFileSize([int])</b> recebe como argumento um número inteiro. A classe recebe este número e efetua o calculo para obter o tamanho em <b>Bytes</b>, ou seja, se você passar para o método o valor 4 a classe entenderá que você deseja permitir arquivos de até <b>4Mb</b>.
    Infelizmente esse método é totalmente dependente das suas configurações no <b>PHP.ini</b>, por padrão estará no   <b>PHP.ini</b> o valor 2, ou seja, <b>2Mb</b>. Sendo assim este método deve ser usado somente se você configurar o <b>PHP.ini</b> para permitir um valor maior.
</p>

<h3>Mudanças no PHP.ini</h3>
<p>
    No seu <b>PHP.ini</b> pesquise por : <b>upload_max_filesize</b>  e atribua ao mesmo um valor maior 
</p>

```txt
/*Padrão*/
upload_max_filesize = 2M

/*Mude para 10M ou mais*/
upload_max_filesize = 10M
```

<h3>Mais sobre o método showPath()</h3>
<p>
    Geralmente depois de efetuar o Upload do arquivo gostaríamos de gravar o mesmo na base de dados, mas que método eu uso para recuperar o nome e caminho do arquivo que eu acabei de fazer o Upload?
</p>

<p>
    Como já mostrado acima você pode usar o método <b>showPath()</b> que retorna o caminho, nome e extensão do arquivo ao qual foi feito Upload. 
    Esse método pode retornar algo como: http://127.0.0.1:8887/TheUploadFiles/arquivos/1422219491.pdf
</p>

<img src="https://fbcdn-sphotos-d-a.akamaihd.net/hphotos-ak-xfp1/v/t1.0-9/10947164_704493479673230_1395423423614600590_n.jpg?oh=96cc9be174ab00661d031d260349b7fd&oe=5522CAC8&__gda__=1428654145_096661b0da9f703ce4521777182bba5c" alt="">