<?php

class Feedback
{

    public static $tableName = 'feedback';
    public static $attempsPerDay = 3;
    public static $successText = 'Сообщение успешно отправлено. Мы обязательно свяжемся с Вами!';
    public static $spamAlertText = 'Исчерпан дневной лимит сообщений, сегодня отправка сообщений больше недоступна';
    public static $emptyNameAlertText = 'Введите не пустое имя';
    public static $emptyEmailPhoneAlertText = 'Оставьте контактные данные для обратной связи';
    public static $emptyMessageAlertText = 'Сообщение не должно быть пустым';
    public static $alertColor = '#FF0066';
    public static $successColor = '#99CC66';
    public static $captionText = 'Напишите нам';
    public static $nameText = 'Ваше имя (чтобы мы знали как к Вам обращаться):';
    public static $emailPhoneText = 'Ваш email или телефон (для обратной связи):';
    public static $messageText = 'Текст сообщения:';
    public static $submitText = 'Отправить';

    public static function getForm()
    {

        $alert = $success = $message = $email_phone = $temp = $name = $check = false;

        /* defining variables values */
        if (!empty($_POST)) {

            $check = true;
            if (!empty($_POST['message'])) {
                $temp = self::trim($_POST['message']);
                if (!empty($temp)) {
                    $message = $temp;
                }
            }

            if (!empty($_POST['name'])) {
                $temp = self::trim($_POST['name']);
                if (!empty($temp)) {
                    $name = $temp;
                }
            }

            if (!empty($_POST['email_phone'])) {
                $temp = self::trim($_POST['email_phone']);
                if (!empty($temp)) {
                    $email_phone = $temp;
                }
            }
        }

        /* validating */
        if ($check === true) {

            if (empty($name)) {
                $alert = self::$emptyNameAlertText;
            } elseif (empty($email_phone)) {
                $alert = self::$emptyEmailPhoneAlertText;
            } elseif (empty($message)) {
                $alert = self::$emptyMessageAlertText;
            } else {
                /* spam defence */
                self::checkTable();

                $today = date('Y-m-d');

                $identity = self::getIdentity();

                $todayMessages = DB::select([DB::expr('COUNT(id)'), 'c'])
                                   ->from(self::$tableName)
                                   ->where('`date`', '=', $today)
                                   ->where('identity', '=', $identity)
                                   ->execute()
                                   ->get('c');

                if ($todayMessages < self::$attempsPerDay) {

                    $model = new Model_Feedback();
                    $model->date = $today;
                    $model->message = $message;
                    $model->name = $name;
                    $model->email_phone = $email_phone;
                    $model->identity = $identity;
                    $model->save();

                    self::afterSuccess($today, $name, $email_phone, $message);

                    $message = $email_phone = $name = '';

                    $success = self::$successText;
                } else {
                    $alert = self::$spamAlertText;
                }
            }
        }

        /* rendering */
        $form = View::factory(
            'feedback/form', [
                               'message'     => $message,
                               'name'        => $name,
                               'alert'       => $alert,
                               'success'     => $success,
                               'email_phone' => $email_phone,
                           ]
        );

        return $form;
    }

    public static function trim($string)
    {
        return mb_eregi_replace('^[ ]+|[ ]+$', '', $string);
    }

    public static function checkTable()
    {
        $tables = self::getTables();
        if (!in_array(self::$tableName, $tables)) {
            self::createTable();
        }
    }

    public static function getIdentity()
    {

        $identity = '';

        if (!empty($_SERVER['REQUEST_METHOD'])) {
            $identity .= $_SERVER['REQUEST_METHOD'];
        }

        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $identity .= $_SERVER['HTTP_USER_AGENT'];
        }

        $identity .= self::getIP();

        return md5($identity);
    }

    public static function afterSuccess($date, $name, $email_phone, $message)
    {
        $message = "Вам оставили сообщение на сайте aversart.<br/><br/>" . "ДАТА: $date<br/>" . "ИМЯ: $name<br/>"
                   . "КОНТАКТНЫЕ ДАННЫЕ: $email_phone<br/>" . "СООБЩЕНИЕ:<br/><br/>$message<br/><br/><br/>";

        Mailer::send('pozitiv11@inbox.ru', 'Cообщение с aversart', $message);
    }

    public static function getTables()
    {
        $sql = 'SHOW TABLES';
        $tables = DB::query(Database::SELECT, $sql)
                    ->execute()
                    ->as_array();
        foreach ($tables as $index => $table) {
            $tables[$index] = array_shift($table);
        }

        return $tables;
    }

    public static function createTable()
    {
        $query = 'CREATE TABLE `avers`.`' . self::$tableName . '` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `email_phone` LONGTEXT NOT NULL,
            `name` LONGTEXT NOT NULL,
            `message` LONGTEXT NOT NULL,
            `date` DATE NOT NULL,
            `identity` VARCHAR(32) NOT NULL,
            PRIMARY KEY (`id`))
          ENGINE = MyISAM
          DEFAULT CHARACTER SET = utf8
          COLLATE = utf8_general_ci;
        ';

        DB::query(Database::UPDATE, $query)
          ->execute();

        $query = 'ALTER TABLE `avers`.`feedback` 
                ADD INDEX `DATE` (`date` ASC),
                ADD INDEX `IDENTITY` (`identity` ASC),
                ADD FULLTEXT INDEX `EMAIL_PHONE` (`email_phone` ASC);
        ';

        DB::query(Database::UPDATE, $query)
          ->execute();
    }

    public static function getIP()
    {
        $ip = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

}
