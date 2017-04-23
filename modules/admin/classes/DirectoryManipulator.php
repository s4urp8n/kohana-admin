<?php

class DirectoryManipulator
{

    protected $directory = '';
    protected $files = [];
    protected $directories = [];
    protected $loaded = false;

    public function __construct($directory)
    {
        if (self::exists($directory)) {
            $this->directory = $this->validateName($directory);
            $this->loaded = true;
        }
    }

    public static function exists($directory)
    {
        return (file_exists($directory) && is_dir($directory));
    }

    protected function validateName($directory)
    {
        return mb_eregi_replace(preg_quote(DIRECTORY_SEPARATOR) . '$', '', $directory) . DIRECTORY_SEPARATOR;
    }

    public static function load($directory)
    {
        return new self($directory);
    }

    public static function clearDirectory($directory)
    {
        self::removeDirectory($directory);

        return self::create($directory);
    }

    public static function removeDirectory($directory)
    {

        if (self::exists($directory)) {

            $dir = new self($directory);
            $dir->scan();

            $files = $dir->getFiles();
            foreach ($files as $file) {
                $file->remove();
            }

            $dirs = $dir->getDirectories();
            foreach ($dirs as $dir) {
                self::removeDirectory($dir);
            }

            return rmdir($directory);
        }
    }

    public static function create($directory, $mode = 0777)
    {
        if (!self::exists($directory)) {
            mkdir($directory, $mode, true);
        }

        return new self($directory);
    }

    public function scan()
    {
        if ($this->loaded) {

            $contents = scandir($this->directory);
            $contents = array_slice($contents, 2);

            $current = '';
            foreach ($contents as $content) {
                $current = $this->directory . $content;
                if (is_file($current)) {
                    $this->files[] = new FileManipulator($current);
                } elseif (is_dir($current)) {
                    $this->directories[] = new self($current);
                }
            }
        }

        return $this;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function getDirectories()
    {
        return $this->directories;
    }

    public function __toString()
    {
        return $this->getDirectory();
    }

    public function getDirectory()
    {
        return $this->directory;
    }

    public function remove()
    {
        return self::removeDirectory($this->directory);
    }

    public function clear()
    {
        $directory = $this->directory;
        self::removeDirectory($directory);

        return self::create($directory);
    }

}
