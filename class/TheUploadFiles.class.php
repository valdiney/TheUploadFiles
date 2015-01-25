<?php 
/**
* Class para fazer Upload de pequenos arquivos...
* @var $config - array de possíveis erros que podem ocorrer
* @var $file - array $_FILES contendo o nome do campo file
* @var $extensios - array contendo os tipos dos arquivos que você deseja permitir
* @version 0.1
* @author Valdiney França
*/

class TheUploadFiles
{
	private $config;
	private $file;
	private $extensions;
    
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
    /*end set*/

    /*Este método efetua um conjunto de validações*/
	private function configValidation()
	{
		$this->config["fileLength"] = 1024 * 1024 * 10;
		$this->config["theExtensions"] = $this->extensions;

        if ($this->file["error"] != 0)
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

        $prepareExtensions = explode(".", $this->file["name"]);
        $prepareExtensions = strtolower(end($prepareExtensions));
        if (array_search($prepareExtensions, $this->config["theExtensions"]) === false)
        {
        	$typeFiles = null;
        	foreach($this->config["theExtensions"] as $list)
        	{
        		$typeFiles .= $list . ", ";
        	}

        	echo  "Evie apenas esses tipos de arquivos: " . $typeFiles;
        }
        elseif ($this->config["fileLength"] < $this->file["size"])
        {
        	echo 'O arquivo enviado é muito grande';
        }
	}
    
    /*Este método move os arquivos da pasta temporária para a pasta de destino*/
	public function move()
	{
		$this->configValidation();
        if (file_exists($this->config["folder"]))
        {
            $getFinalExtension = explode(".", $this->file["name"]);
            $pathAndName = $this->config["folder"] . time() . "." . $getFinalExtension[1];
            $this->config["finalPath"] = $pathAndName;
            return move_uploaded_file($this->file["tmp_name"], $pathAndName);
        }
        else
        {
            echo "A pasta destino não existe";
        }
	}
    
    /*Método mostra o caminho final do arquivo juntamente com seu nome e extensão*/
    public function showPath()
    {
        return $this->config["finalPath"];
    }
    
    /*Descarregam os atributos*/
	public function __destruct()
	{
		unset($this->file);
		unset($this->config["folder"]);
		unset($this->extensions);
	}
}
