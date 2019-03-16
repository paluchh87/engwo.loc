<?php

namespace controllers;

use components\Controller;
use lib\Pagination;
use lib\Pdf;
use lib\Validate;
use lib\Checker;

class MainController extends Controller
{
    public $maxWords = 10;

    public function actionIndex()
    {
        $this->view->render('Главная страница');
    }

    public function actionDashboard($totalWords = null, $totalCorrectAnswers = null, $timeStart = null)
    {
        if (isset($totalWords) AND isset($totalCorrectAnswers) AND isset($timeStart)) {
            $timeStart = str_replace('%20', ' ', $timeStart);
            $timeEnd = date("Y-m-d H:i:s");
            $this->model->addResult($totalWords, $totalCorrectAnswers, $timeStart, $timeEnd);
            $this->view->redirect('/engwo/dashboard');
        }

        $vars = [
            'lastResult' => $this->model->getLastResult(),
            'totalResult' => $this->model->getTotalResult(),
            'lessons' => $this->model->getLessonsInfo(),
        ];

        $vars['achievements'] = $this->model->getAchievements($vars['totalResult']);

        $this->view->render('Dashboard', $vars);
    }

    public function actionStatistics()
    {
        $vars = [
            'lastResult' => $this->model->getLastResult(),
            'totalResult' => $this->model->getTotalResult(),
            'allDictionary' => $this->model->getUserDictionary(),
            'dynamics' => $this->model->getDynamics(),
        ];

        $contentPdf = Pdf::getPdfTemplate($vars);
        Pdf::createPdf($contentPdf);

        $this->view->render('Статистика', $vars);
    }

    public function actionAdd()
    {
        if (!empty($_POST)) {
            $post = $_POST;
            if (Validate::validateWord($post)) {
                $result = $this->model->addWord($post);

                if (Checker::checkAddWord($result)) {
                    $post['word'] = '';
                    $post['translation'] = '';
                }
            }
        } else {
            $post['lesson'] = $this->model->getLastLesson();
            $post['word'] = '';
            $post['translation'] = '';
        }

        $vars = [
            'post' => $post
        ];
        $this->view->render('Внос данных', $vars);
    }

    public function actionWords($page = null)
    {
        $filters = null;
        if (!empty($_POST)) {
            $filters = $this->prepareFilters($_POST);
        }

        $this->route['page'] = $page;
        $countWords = $this->model->getWordsCount($filters);
        if ($countWords > 0) {
            $pagination = new Pagination($this->route, $countWords, $this->maxWords);
            $this->route['page'] = $pagination->checkPage($page);
            $vars = [
                'pagination' => $pagination->get(),
                'words' => $this->model->getWords($this->route, $this->maxWords, $filters)
            ];
        }
        $vars['filters'] = $filters['params'];

        $this->view->render('Words', $vars);
    }

    protected function prepareFilters($filters)
    {
        $str = '';
        $params = [];
        foreach ($filters as $key => $value) {
            if ($value !== '') {
                $str = $str . " AND `$key` LIKE CONCAT('%', :$key, '%')";
                $params[$key] = $value;
            }
        }
        return ['query' => $str, 'params' => $params];
    }

    public function actionEdit($id = null)
    {
        if (!empty($_POST)) {
            $post = $_POST;
            if (Validate::validateWord($post)) {
                $result = $this->model->editWord($post);
                Checker::checkEditWord($result);
            }
        } else {
            $post = $this->model->getWordOne($id);
        }

        $vars = [
            'post' => $post
        ];
        $this->view->render('Редактировать пост', $vars);
    }

    public function actionDelete($id)
    {
        $result = $this->model->deleteWord($id);
        if (!Checker::checkDeleteWord($result)) {
            $this->view->render('Words');
        } else {
            $this->view->redirect('/engwo/words');
        }
    }

    public function actionTesting()
    {
        $vars = [
            'data' => $this->model->getDataTesting($_POST),
        ];
        $this->model->addResult($vars['data']['countQuestions'], null, $vars['data']['date'], null, 'start');

        $this->view->render('Go', $vars);
    }

    public function actionAjax()
    {
        $vars = [
           'words' => $this->model->getWords($this->route, $this->maxWords)
        ];

        $this->view->render('Words', $vars);
    }

    public function actionAjaxanswer()
    {
        $filters = null;
        //logToFile('GET', $_GET);

        if (!empty($_GET['filters'])) {
            $filters = $this->prepareFilters($_GET['filters']);
        }

        $order = $_GET['order'];
        $orderBy = $_GET['orderBy'];
        $this->route['page'] = (int)($_GET['id']);
        $max = $this->maxWords + (int)($_GET['max']);

        $data = $this->model->getWords($this->route, $max, $filters, $order, $orderBy);

        echo json_encode($data);
    }
}
