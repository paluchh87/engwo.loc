<?php

namespace controllers;

use components\Controller;

class AuthController extends Controller
{
    public function actionLogin()
    {
        if (isset($_SESSION['auth_username'])) {
            $this->model->logOut();
        }
        if (!empty($_POST)) {
            if ($this->model->login($_POST)) {
                $this->view->redirect('/engwo/dashboard');
            }
        }

        $this->view->render('Вход');
    }

    public function actionRegister()
    {
        if (!empty($_POST)) {
            if ($userId = $this->model->registerUser($_POST)) {
                if ($this->model->loginUserById($userId)) {
                    $this->view->redirect('/engwo/dashboard');
                }
            }
        }

        $this->view->render('Регистрация');
    }

    public function actionRecovery()
    {
        if (!empty($_POST)) {
            if ($this->model->recoveryPassword($_POST)) {
                $this->view->redirect('/engwo/login');
            }
        }

        $this->view->render('Вход');
    }

    public function actionPassword($selector = null, $token = null)
    {
        if ($selector != null AND $token != null) {
            if ($this->model->canSetNewPassword($selector, $token)) {
                $vars = [
                    'selector' => $selector,
                    'token' => $token
                ];
                $this->view->render('Change password', $vars);
            } else {
                $this->view->redirect('/engwo/login');
            }
        } else {
            $this->model->changePassword($_POST);
            $this->view->redirect('/engwo/login');
        }
    }
}
