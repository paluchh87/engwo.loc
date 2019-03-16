<?php

namespace lib;

class Checker
{
    public static function checkAddWord($lastId)
    {
        if ($lastId > 0) {
            flash()->success(['Слово добавлено']);

            return true;
        }
        flash()->error(['ОШИБКА: добавления']);

        return false;
    }

    public static function checkEditWord($result)
    {
        if ($result === true) {
            flash()->success(['Сохранено']);

            return true;
        }
        flash()->error(['Ошибка сохранения']);

        return false;
    }

    public static function checkDeleteWord($result)
    {
        if ($result === true) {
            flash()->success(['Удалено']);

            return true;
        }
        flash()->error(['ОШИБКА: удаления']);

        return false;
    }
}
