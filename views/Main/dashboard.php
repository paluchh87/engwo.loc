<div class="row justify-content-center align-items-center">
    <?php
    $count = 0;

    if (isset($lessons[0]['lesson'])) {
        foreach ($lessons as $myrow) {
            $count = $count + $myrow['count'];
        }
    }
    ?>
    <?php if ($count > 4): ?>
        <div class="col-md-auto">
            <div class="alert alert-primary" role="alert" style="height: 240px; width: 360px;">

                <form action="/engwo/testing" method="post">
                    <label>Кол-во слов
                        <input type="text" name="countQuestions" id="countQuestions" size="1" value="20">
                    </label><br>
                    Язык вопросов:<br>
                    <label>Русский
                        <input type="checkbox" name="russianQuestions" value="1">
                    </label><br>

                    <label>Уроки:<br>
                        <?php
                        $i = 1;
                        foreach ($lessons as $myrow) {
                            echo '<input type="checkbox" name="option[' . $i . ']" value="' . $myrow['lesson'] . '">' . $myrow['lesson'];
                            $i++;
                        }
                        ?>
                    </label><br>
                    <br>
                    <input type="submit" name="submit" id="submit" class="btn btn-danger btn-block"" value="START">
                </form>
            </div>
        </div>

        <div class="col-md-auto">
            <div class="alert alert-primary" role="alert" style="height: 240px; width: 360px;">
                <?php
                echo $_SESSION['auth_username'] . ' ';

                if (isset($achievements)) {
                    foreach ($achievements as $achievement) {
                        $star = ($achievement) ? 'Star_yel.png' : 'Star_bl.png';
                        echo '<img src="/public/' . $star . '" width="18" height="18">';
                    }
                }

                ?>
                <br> <br>
                <table class="table table-sm table-hover table-bordered">
                    <thead>
                    <tr class="bg-info">
                        <th scope="col">Урок</th>
                        <th scope="col">Кол-во слов</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($lessons as $myrow) {
                        echo '<tr class="table-light"><td>' . $myrow['lesson'] . '</td><td>' . $myrow['count'] . '</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php else: ?>

        <div class="col-md-auto">
            <div class="alert alert-primary" role="alert" style="height: 200px; width: 360px;">
                User: <?php echo $_SESSION['auth_username']; ?>
                <br>
                Введите как минимум 5 слов
            </div>
        </div>

    <?php endif; ?>
</div>
<?php if ($count > 4): ?>
    <div class="row justify-content-center align-items-center">
        <div class="col-md-auto">
            <h3>Последние результаты:</h3>

            <?php

            echo 'Всего слов: ' . (isset($lastResult['count_words']) ? $lastResult['count_words'] : 0) . '<br>';
            echo 'Правильных ответов: ' . (isset($lastResult['count_correct_answers']) ? $lastResult['count_correct_answers'] : 0) . '<br>';
            $nepr = $lastResult['count_words'] - $lastResult['count_correct_answers'];
            echo 'Неправильных ответов: ' . $nepr . '<br>';
            //$diff = strtotime($myrow['date_end']) - strtotime($myrow['date_start']);
            echo 'Время выполнения: ' . (isset($lastResult['time']) ? $lastResult['time'] : 0) . '<br><br>';

            ?>
        </div>
    </div>
    <div class="row justify-content-center align-items-center">
        <div class="col-md-auto">
            <?php
            echo '<h3>Результаты за все время:</h3>';
            ?>
        </div>
    </div>
    <div class="row justify-content-center align-items-center">
        <div class="col-md-auto">

            <?php
            echo 'Всего слов: ' . (isset($totalResult['count_words']) ? $totalResult['count_words'] : 0) . '<br>';
            echo 'Правильных ответов: ' . (isset($totalResult['count_correct_answers']) ? $totalResult['count_correct_answers'] : 0) . '<br>';
            $nepr = $totalResult['count_words'] - $totalResult['count_correct_answers'];
            echo 'Неправильных ответов: ' . $nepr . '<br>';
            $min = (int)($totalResult['time'] / 60);
            $sec = $totalResult['time'] - $min * 60;

            echo 'Время выполнения: ' . $min . ' мин. и ' . $sec . ' сек.<br>';
            ?>

        </div>

        <div class="col-md-auto">
            <div id="chartContainerLeftALL" style="height: 260px; width: 360px;"></div>
        </div>

    </div>

    <div class="row justify-content-center align-items-center">
        <div class="col-md-auto">
            <a class="btn btn-outline-primary" href="/engwo/statistics" role="button">подробнее</a>
        </div>

    </div>

<?php endif; ?>

<script type="text/javascript">
    window.onload = function () {
        var chart = new CanvasJS.Chart("chartContainerLeftALL", {
            theme: "theme2",
            title: {
                text: ""
            },
            data: [
                {
                    type: "pie",
                    showInLegend: false,
                    toolTipContent: "{name}: {y} - #percent %",
                    indexLabelPlacement: "auto",
                    indexLabel: "{name}-#percent%",
                    dataPoints: [
                        {
                            y: <?php echo(isset($totalResult['count_correct_answers']) ? $totalResult['count_correct_answers'] : 0); ?>,
                            name: "Правильных ответов"
                        }, {y: <?php echo $nepr; ?>, name: "Неправильных ответов"}
                    ]

                }
            ]
        });

        chart.render();
    }
</script>
<script type="text/javascript" src="/public/scripts/canvasjs.min.js"></script>