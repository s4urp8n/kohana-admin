<?php

class FileManipulator
{

    protected $filename = '';

    public function __construct($filename)
    {
        if (self::exists($filename)) {
            $this->filename = $filename;
        } else {
            throw new Exception('File "' . $filename . '" is not exists');
        }
    }

    public static function exists($filename)
    {
        return (file_exists($filename) && is_file($filename));
    }

    public function remove()
    {
        return unlink($this->filename);
    }

    public function __toString()
    {
        return $this->getFilename();
    }

    public function getFilename()
    {
        return $this->filename;
    }

}
