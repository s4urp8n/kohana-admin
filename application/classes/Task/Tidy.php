<?php

class Task_Tidy extends Minion_Task
{

    protected function _execute(array $params)
    {

        $tables = DB::query(Database::SELECT, 'show tables')
                    ->execute();

        foreach ($tables as $table) {

            $table = array_shift($table);

            $columns = DB::query(Database::SELECT, 'show columns from `' . $table . '`')
                         ->execute();

            $fields = [];

            foreach ($columns as $column) {
                $field = $column['Field'];
                $fields[] = $field;
            }

            if (in_array('id', $fields)) {

                foreach ($fields as $field) {

                    if ($field != 'id') {

                        $values = DB::select('id', $field)
                                    ->from($table)
                                    ->execute();

                        foreach ($values as $value) {

                            $id = $value['id'];
                            $value = \Zver\StringHelper::load($value[$field]);

                            if ($value->isContainIgnoreCase(' style=')) {

                                $value = $value->remove('style=["\'][^"\']+["\']')
                                               ->get();

                                DB::update($table)
                                  ->set([$field => $value])
                                  ->where('id', '=', $id)
                                  ->execute();
                            }

                        }
                    }

                }
            }

        }

    }

}