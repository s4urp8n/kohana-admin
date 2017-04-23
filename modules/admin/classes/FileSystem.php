<?php

/**
 * class to manipulate files and directories
 */
abstract class FileSystem
{

    public static function removeDirectoryContent($directory)
    {
        if (file_exists($directory)) {
            $temp = '';
            $files = array_diff(scandir($directory), ['.', '..']);
            foreach ($files as $file) {
                $temp = $directory . '/' . $file;
                (is_dir($temp))
                    ? static::removeDirectory($temp)
                    : unlink($temp);
            }
        }
    }

    public static function removeDirectory($directory)
    {
        if (file_exists($directory)) {
            static::removeDirectoryContent($directory);

            return rmdir($directory);
        }
    }

    public static function getFileContents($file_name)
    {
        $handle = fopen($file_name, 'r');
        flock($handle, LOCK_SH);
        $value = fread($handle, filesize($file_name));
        flock($handle, LOCK_UN);
        fclose($handle);

        return $value;
    }

    public static function setFileContents($file_name, $content, $mode = 'w')
    {
        $handle = fopen($file_name, $mode);
        flock($handle, LOCK_EX);
        fwrite($handle, $content);
        flock($handle, LOCK_UN);
        fclose($handle);
    }

}
