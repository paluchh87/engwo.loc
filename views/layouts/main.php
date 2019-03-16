<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $title; ?></title>

    <link href="/public/styles/style.css?<?php echo time(); ?>" rel="stylesheet" type="text/css">
    <link href="/public/styles/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

    <script src="/public/scripts/jquery.js"></script>
    <script src="/public/scripts/ajaxwords.js?<?php echo time(); ?>"></script>
</head>

<body>

<div class="container-fluid">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-auto">
            <h3>English Words</h3>
        </div>
    </div>
    <div class="row justify-content-center align-items-center">
        <div class="col-md-auto">
            <a class="btn btn-outline-primary" href="/engwo" role="button">Главная</a>
            <?php if (isset($_SESSION['auth_username'])): ?>
                <a class="btn btn-outline-primary" href="/engwo/dashboard" role="button">Dashboard</a>
                <a class="btn btn-outline-primary" href="/engwo/add" role="button">Добавить слова</a>
                <a class="btn btn-outline-primary" href="/engwo/words" role="button">Список слов</a>
                <a class="btn btn-outline-primary" href="/engwo/ajax" role="button">Список слов (ajax)</a>
                <a class="btn btn-outline-primary" href="/engwo/login" role="button">Выйти</a>
            <?php else: ?>
                <a class="btn btn-outline-primary" href="/engwo/login" role="button">Войти</a>
                <a class="btn btn-outline-primary" href="/engwo/register" role="button">Регистрация</a>
            <?php endif; ?>

            <br><br>
        </div>
    </div>

    <?php echo $content; ?>

</div>

</body>
</html>

