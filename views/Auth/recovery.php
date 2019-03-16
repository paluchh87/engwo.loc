<div class="row justify-content-center align-items-center">
    <div class="card card-login mx-auto mt-5">
        <?php echo flash(); ?>

        <div class="card-header"><b>Восстановление пароля:</b></div>

        <div class="card-body">
            <form action="/engwo/recovery" method="post">

                <div class="field">
                    <label class="label">Email</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="email" name="email">
                        <span class="icon is-small is-left">
                      <i class="fas fa-envelope"></i>
                    </span>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary btn-block">Отправить</button>
            </form>

            <div class="field">
                <br>
                <p>Нет аккаунта? <b><a href="/engwo/register">Регистрация</a></b></p>
            </div>

        </div>
    </div>
</div>
