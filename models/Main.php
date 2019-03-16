<?php

namespace models;

use components\Model;
use lib\DB;

class Main extends Model
{
    public $error;
    public $status;

    public function addResult($totalWords, $totalCorrectAnswers, $timeStart, $timeEnd, $result = 'finish')
    {
        $params = [
            'user_login' => $_SESSION['auth_username'],
            'count_words' => $totalWords,
            'count_correct_answers' => $totalCorrectAnswers,
            'result' => $result,
            'date_start' => $timeStart,
            'date_end' => $timeEnd,
        ];

        $query = "INSERT INTO `words_log` (`user_login`, `count_words`, `count_correct_answers`,`result`,`date_start`,`date_end`) VALUES (:user_login, :count_words, :count_correct_answers, :result, :date_start, :date_end)";
        DB::add($query, $params);
    }

    public function getLastResult()
    {
        $params = [
            'user_login' => $_SESSION['auth_username'],
            'result' => 'finish',
        ];

        $query = "SELECT *, TIMEDIFF(`date_end`,`date_start`) as `time` FROM `words_log` WHERE `user_login`=:user_login AND `result`=:result ORDER BY `id` DESC LIMIT 1";
        $result = DB::getRow($query, $params);

        return [
            'count_words' => $result['count_words'],
            'count_correct_answers' => $result['count_correct_answers'],
            'time' => $result['time'],
        ];
    }

    public function getTotalResult()
    {
        $params = [
            'user_login' => $_SESSION['auth_username'],
            'result' => 'finish',
        ];
        $query = "SELECT SUM(count_correct_answers), SUM(count_words), SUM(TIMEDIFF(`date_end`,`date_start`)) as `time` FROM `words_log` WHERE `user_login`=:user_login AND `result`=:result";
        $result = DB::getRow($query, $params);

        return [
            'count_words' => $result['SUM(count_words)'],
            'count_correct_answers' => $result['SUM(count_correct_answers)'],
            'time' => $result['time'],
        ];
    }

    public function getLessonsInfo()
    {
        $params = [
            'user' => $_SESSION['auth_username'],
        ];
        $query = "SELECT `lesson`, COUNT(word) as `count` FROM `words_dictionary` WHERE `user`=:user GROUP BY `lesson`, `user`";

        return DB::getAll($query, $params);
    }

    public function getAchievements($totalResult)
    {
        $achievements = [
            'words' => false,
            'percent' => false,
            'any' => false
        ];
        if ($totalResult["count_words"] > 50) {
            $achievements['words'] = true;
            $result = $totalResult["count_correct_answers"] / $totalResult["count_words"];
            if ($result > 0.96) {
                $achievements['percent'] = true;
            }
        }

        return $achievements;
    }

    public function getUserDictionary()
    {
        $params = [
            'user' => $_SESSION['auth_username'],
        ];
        $query = "SELECT * FROM `words_dictionary` WHERE `user`=:user";

        return DB::getAll($query, $params);
    }

    public function getDynamics()
    {
        $words = '';
        $correctAnswers = '';
        $incorrectAnswers = '';
        $params = [
            'user' => $_SESSION['auth_username'],
            'limit' => 20
        ];

        $query = "SELECT * FROM (SELECT * FROM `words_log` WHERE `user_login`=:user AND `result`='finish' ORDER BY `id` DESC LIMIT :limit) AS last ORDER BY `id` ";
        $results = DB::getAllWithBindValue($query, $params);
        foreach ($results as $row) {
            $words .= '{label: "' . $row['date_start'] . '", y: ' . $row['count_words'] . '}, ';
            $correctAnswers .= '{label: "' . $row['date_start'] . '", y: ' . $row['count_correct_answers'] . '}, ';
            $incorrectAnswers .= '{label: "' . $row['date_start'] . '", y: ' . ($row['count_words'] - $row['count_correct_answers']) . '}, ';
        }

        return [
            'words' => substr($words, 0, -2),
            'correctAnswers' => substr($correctAnswers, 0, -2),
            'incorrectAnswers' => substr($incorrectAnswers, 0, -2),
        ];
    }

    public function addWord($post)
    {
        $params = [
            'word' => ucfirst($post['word']),
            'translation' => mb_convert_case($post['translation'], MB_CASE_TITLE, "UTF-8"),
            'lesson' => $post['lesson'],
            'user' => $_SESSION['auth_username'],
            'date' => date("Y-m-d"),
        ];
        $query = "INSERT INTO `words_dictionary` (`word`, `translation`, `lesson`, `user`, `date`) VALUES (:word, :translation, :lesson, :user, :date)";

        return DB::add($query, $params);
    }

    public function getLastLesson()
    {
        $params = [
            'user' => $_SESSION['auth_username'],
        ];
        $query = "SELECT `lesson` FROM `words_dictionary` WHERE `user`=:user ORDER BY `lesson` DESC LIMIT 1";
        $result = DB::getRow($query, $params);

        return $result['lesson'];
    }

    public function getWordsCount($filters = null)
    {
        $params = [
            'user' => $_SESSION['auth_username'],
        ];

        //$query = "SELECT COUNT(id) FROM `words_dictionary` WHERE `user`=:user";
        if ($filters !== null) {
            $params = array_merge($params, $filters['params']);
        }
        $query = "SELECT COUNT(id) FROM `words_dictionary` WHERE `user`=:user" . $filters['query'];

        $count = DB::getRow($query, $params);

        return $count['COUNT(id)'];
    }

    public function getWords($route, $max, $filters = null, $order = 'asc', $orderBy = 'id')
    {
        $params = [
            'user' => $_SESSION['auth_username'],
            'start' => ((($route['page'] ?? 1) - 1) * $max),
            'max' => $max,
        ];
        //$query = "SELECT `id`, `word`, `translation`, `lesson` FROM `words_dictionary` WHERE `user`=:user ORDER BY `id` DESC LIMIT :start, :max";

        if ($filters !== null) {
            $params = array_merge($params, $filters['params']);
        }

        $order = '`' . $orderBy . '` ' . $order;
        $query = "SELECT `id`, `word`, `translation`, `lesson` FROM `words_dictionary` WHERE `user`=:user" . $filters['query'] . " ORDER BY " . $order . " LIMIT :start, :max";

        return DB::getAllWithBindValue($query, $params);
    }

    public function editWord($post)
    {
        $params = [
            'word' => ucfirst($post['word']),
            'translation' => mb_convert_case($post['translation'], MB_CASE_TITLE, "UTF-8"),
            'lesson' => $post['lesson'],
            'date' => date("Y-m-d"),
            'id' => $post['id'],
        ];
        $query = "UPDATE `words_dictionary` SET `word`=:word,`translation`=:translation,`lesson`=:lesson,`date`=:date WHERE `id`=:id";

        return DB::set($query, $params);
    }

    public function getWordOne($id)
    {
        $params = [
            'id' => $id,
        ];
        $query = "SELECT `id`, `word`, `translation`, `lesson`, `user` FROM `words_dictionary` WHERE `id`=:id";
        $result = DB::getRow($query, $params);

        return $result;
    }

    public function deleteWord($id)
    {
        $params = [
            'id' => $id,
        ];
        $query = "DELETE FROM `words_dictionary` WHERE `id`=:id";
        $result = DB::set($query, $params);

        return $result;
    }

    public function getDataTesting($post)
    {
        $params = [
            'user' => $_SESSION['auth_username'],
        ];
        $words = $this->getRussianWord($params);
        $translation = $this->getTranslation($params);
        $qaa = $this->getQaa($params, $post);
        $countQuestions = count($qaa);
        if (isset($post['countQuestions']) AND $countQuestions > $post['countQuestions']) {
            $countQuestions = $post['countQuestions'];
        }
        shuffle($qaa);
        $qaa = array_slice($qaa, 0, $countQuestions);

        if (isset($post['russianQuestions'])) {
            $russianQuestions = 1;
            $result = $this->getTest($words, $qaa, $russianQuestions);
        } else {
            $russianQuestions = 0;
            $result = $this->getTest($translation, $qaa, $russianQuestions);
        }

        $date = date("Y-m-d H:i:s");

        return [
            'russianQuestions' => $russianQuestions,
            'countQuestions' => $countQuestions,
            'questions' => json_encode($result['questions']),
            'correctAnswers' => json_encode($result['correctAnswers']),
            'wrongAnswers' => json_encode($result['wrongAnswers']),
            'date' => $date
        ];
    }

    private function getRussianWord($params)
    {
        $qw4 = "SELECT `word` FROM `words_dictionary` WHERE `user`=:user GROUP BY `word`";

        return DB::getColumn($qw4, $params);
    }

    private function getTranslation($params)
    {
        $qw3 = "SELECT `translation` FROM `words_dictionary` WHERE `user`=:user GROUP BY `translation`";

        return DB::getColumn($qw3, $params);
    }

    private function getQaa($params, $post = null)
    {
        $query = "SELECT `word`, `translation` FROM `words_dictionary` WHERE `user`=:user";
        if (isset($post['option'])) {
            $set = '';
            foreach ($post['option'] as $opt) {
                $set .= "`lesson`='$opt' OR ";
            }
            $set = substr($set, 0, -4);
            $query = "SELECT `word`, `translation` FROM `words_dictionary` WHERE `user`=:user AND " . $set;
        }

        return DB::getAll($query, $params);
    }

    private function getTest($array, $qaa, $russianQuestions)
    {
        $index = $this->getIndex($russianQuestions);
        $questions = [];
        $correctAnswers = [];
        $wrongAnswers = [];
        foreach ($qaa as $row) {
            $wrongAnswers[] = $this->getWrongAnswers($array, $row[$index[0]]);
            $questions[] = $row[$index[1]];
            $correctAnswers[] = $row[$index[2]];
        }

        return [
            'wrongAnswers' => $wrongAnswers,
            'questions' => $questions,
            'correctAnswers' => $correctAnswers
        ];
    }

    private function getIndex($russianQuestions)
    {
        if ($russianQuestions == true) {
            $index[] = 'word';
            $index[] = 'translation';
            $index[] = 'word';

            return $index;
        }
        $index[] = 'translation';
        $index[] = 'word';
        $index[] = 'translation';

        return $index;
    }

    private function getWrongAnswers($array, $question)
    {
        $quantity = count($array) - 1;
        $array_keys[0] = rand(0, $quantity);
        while ($array[$array_keys[0]] == $question) {
            $array_keys[0] = rand(0, $quantity);
        }

        $array_keys[1] = rand(0, $quantity);
        while ($array[$array_keys[1]] == $question OR $array_keys[1] == $array_keys[0]) {
            $array_keys[1] = rand(0, $quantity);
        }

        $array_keys[2] = rand(0, $quantity);
        while ($array[$array_keys[2]] == $question OR $array_keys[2] == $array_keys[0] OR $array_keys[2] == $array_keys[1]) {
            $array_keys[2] = rand(0, $quantity);
        }

        return [$array[$array_keys[0]], $array[$array_keys[1]], $array[$array_keys[2]]];
    }
}
