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
    $up->SetMaxFileSize(4);
    
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

<!--O método "getPath()" mostra o caminho do arquivo juntamente com o seu nome e extensão-->
<a href="<?php echo $up->getPath(); ?>">Caminho do arquivo</a>
```

<h3>Exemplo de uso ( RECOMENDADO ):</h3>
<p>
    A maior parte de um script que trata da função de realizar Upload de arquivos é composta por varias validações. Fazer o Upload de arquivos pode apresentar certos perigos de segurança, por isso, precisamos minimizar os perigos validando cuidadosamente a entrada e natureza dos arquivos que serão enviados ao servidor. 
</p>

<h3>Método getErros():</h3>
<p>
    Quando o Script encontra um erro o mesmo guarda em memória o número referente a este erro e interrompe o envio do arquivo para o servidor. Os usuário precisam saber quais foram os motivos do arquivo não ter sido enviado, sendo assim, a utilização do método <b>getErros()</b> te da a flexibilidade de apresentar para o usuário mensagens de erros personalizadas.
</p>

```php
<?php
require_once("class/TheUploadFiles.class.php");

if (isset($_GET["enviar"]))
{
    $up = new TheUploadFiles();
    $up->setInputFile($_FILES["arquivo"]);
    $up->sendTo("arquivos/");
    $up->SetMaxFileSize(2);
    $extensoes = array("jpg","png","gif","pdf","doc","docx","html","txt","avi","mp4");
    $up->setExtensions($extensoes);

    if ($up->getErros() == 1)
    {
        echo "Erro ( Critico ) referente ao tamanho máximo configurado no php.ini, por favor, entre em contato com os administradores do sistema";
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
```
<h3>Número das mensagens de Erros:</h3>
```txt
* 1 = Erro ( Critico ) referente ao tamanho máximo configurado no php.ini
* 2 = O argumento passado para os métodos ( setInputFile() e setExtensions() ) precisam ser do tipo Array
* 3 = Ultrapassam o tamanho Maximo de upload definido pelo utilizador
* 4 = Referente a tentativa de upload com formatos de arquivos não permitido pelo utilizador
```

<h3>Obs:</h3>
<p>
    O método <b>SetMaxFileSize([int])</b> recebe como argumento um número inteiro. A classe recebe este número e efetua o calculo para obter o tamanho em <b>Bytes</b>, ou seja, se você passar para o método o valor 4 a classe entenderá que você deseja permitir arquivos de até <b>4Mb</b>.
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

<h3>Mais sobre o método getPath()</h3>
<p>
    Geralmente depois de efetuar o Upload do arquivo gostaríamos de gravar o mesmo na base de dados, mas que método eu uso para recuperar o nome e caminho do arquivo que eu acabei de fazer o Upload?
</p>

<p>
    Como já mostrado acima você pode usar o método <b>getPath()</b> que retorna o caminho, nome e extensão do arquivo ao qual foi feito Upload. 
    Esse método pode retornar algo como: http://127.0.0.1:8887/TheUploadFiles/arquivos/1422219491.pdf
</p>
