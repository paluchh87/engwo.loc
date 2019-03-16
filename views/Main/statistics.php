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
        <a class="btn btn-outline-primary"
           href="<?php echo '/public/pdf_results/result_' . $_SESSION['auth_username'] . '.pdf'; ?>"
           role="button">PDF файл</a>
    </div>
</div>
<div class="row justify-content-center align-items-center">
    <div class="col-md-auto">
        <br>
        <h3>Результаты за все время:</h3>
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
        <div id="chartContainerLeftALL" style="height: 240px; width: 360px;"></div>
    </div>

</div>
<div class="row justify-content-center align-items-center">
    <div class="col-md-auto">
        <h3>Результаты последних 20 попыток:</h3>
    </div>
</div>
<div class="row justify-content-center align-items-center">
    <div class="col-md-auto">
        <div class="container" id="chartContainer" style="height: 300px; width: 700px;"></div>
    </div>
</div>

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

        var chart2 = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: false,
            title: {
                text: ""
            },
            axisY: {
                title: "Кол-во",
                titleFontSize: 18,
                labelFontSize: 13
            },
            axisX: {
                labelFontSize: 13
            },
            toolTip: {
                shared: true
            },
            legend: {
                cursor: "pointer",
            },
            data: [
                {
                    type: "spline",
                    name: "Всего слов",
                    color: "navy",
                    showInLegend: true,
                    dataPoints: [
                        <?php echo $dynamics['words']; ?>
                    ]
                },
                {
                    type: "spline",
                    name: "Правильных ответов",
                    color: "green",
                    showInLegend: true,
                    dataPoints: [
                        <?php echo $dynamics['correctAnswers']; ?>
                    ]
                },
                {
                    type: "spline",
                    name: "Неправильных ответов",
                    color: "red",
                    showInLegend: true,
                    dataPoints: [
                        <?php echo $dynamics['incorrectAnswers']; ?>
                    ]
                }
            ]
        });

        chart.render();
        chart2.render();
    }
</script>
<script type="text/javascript" src="/public/scripts/canvasjs.min.js"></script>
