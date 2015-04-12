<?php 
/**
* This class is used to make the upload of the files to the server
**--------------------------------------------------------------------------------------------------
*
* @var $config:           Array that stores the errors that will be generated
* @var $file:             Array -  $_FILES containing the name of the file field
* @var $extensios:        Array - containing the types of files that you want to allow
* @var $allowedFileSize:  Int Maximum size that you want to allow
*
*--------------------------------------------------------------------------------------------------
*
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @author Valdiney França <valdiney.2@hotmail.com>
* @version 0.2
*
*--------------------------------------------------------------------------------------------------
* 
* Error message.
* 1 = Error (Critical) for the maximum size set in php.ini
* 2 = Error when trying to upload extensions not allowed by the user
* 3 = Beyond the user-defined size Maximum upload
* 4 = Regarding the attempt to upload with file formats not allowed by the user
*
*---------------------------------------------------------------------------------------------------
*
*/

namespace upfiles;

class UploadFiles
{
	private $config;
	private $file;
	private $extensions;
    private $allowedFileSize = 2;
    private $internalErros;
    
    /*The message error it's beginning null*/
    public function __construct()
    {
        $this->internalErros["1"] = null;
        $this->internalErros["2"] = null;
        $this->internalErros["3"] = null;
        $this->internalErros["4"] = null;
    }

    /*Setting the attributes*/
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
    
    /*This method do the input validation */
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
            
            return false;
        } 
	}
    
    /*This method create the folder that will be passed like argument for the method sendTo() if the folder no exist*/
    private function createFolder()
    {
        if (!file_exists($this->config["folder"]))
        {
            mkdir($this->config["folder"], 0777, true);
        }
    }
    
    /*This method move the files to the folder destination*/
    private function moveFile()
    {
        $getFinalExtension = explode(".", $this->file["name"]);
        $pathAndName = $this->config["folder"] . time() . "." . $getFinalExtension[1];
        $this->config["finalPath"] = $pathAndName;
        return move_uploaded_file($this->file["tmp_name"], $pathAndName);
    }
    
    /*This method return the final name of the files and your extension*/
    public function getPath()
    {
        $this->moveFile();
        return $this->config["finalPath"];
    }
    
    /*This method get status of errors*/
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

    /*Empty the attributes*/
	public function __destruct()
	{
		unset($this->file);
		unset($this->config);
		unset($this->extensions);
        $this->allowedFileSize = null;
	}
}
/* End of file UploadFiles.php */
/* Location: upfiles */