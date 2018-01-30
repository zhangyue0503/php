<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/30
 * Time: 15:45
 */
class Example9_5
{
    protected $id;
    protected $directory;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function setDirectory($directory)
    {
        $this->directory = $directory . DIRECTORY_SEPARATOR . $this->id;

        if (!file_exists($this->directory)) {
            mkdir($this->directory, 0700, true);
        }
    }
}