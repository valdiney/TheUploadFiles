<?php 
/**
* Class para fazer Upload de pequenos arquivos...
* @var $config - Array - de possíveis erros que podem ocorrer
* @var $file - Array -  $_FILES contendo o nome do campo file
* @var $extensios - Array - contendo os tipos dos arquivos que você deseja permitir
* @var $allowedFileSize - Int Tamanho máximo que você queira permitir
* @version 0.2
* @author Valdiney França
*/

class TheUploadFiles
{
	private $config;
	private $file;
	private $extensions;
    private $allowedFileSize = 2;

    /*set - Seta os atributos*/
	public function setInputFile($file)
	{
		$this->file = $file;
	}
    
	public function sendTo($folder)
	{
		$this->config["folder"] = $folder;
	}
    
	public function setExtensions($extensions)
	{
		$this->extensions = $extensions;
	}

    public function SetMaxFileSize($fileSize)
    {
        $this->allowedFileSize = $fileSize;
    }
    /*end set*/
    
    /*Método faz as validações de entrada*/
    public function move()
    {
		$this->config["fileLength"] = 1024 * 1024 * $this->allowedFileSize;
		$this->config["theExtensions"] = $this->extensions;

        $prepareExtensions = explode(".", $this->file["name"]);
        $prepareExtensions = strtolower(end($prepareExtensions));
        $this->createFolder();

        if (!is_array($this->extensions) or !is_array($this->file))
        {
            echo "Os argumentos passados nos métodos (setExtensions e sendTo) precisam ser do tipo Array";
        }
        elseif ($this->file["error"] != 0)
        {
            switch($this->file["error"])
            {
                case 1 :
                    echo "O arquivo é maior do que o permitido pelo PHP: ";
                    break;
                case 2 :
                    echo "O arquivo ultrapassa o tamanho limite: ";
                    break;
                case 3 :
                    echo "O arquivo foi carregado parcialmente: ";
                    break;
                case 4 :
                    echo "Não foi feito o upload do arquivo: ";
                    break;
            }
        }
        elseif (array_search($prepareExtensions, $this->config["theExtensions"]) === false)
        {
            $typeFiles = implode(", ", $this->config["theExtensions"]);
        	echo  " Evie apenas esses tipos de arquivos: " . $typeFiles . " ";
        }
        elseif ($this->config["fileLength"] < $this->file["size"])
        {
        	echo 'O arquivo enviado é muito grande, envie arquivos de até ' . $this->allowedFileSize . "Mb";
        }
        else
        {
            if (file_exists($this->config["folder"]))
            {
                $this->moveFile();
            }
            else
            {
                return false;
            }
        } 
	}
    
    /*Método cria a pasta se a mesma passada como argumento para o método sendTo() não existir*/
    private function createFolder()
    {
        if (!file_exists($this->config["folder"]))
        {
            mkdir($this->config["folder"], 0777, true);
        }
    }
    
    /*Método move o arquivo para a pasta de destino*/
    private function moveFile()
    {
        $getFinalExtension = explode(".", $this->file["name"]);
        $pathAndName = $this->config["folder"] . time() . "." . $getFinalExtension[1];
        $this->config["finalPath"] = $pathAndName;
        return move_uploaded_file($this->file["tmp_name"], $pathAndName);
    }
    
    /*Método retorna o caminho final do arquivo juntamente com seu nome e extensão*/
    public function getPath()
    {
        return $this->config["finalPath"];
    }
    
    /*Descarregam os atributos*/
	public function __destruct()
	{
		unset($this->file);
		unset($this->config);
		unset($this->extensions);
        $this->allowedFileSize = null;
	}
}
/* End of file TheUploadFiles.class.php */
/* Location: class */