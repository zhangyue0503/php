<?php # Script 8.3 - WriteToFile2.php
// This page defines a WriteToFile and a FileException class.

/* The FileException class.
 * The class creates one new method: getDetails().
 */
class FileException extends Exception {

    // For returning more detailed error messages:
    function getDetails() {

        // Return a different message based upon the code:
        switch ($this->code) {
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
                return 'The file is not writable.';
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
        } // End of SWITCH.

    } // End of getDetails() method.

} // End of FileException class.

/* The WriteToFile class.
 * The class contains one attribute: $_fp.
 * The class contains three methods: __construct(), write(), close(), and __destruct().
 */
class WriteToFile {

    // For storing the file pointer:
private $_fp
= NULL;

    // For storing an error message:
    private $_message = '';

    // Constructor opens the file:
    function __construct($file = null, $mode = 'w') {

        // Assign the file name and mode
        // to the message attribute:
        $this->_message = "File: $file Mode: $mode";

        // Make sure a file name was provided:
        if (empty($file)) throw new FileException($this->_message, 0);

        // Make sure the file exists:
        if (!file_exists($file)) throw new FileException($this->_message, 1);

        // Make sure the file is a file:
        if (!is_file($file)) throw new FileException($this->_message, 2);

        // Make sure the file is writable, when necessary
        if (!is_writable($file)) throw new FileException($this->_message, 3);

        // Validate the mode:
        if (!in_array($mode, array('a', 'a+', 'w', 'w+'))) throw new FileException($this->_message, 4);

        // Open the file:
        $this->_fp = fopen($file, $mode);

    } // End of constructor.

    // This method writes data to the file:
    function write($data) {

        // Confirm the write:
        if (@!fwrite($this->_fp, $data . "\n")) throw new FileException($this->_message . " Data: $data", 5);

    } // End of write() method.

    // This method closes the file:
    function close() {

        // Make sure it's open:
        if ($this->_fp) {
            if (@!fclose($this->_fp)) throw new FileException($this->_message, 6);
            $this->_fp = NULL;
        }

    } // End of close() method.

    // The destructor calls close(), just in case:
    function __destruct() {
        $this->close();
    } // End of destructor.

} // End of WriteToFile class.