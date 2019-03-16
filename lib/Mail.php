<?php

namespace lib;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Mail
{
    public static $transport = null;
    public static $mailer = null;
    public static $config=[];

    public static function getConfig()
    {
        if (empty(self::$config)){
            self::$config = require_once ROOT . '/config/mail.php';
        }

        return self::$config;
    }

    public static function getTransport()
    {
        if (!self::$transport) {
            $config = self::getConfig();
            self::$transport = (new Swift_SmtpTransport($config['smtp'], $config['port']))
                ->setUsername($config['email'])
                ->setPassword($config['password'])
                ->setEncryption($config['encryption']);
        }

        return self::$transport;
    }

    public static function getMailer()
    {
        if (!self::$mailer) {
            self::$mailer = new Swift_Mailer(self::getTransport());
        }

        return self::$mailer;
    }

    public static function send($email, $body)
    {
        $config = self::getConfig();
        $message = (new Swift_Message('Wonderful Subject'))
            ->setFrom([$config['email'] => 'ENGWO'])
            ->setTo([$email])
            ->setBody($body)
        ;

        return self::getMailer()->send($message);
    }
}