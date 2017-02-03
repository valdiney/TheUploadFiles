<?php 
/**
* This class is used to do the upload of the files to the server
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
* @version 0.3
*
*--------------------------------------------------------------------------------------------------
* 
* Message Error.
* 1 = Error when trying to upload extensions not allowed by the user
* 2 = Error Beyond the user-defined size Maximum upload
*
*---------------------------------------------------------------------------------------------------
*/

namespace upfiles;

class UploadFiles
{
	private $config = [];
	private $file;
	private $extensions = [];
    private $allowedFileSize = 2;
    private $internalErrors;
    
    # The message error it's beginning null
    public function __construct()
    {
        $this->internalErrors["1"] = null;
        $this->internalErrors["2"] = null;
    }

    # Setting the attributes
	public function file($file)
	{
		$this->file = $file;
	}
    
    # The name of the folder that you can send the file
	public function folder($folder)
	{
		$this->config["folder"] = $folder;
	}
    
    # You can pass an array with the extensions of the files
	public function extensions(Array $extensions)
	{
		$this->extensions = $extensions;
	}
    
    /*You can demand a max size to the file that will be uploaded*/
    public function maxSize($fileSize = 4)
    {
        $this->allowedFileSize = $fileSize;
    }
    
    # This method do the input validation
    public function move()
    {
		$this->config["fileLength"] = 1024 * 1024 * $this->allowedFileSize;
		$this->config["theExtensions"] = $this->extensions;

        $prepareExtensions = explode(".", $this->file["name"]);
        $prepareExtensions = strtolower(end($prepareExtensions));
        
        # Verify the extension of the file
        if (array_search($prepareExtensions, $this->config["theExtensions"]) === false) {
            $this->internalErrors["1"] = true;
            return false;
        } 
        
        # Verify the max file limit
        if ($this->config["fileLength"] < $this->file["size"]) {
            $this->internalErrors["2"] = true;
            return false;
        }
        
        if (file_exists($this->config["folder"])) {
            return $this->moveFile();
        }
       
        return false;
	}
    
    # This method create the folder that will be passed like argument for the method sendTo() if the folder no exist
    private function createFolder()
    {
        if ( ! file_exists($this->config["folder"])) {
            mkdir($this->config["folder"], 0777, true);
        }
    }
    
    # This method move the files to the folder destination
    private function moveFile()
    {
        $getFinalExtension = explode(".", $this->file["name"]);
        $pathAndName = $this->config["folder"] . time() . "." . $getFinalExtension[1];
        $this->config["finalPath"] = $pathAndName;

        $this->createFolder();

        return move_uploaded_file($this->file["tmp_name"], $pathAndName);
    }
    
    # This method return the final name of the files and your extension
    public function destinationPath()
    {
        $this->moveFile();
        return $this->config["finalPath"];
    }
    
    # This method get status of errors
    public function getErrors()
    {
        $this->move();

        if ( ! is_null($this->internalErrors["1"])) {
            return 1;
        } elseif ( ! is_null($this->internalErrors["2"])) {
            return 2;
        }
    }

    # Empty the attributes
	public function __destruct()
	{
		unset($this->file);
		unset($this->config);
		unset($this->extensions);
        $this->allowedFileSize = null;
	}
}