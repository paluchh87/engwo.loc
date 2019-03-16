<?php

namespace models;

use components\Model;
use lib\Validate;
//use lib\Mail;

class Auth extends Model
{
    public $error;
    public $status;

    public function logout()
    {
        $this->auth->logOut();
    }

    public function login($post)
    {
        try {
            $this->auth->login($post['email'], $post['password']);

            return true;
        } catch (\Delight\Auth\InvalidEmailException $e) {
            flash()->error(['Wrong email address']);
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            flash()->error(['Wrong password']);
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            flash()->error(['Email not verified']);
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error(['Too many requests']);
        }

        return false;
    }

    public function registerUser($post)
    {
        if (!Validate::validateUser($post)) {
            return false;
        }

        try {
            $userId = $this->auth->register($post['email'], $post['password'], $post['login'],
                function ($selector, $token) {
                    $this->auth->confirmEmail($selector, $token);
                });

            return $userId;
        } catch (\Delight\Auth\InvalidEmailException $e) {
            flash()->error(['Invalid email address']);
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            flash()->error(['Invalid password']);
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            flash()->error(['User already exists']);
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error(['Too many requests']);
        }

        return false;
    }

    public function loginUserById($userId)
    {
        try {
            $this->auth->admin()->logInAsUserById($userId);

            return true;
        } catch (\Delight\Auth\UnknownIdException $e) {
            flash()->error(['Unknown ID']);
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            flash()->error(['Email address not verified']);
        }

        return false;
    }

    public function recoveryPassword($post)
    {
        try {
            $this->auth->forgotPassword($post['email'], function ($selector, $token) use ($post) {
                // send `$selector` and `$token` to the user (e.g. via email)
                $this->passwordReset($post['email'], $selector, $token);
                flash()->success(['Код сброса пароля был отправлен вам на почту.']);
            });

            return true;
        } catch (\Delight\Auth\InvalidEmailException $e) {
            flash()->error(['Invalid email address']);
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            flash()->error(['Email address not verified']);
        } catch (\Delight\Auth\ResetDisabledException $e) {
            flash()->error(['Password reset is disabled']);
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error(['Too many requests']);
        }
        return false;
    }

    public function passwordReset($email, $selector, $token)
    {
        //$message = 'https://kmgdev.loc/engwo/password/' . \urlencode($selector) . '/' . \urlencode($token);
        flash()->success(['<a href="/engwo/password/' . \urlencode($selector) . '/' . \urlencode($token) . '" target="_blank">Ссылка на новый пароль</a>']);

        //TODO почтовый ящик
        //Mail::send($email, $message);
    }

    public function canSetNewPassword($selector, $token)
    {
        if ($this->auth->canResetPassword($selector, $token)) {
            return true;
        }
        flash()->error(['Ошибка. Неверный токен']);

        return false;
    }

    public function changePassword($post)
    {
        //validate password;
        if (empty($post)) {
            flash()->error(['Ошибка. Нет доступа']);

            return false;
        }
        try {
            $this->auth->resetPassword($post['selector'], $post['token'], $post['password']);

            flash()->success(['Пароль успешно изменен.']);
            return true;
        } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            flash()->error(['Неверный токен']);
        } catch (\Delight\Auth\TokenExpiredException $e) {
            flash()->error(['Токен просрочен']);
        } catch (\Delight\Auth\ResetDisabledException $e) {
            flash()->error(['Изменение пароля отключено пользователем']);
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            flash()->error(['Введите пароль']);
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error(['Too many requests']);
        }

        return false;
    }
}
