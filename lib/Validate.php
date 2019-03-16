<?php

namespace lib;

use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator as v;

class Validate
{
    public static function validateWord($post)
    {
        $validator = v::key('word', v::stringType()->notEmpty())
            ->key('translation', v::stringType()->notEmpty())
            ->key('lesson', v::stringType()->notEmpty());
        $messages = self::getMessagesWordValidation();

        return self::validate($post, $validator, $messages);
    }

    protected static function getMessagesWordValidation()
    {
        return [
            'word' => 'Заполните поле Word',
            'translation' => 'Заполните поле Translation',
            'lesson' => 'Заполните поле Lesson',
        ];
    }

    protected static function validate($post, v $validator, $messages = [])
    {
        try {
            $validator->assert($post);

            return true;
        } catch (ValidationException $exception) {
            $exception->findMessages($messages);
            flash()->error($exception->getMessages());
        }

        return false;
    }

    public static function validateUser($post)
    {
        $validator = v::key('login', v::stringType()->notEmpty())
            ->key('email', v::email())
            ->key('password', v::stringType()->notEmpty())
            ->keyValue('password_confirmation', 'equals', 'password');
        $messages = self::getMessagesUserValidation();

        if (!self::validate($post, $validator, $messages)) {
            return false;
        }

        return true;
    }

    protected static function getMessagesUserValidation()
    {
        return [
            'login' => 'Введите имя',
            'email' => 'Неверный формат e-mail',
            'password' => 'Введите пароль',
            'password_confirmation' => 'Пароли не совпадают'
        ];
    }
}
