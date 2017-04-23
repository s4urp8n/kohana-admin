<?php

class Task_Install extends Minion_Task
{

    protected function _execute(array $params)
    {
        \Zver\Common::removeDirectoryContents(\Zver\FileCache::getDirectory());

        touch(\Zver\StringHelper::load(\Zver\FileCache::getDirectory())
                                ->ensureEndingIs(DIRECTORY_SEPARATOR)
                                ->append('.gitkeep')
                                ->get());

        $this->clearPreviewsAndUploads();
        $this->insertDump();
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