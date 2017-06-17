<?php

class Task_Install extends Minion_Task
{

    protected function _execute(array $params)
    {

        chdir(DOCROOT);

        passthru('git stash');
        passthru('git stash clear');
        passthru('git pull origin master');
        passthru('composer update');
        passthru('npm update');

        \Zver\Common::removeDirectoryContents(\Zver\FileCache::getDirectory());

        touch(\Zver\StringHelper::load(\Zver\FileCache::getDirectory())
                                ->ensureEndingIs(DIRECTORY_SEPARATOR)
                                ->append('.gitkeep')
                                ->get());

        $this->clearPreviewsAndUploads();
        $this->insertDump();

        passthru('gulp');

        $writable = [
            DOCROOT . 'application' . DIRECTORY_SEPARATOR . 'cache',
            DOCROOT . 'application' . DIRECTORY_SEPARATOR . 'logs',
            DOCROOT . 'inc' . DIRECTORY_SEPARATOR . 'build',
            DOCROOT . 'inc' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'uploads',
            DOCROOT . 'inc' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'previews',
        ];

        try {

            foreach ($writable as $dir) {
                chmod($dir, 0777);
                foreach (\Zver\Common::getDirectoryContentRecursive($dir) as $path) {
                    if (is_dir($path)) {
                        chmod($path, 0777);
                    }
                }
            }
        }
        catch (Throwable $e) {

        }
        catch (Exception $e) {

        }
    }

    protected function clearPreviewsAndUploads()
    {
        Minion_CLI::write('Clear previews and uploads...');

        $config = Kohana::$config->load('admin');

        $previewsDir = DOCROOT . $config->get('sharedDir') . DIRECTORY_SEPARATOR . $config->get('previewsDir');

        Minion_CLI::write('Clearing ' . $previewsDir . '...');
        \Zver\Common::removeDirectoryContents($previewsDir);

    }

    protected function insertDump()
    {
        $dumpDir = \Zver\DirectoryWalker::fromCurrent()
                                        ->get();

        $dumpFile = $dumpDir . 'dump.sql';

        Minion_CLI::write('Inserting dump ' . $dumpFile . '...');

        DB::query(Database::UPDATE, file_get_contents($dumpFile))
          ->execute();

    }

}