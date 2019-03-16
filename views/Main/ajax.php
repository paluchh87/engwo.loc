<div class="row justify-content-center align-items-center">
    <?php if (isset($words)): ?>
        <div class="container col-md-7">

            <div class="card mb-6">
                <?php echo flash(); ?>
                <div class="card-header">Список слов</div>

                <div class="card-body">
                    <form class="form-inline" method="POST" action="/engwo/lazy">
                        <input type="text" class="form-control col-2" name="word" placeholder="Word">
                        <input type="text" class="form-control col-2" name="translation" placeholder="Перевод">
                        <input type="text" class="form-control col-2" name="lesson" placeholder="Урок">
                        <button type="submit" class="btn btn-primary col-2" id="button_search">Search</button>
                    </form>
                </div>

                <div class="lazy-employee-list">
                    <div class="lazy-employee-item bg-white rounded shadow">
                        <a href="#" class="btn btn-outline-info lazy-employee-expand">+10 строк</a>
                        <a href="#" class="btn btn-outline-info lazy-employee-back">-10 строк</a>
                        <a href="#" class="btn btn-outline-info lazy-employee-next">Next</a>
                        <a href="#" class="btn btn-outline-info lazy-employee-return">Back</a>
                        <div class="btn btn-outline-info active" id="page">1 page</div>
                        <div class="btn btn-outline-info active" id="pages">10</div>
                    </div>
                </div>
                <br>
            </div>
        </div>

        <div class="container col-md-7">

            <div class="row">
                <div class="col-md-12 col-xs-12 employees-columns">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-secondary employees-list-item employees-navbar">
                            <div data-name="id" class="employee-item-id d-inline-block item-order">ID</div>
                            <div data-name="word" class="employee-item-word d-inline-block item-order">Word</div>
                            <div data-name="translation" class="employee-item-translation d-inline-block item-order">
                                Перевод
                            </div>
                            <div data-name="lesson" class="employee-item-lesson d-inline-block item-order">Урок</div>
                            <div data-name="edit" class="employee-item-edit d-inline-block">Редактировать</div>
                            <div data-name="delete" class="employee-item-employment-delete d-inline-block">Удалить</div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="employees-list-block">
                <div class="row">
                    <div class="col-md-12 col-xs-12 employees-list">
                        <ul class="list-group">
                            <?php foreach ($words as $word): ?>
                                <li class="list-group-item list-group-item-action employees-list-item"
                                    data-employee-id="<?php echo $word['id']; ?>">
                                    <div class="employee-item-id d-inline-block"><?php echo $word['id']; ?></div>
                                    <div class="employee-item-word d-inline-block"><?php echo $word['word']; ?></div>
                                    <div class="employee-item-translation d-inline-block"><?php echo $word['translation']; ?></div>
                                    <div class="employee-item-lesson d-inline-block"><?php echo $word['lesson']; ?></div>
                                    <div class="employee-item-edit d-inline-block"><a
                                                href="/engwo/edit/' . <?php echo $word['id']; ?> . '"
                                                class="btn btn-primary">Редактировать</a></div>
                                    <div class="employee-item-employment-delete d-inline-block"><a
                                                href="/engwo/delete/' . <?php echo $word['id']; ?> . '"
                                                class="btn btn-danger">Удалить</a></div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    <?php endif; ?>

</div>

