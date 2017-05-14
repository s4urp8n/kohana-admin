<?php

class Task_UpdateDump extends Minion_Task
{

    protected function _execute(array $params)
    {
        $dumpFile = \Zver\DirectoryWalker::fromCurrent()
                                         ->get() . 'dump.sql';

        $database = Kohana::$config->load('database')
                                   ->get('default')['connection']['dsn'];

        $database = preg_match_all('#dbname=(\w+)#i', $database, $matches);

        if (isset($matches[1]) && isset($matches[1][0])) {

            $database = $matches[1][0];

            $username = Kohana::$config->load('database')
                                       ->get('default')['connection']['username'];

            $password = Kohana::$config->load('database')
                                       ->get('default')['connection']['password'];

            /**
             * For modern mysqldump
             */
            putenv('MYSQL_PWD=' . $password);

            $dumpCommand = "mysqldump --user=" . $username . " --password=" . $password . " --add-drop-table --lock-tables --disable-keys " . $database;

            $dumpCommand .= " > " . escapeshellarg($dumpFile);

            exec($dumpCommand, $output, $exitCode);

            if ($exitCode !== 0) {
                throw new Exception('Can\'t update dump');
            }

            echo 'Successfully update dump ' . $dumpFile . "\n";

        } else {
            throw new Exception('Can\'t get database config');
        }

    }

}