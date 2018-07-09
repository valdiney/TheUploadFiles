# TheUploadFiles
Class PHP para efetuar o Upload de arquivos

<h3>Instalação:</h3>

<p>
    Você também pode fazer a instalação dessa classe via <b>composer</b>. Bastando configurar o require eu seu <b>arquivo composer.json</b>
    require: "valdiney/upload-files": "dev-master"
</p>

<a href="https://packagist.org/packages/valdiney/upload-files" target="_blank">Visite o projeto no Packagist</a>

<h3>Permissão de diretórios:</h3>

<strong>Dependendo do seu sistema operacional, principalmente no Linux/GNU, você precisará adicionar permissão aos diretórios:</strong>

>  `chmod -r 777 path/to/TheUploadFiles path/to/TheUploadFiles/arquivos`

<h4>.editorconfig:</h4>

<p>
    O projeto possui suporte ao <a href="https://editorconfig.org/" target="_blank">.editorconfig</a>. O <b>.editorconfig</b> possui suporte a diversos editores de código e IDEs, verifique como instalar no de sua preferência :wink: .
</p>

<h3>Descrição</h3>
<p>
    A maior parte de um script que realiza o Upload de arquivos é composta por varias validações. Fazer o Upload de arquivos pode apresentar certos perigos de segurança, por isso, precisamos minimizar os perigos validando cuidadosamente a entrada e natureza dos arquivos que serão enviados ao servidor.
</p>
<h3>Método getErrors():</h3>
<p>
    Quando o Script encontra um erro, guarda em memória o número referente ao erro! Você pode recuperar o erro e interromper o envio do arquivo para o servidor.
    Recupere os erros por via do método <b>getErrors()</b>
</p>
<h3>Exemplo de uso ( RECOMENDADO ):</h3>


```php

    # Incluindo a Classe para uso
    require_once("vendor/autoload.php");

    # Instanciando o objeto
    $up = new UPFiles\UploadFiles();

    # Recebe o arquivo do Formulário
    $arquivo = $_FILES["arquivo"];

    # Passando arquivo para a Classe
    $up->file($arquivo);

    # Passando o nome da pasta para onde você mandará o arquivo
    $up->folder("arquivos/");

    # Método opcional, por padrão a classe permite o tamanho padrão configurado pelo PHP que é 2Mb
    $up->maxSize(4);

    # Passando um Array de Extensões que poderá ser enviado para o servidor
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
    }
```

<h3>Número das mensagens de Erros:</h3>

```txt
* 1 = Formato de Arquivo não permitido no método (extensions)
* 2 = Tamanho de Arquivo ultrapassou o definido no método (maxSize)
* 3 = O sistema não conseguiu identificar a extensão.
* 4 = Erro ao salvar o arquivo no diretório `arquivos/`.
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

<h3>destinationPath()</h3>
<p>
    Para recuperar o caminho de destino do Arquivo enviado para o servidor, você pode usar o método <b>destinationPath()</b> que re torna o caminho completo do arquivo juntamente com o novo nome e extensão.

   <br>
    Esse método pode retornar algo como: http://127.0.0.1:8887/TheUploadFiles/arquivos/1422219491.pdf
</p>
