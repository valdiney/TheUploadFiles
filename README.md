# TheUploadFiles
Class PHP para efetuar o Upload de arquivos

<b>Instalação:</b>
<p>
    Você também pode fazer a instalação dessa classe via <b>composer</b>. Bastando configurar o require eu seu <b>arquivo composer.json</b>
    require: "valdiney/upload-files": "dev-master"
    
</p>

<a href="https://packagist.org/packages/valdiney/upload-files" target="_blank">Visite o projeto no Packagist</a>

<!--O método "destinationPath()" retorna o caminho do arquivo juntamente com o seu nome e extensão-->
<a href="<?php echo $up->destinationPath(); ?>">Caminho do arquivo</a>


<h3>Exemplo de uso ( RECOMENDADO ):</h3>
<p>
    A maior parte de um script que realiza o Upload de arquivos é composta por varias validações. Fazer o Upload de arquivos pode apresentar certos perigos de segurança, por isso, precisamos minimizar os perigos validando cuidadosamente a entrada e natureza dos arquivos que serão enviados ao servidor.
</p>
<h3>Método getErrors():</h3>
<p>
    Quando o Script encontra um erro, guarda em memória o número referente ao erro! Você pode recuperar o erro e interrompe o envio do arquivo para o servidor. 
    Recupere os erros por via do método <b>getErrors()</b>
</p>
```php
<?php
    # Incluindo a Classe para uso
    require_once("upfiles/UploadFiles.php");

    # Instanciando o objeto
    $up = new upfiles\UploadFiles();
    
    # Recebe o arquivo do Formulário
    $arquivo = $_FILES["arquivo"];

    # Passando arquivo para a Classe
    $up->file($arquivo); 
    
    # Passando o nome da pasta para onde você mandará o arquivo
    $up->folder("arquivos/"); 
    
    # Método opcional, por padrão a classe permite o tamanho padrão configurado pelo PHP que é 2Mb
    $up->maxSize(4);

    # Passando um Array de Extensões que poderá ser enviado para o servidor
    $up->extensions(array("jpg","png","gif","pdf","doc","docx","html","txt"));

    if ($up->getErrors() == 1) {
        echo "Formato de Arquivo não Permitido!";
        return false;
    }

    if ($up->getErrors() == 2) {
        echo "O tamanho limite para Upload é de 4Mb";
        return false;
    }

    try {
        $up->move();
        echo "Upload feito com Sucesso!";
    } catch(\Exception $e) {
        echo "Ocorreu um erro ao tentar fazer o Upload: " . $e->getMessage();
    }
?>
```
<h3>Número das mensagens de Erros:</h3>
```txt
* 1 = Formato de Arquivo não permitido no método (extensions)
* 2 = Tamanho de Arquivo ultrapassou o definido no método (maxSize)
```

<h3>Obs:</h3>
<p>
    O método <b>maxSize([int])</b> recebe como argumento um número inteiro. A classe recebe este número e efetua o calculo para obter o tamanho em <b>Bytes</b>, ou seja, se você passar para o método o valor 4 a classe entenderá que você deseja permitir arquivos de até <b>4Mb</b>.
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

<h3>Mais sobre o método destinationPath()</h3>
<p>
    Para recuperar o caminho de destino do Arquivo enviado para o servidor, você pode usar o método <b>destinationPath()</b> que re torna o caminho completo do arquivo juntamente com o novo nome e extensão.

   <br>
    Esse método pode retornar algo como: http://127.0.0.1:8887/TheUploadFiles/arquivos/1422219491.pdf
</p>
