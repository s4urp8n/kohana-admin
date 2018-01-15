<?php

namespace App;

class Mailer
{

    public static function send($email, $subject, $body)
    {

        $from = 'robot@mbplus.ru';

        try {

            $transport = new \Swift_SmtpTransport('smtp.googlemail.com', 465, 'ssl');
            $transport->setUsername($from);
            $transport->setPassword('whiterabbit3');

            $mailer = new \Swift_Mailer($transport);

            $message = new \Swift_Message();

            $message->setSubject($subject);

            $message->setFrom([$from => $from]);
            $message->setTo($email);
            $message->setBody($body, 'text/html');

            $result = $mailer->send($message);

            return true;

        } catch (Exception $e) {

        }

        return false;
    }
}
