<?php 
/**
* Class para fazer Upload de pequenos arquivos...
*
* @var $config - Array - de possíveis erros que podem ocorrer
* @var $file - Array -  $_FILES contendo o nome do campo file
* @var $extensios - Array - contendo os tipos dos arquivos que você deseja permitir
* @var $allowedFileSize - Int Tamanho máximo que você queira permitir
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @author Valdiney França <valdiney.2@hotmail.com>
* @version 0.2
*
*--------------------------------------------------------------------------------------------------
* Mensagens de Erro.
* 1 = Erro ( Critico ) referente ao tamanho máximo configurado no php.ini
* 2 = Erro ao tentar fazer upload de extensões não permitidas pelo utilizador
* 3 = Ultrapassam o tamanho Maximo de upload definido pelo utilizador
* 4 = Referente a tentativa de upload com formatos de arquivos não permitido pelo utilizador
*
*---------------------------------------------------------------------------------------------------
*
*/

class TheUploadFiles
{
	private $config;
	private $file;
	private $extensions;
    private $allowedFileSize = 2;
    private $internalErros;
    
    /*Inicialmente as mensagens internas de erros são todas Nulas*/
    public function __construct()
    {
        $this->internalErros["1"] = null;
        $this->internalErros["2"] = null;
        $this->internalErros["3"] = null;
        $this->internalErros["4"] = null;
    }

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
            $this->internalErros["2"] = 1;
        }
        elseif ($this->file["error"] != 0)
        {
            if ($this->file["error"] == 1)
            {
                $this->internalErros["1"] = 1;
            }
        }
        elseif (array_search($prepareExtensions, $this->config["theExtensions"]) === false)
        {
            $this->internalErros["4"] = 1;
        }
        elseif ($this->config["fileLength"] < $this->file["size"])
        {
        	$this->internalErros["3"] = 1;
        }
        else
        {
            if (file_exists($this->config["folder"]))
            {
                $this->moveFile();
                return true;
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
        $this->moveFile();
        return $this->config["finalPath"];
    }
    
    /*Método pega status de erros gerados pela class durante suas validações*/
    public function getErros()
    {
        $this->move();
        if ($this->internalErros["1"] != null)
        {
            return 1;
        }
        elseif ($this->internalErros["2"] != null)
        {
            return 2;
        }
        elseif ($this->internalErros["3"] != null)
        {
            return 3;
        }
        elseif ($this->internalErros["4"] != null)
        {
            return 4;
        }
    }

    /*Descarregando os atributos*/
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