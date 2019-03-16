<div class="row justify-content-center align-items-center">
    <?php if (isset($post)): ?>
        <div class="card mb-6">
            <div class="card-header">Редактировать слово</div>
            <div class="card-body">
                <div class="col-auto">
                    <?php echo flash(); ?>
                    <form action="/engwo/edit" enctype="multipart/form-data" method="post">

                        <label>Английское слово</label>
                        <input class="form-control" type="text" name="word" value="<?php echo $post['word']; ?>">

                        <label>Перевод</label>
                        <input class="form-control" type="text" name="translation"
                               value="<?php echo $post['translation']; ?>">

                        <label>Урок</label>
                        <input class="form-control" type="text" name="lesson" value="<?php echo $post['lesson']; ?>">
                        <br>
                        <input type="hidden" name="id" id="id" value="<?php echo $post['id']; ?>">
                        <button type="submit" class="btn btn-primary btn-block">Исправить</button>
                    </form>

                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
