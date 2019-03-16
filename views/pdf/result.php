<?php
echo 'РЕЗУЛЬТАТЫ ' . $_SESSION['auth_username'] . '<br>';
echo 'Всего слов: ' . (isset($lastResult['count_words']) ? $lastResult['count_words'] : 0) . '<br>';
echo 'Правильных ответов: ' . (isset($lastResult['count_correct_answers']) ? $lastResult['count_correct_answers'] : 0) . '<br>';
$nepr = $lastResult['count_words'] - $lastResult['count_correct_answers'];
echo 'Неправильных ответов: ' . $nepr . '<br>';
//$diff = strtotime($myrow['date_end']) - strtotime($myrow['date_start']);
echo 'Время выполнения: ' . (isset($lastResult['time']) ? $lastResult['time'] : 0) . '<br><br>';

echo 'Всего слов: ' . (isset($totalResult['count_words']) ? $totalResult['count_words'] : 0) . '<br>';
echo 'Правильных ответов: ' . (isset($totalResult['count_correct_answers']) ? $totalResult['count_correct_answers'] : 0) . '<br>';
$nepr = $totalResult['count_words'] - $totalResult['count_correct_answers'];
echo 'Неправильных ответов: ' . $nepr . '<br>';
$min = (int)($totalResult['time'] / 60);
$sec = $totalResult['time'] - $min * 60;

echo 'Время выполнения: ' . $min . ' мин. и ' . $sec . ' сек.<br>';
echo '<br>' . 'Слова в словаре:' . '<br><br>';
?>

<table class="table table-sm table-hover table-bordered">
    <thead>
    <tr class="bg-info">
        <th scope="col">Слово</th>
        <th scope="col">Перевод</th>
        <th scope="col">Урок</th>
        <th scope="col">Дата</th>
    </tr>
    </thead>
    <tbody>
    <?php

    foreach ($allDictionary as $row) {
        echo '<tr class="table-light"><td>' . $row['word'] . ' </td><td> ' . $row['translation'] . ' </td><td> ' . $row['lesson'] . ' </td><td> ' . $row['date'] . '</td></tr>';
    }

    ?>
    </tbody>
</table>




