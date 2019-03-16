<div class="row justify-content-center align-items-center">
    <div class="card card-login mx-auto mt-5">
        <?php echo flash(); ?>

        <div class="card-header"><b>Восстановление пароля:</b></div>
        <div class="card-body">
            <form action="/engwo/password" method="post">
                <input type="hidden" name="selector" value="<?= $selector; ?>">
                <input type="hidden" name="token" value="<?= $token; ?>">

                <div class="field">
                    <label class="label">Новый пароль</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="password" name="password">
                        <span class="icon is-small is-left">
                      <i class="fas fa-lock"></i>
                    </span>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary btn-block">Отправить</button>
            </form>

        </div>
    </div>
</div>

