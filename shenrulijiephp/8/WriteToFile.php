<?php

/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/4
 * Time: 上午10:03
 */

class FileException extends Exception {
    function getDetails(){
        switch ($this->code){
            case 0:
                return 'No filename was provided';
            break;
            case 1:
                return 'The file does not exist.';
            break;
            case 2:
                return 'The file is not a file.';
            break;
            case 3:
                return 'The file is not writable';
            break;
            case 4:
                return 'An invalid mode was provided.';
            break;
            case 5:
                return 'The data could not be written.';
            break;
            case 6:
                return 'The file could not be closed.';
            break;
            default:
                return 'No further information is available.';
            break;

        }
    }
}


class WriteToFile
{
    private $_fp = NULL;


    function __construct($file=NULL,$mode = 'w')
    {

        if(!file_exists($file)||!is_file($file)){
            throw new FileException("The file does not exist.");
        }
        if(!$this->_fp=@fopen($file,'w')){
            throw new Exception('Could not open the file.');
        }

    }

    function write($data){
        if(@!fwrite($this->_fp,$data,'\n')){
            throw new Exception('Could not write to the file.');
        }
    }

    function close(){
        if($this->_fp){
            fclose($this->_fp);
            $this->_fp = NULL;
        }
    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->close();
    }

}

