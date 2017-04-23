<?php

class Task_ClearCache extends Minion_Task
{

    protected function _execute(array $params)
    {
        \Zver\FileCache::clearAll();
        $this->clearPreviews();
    }

    protected function clearPreviews()
    {
        Minion_CLI::write('Clear previews and uploads...');

        $config = Kohana::$config->load('admin');

        $previewsDir = DOCROOT . $config->get('sharedDir') . DIRECTORY_SEPARATOR . $config->get('previewsDir');

        Minion_CLI::write('Clearing ' . $previewsDir . '...');
        $this->removePath($previewsDir);

    }

    protected function removePath($path, $callback = null, $removeSelf = false)
    {
        if (file_exists($path)) {
            if (is_file($path)) {
                if (is_null($callback) || (is_callable($callback) && $callback($path) === true)) {
                    @unlink($path);
                }
            } else {
                $iterator = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
                $files = new RecursiveIteratorIterator(
                    $iterator, RecursiveIteratorIterator::CHILD_FIRST
                );

                foreach ($files as $file) {
                    if ($file->isDir()) {
                        if (is_null($callback) || (is_callable($callback) && $callback($file->getRealPath()) === true)) {
                            @rmdir($file->getRealPath());
                        }
                    } else {
                        if (is_null($callback) || (is_callable($callback) && $callback($file->getRealPath()) === true)) {
                            @unlink($file->getRealPath());
                        }
                    }
                }

                if (is_null($callback) || (is_callable($callback) && $callback($path) === true)) {
                    if ($removeSelf) {
                        @rmdir($path);
                    }
                }
            }
        }
    }

}