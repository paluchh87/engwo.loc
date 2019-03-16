<div class="row justify-content-center align-items-center">
    <?php if (isset($words)): ?>
        <div class="card mb-6">
            <?php echo flash(); ?>
            <div class="card-header">Список слов</div>
            <div class="card-body">
                <div class="col-auto">
                    <table class="table table-sm table-hover table-bordered">
                        <thead>
                        <tr class="bg-info">
                            <th>Word</th>
                            <th>Перевод</th>
                            <th>Урок</th>
                            <th>Редактировать</th>
                            <th>Удалить</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        foreach ($words as $myrow) {
                            echo '<tr class="table-light"><td>' . $myrow['word'] . '</td><td>' . $myrow['translation'] . '</td><td>' . $myrow['lesson'] . '</td><td><a href = "/engwo/edit/' . $myrow['id'] . '" class = "btn btn-primary">Редактировать</a></td><td><a href = "/engwo/delete/' . $myrow['id'] . '" class = "btn btn-danger">Удалить</a></td></tr>';
                        }

                        ?>
                        </tbody>
                    </table>
                    <div class="clearfix">
                        <?php if (isset($pagination)): ?>
                            <?php echo $pagination; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
