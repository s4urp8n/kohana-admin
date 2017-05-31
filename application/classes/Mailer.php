<?php

class Mailer
{

    public static function send($emails, $subject, $body, $fromName)
    {

        $from = 'robot@mbplus.ru';

        $to = $emails;
        if (!is_array($to)) {
            $to = [$to];
        }

        try {

            $transport = Swift_SmtpTransport::newInstance('smtp.googlemail.com', 465, 'ssl')
                                            ->setUsername($from)
                                            ->setPassword('whiterabbit3');

            $mailer = Swift_Mailer::newInstance($transport);

            $message = Swift_Message::newInstance($subject)
                                    ->setFrom([$from => $fromName])
                                    ->setTo($to)
                                    ->setBody($body, 'text/html');

            $result = $mailer->send($message);

            return true;
        }
        catch (Exception $e) {

        }

        return false;
    }
}
