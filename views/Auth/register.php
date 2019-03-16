<div class="row justify-content-center align-items-center">
    <div class="card card-login mx-auto mt-5">
        <?php echo flash(); ?>
        <div class="card-header"><b>Регистрация:</b></div>
        <div class="card-body">
            <form action="/engwo/register" method="post">
                <div class="field">
                    <label class="label">Email</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="email" name="email">  <!-- is-danger -->
                        <span class="icon is-small is-left">
                      <i class="fas fa-envelope"></i>
                    </span>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Логин</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="text" name="login">
                        <span class="icon is-small is-left">
                      <i class="fas fa-user"></i>
                    </span>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Пароль</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="password" name="password">
                        <span class="icon is-small is-left">
                      <i class="fas fa-lock"></i>
                    </span>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Подтвердите пароль</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="password" name="password_confirmation">
                        <span class="icon is-small is-left">
                      <i class="fas fa-lock"></i>
                    </span>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary btn-block">Зарегистрировать</button>
            </form>

            <div class="field">
                <br>
                <p>Уже зарегистрированы? <b><a href="/engwo/login">Войти</a></b></p>
            </div>
        </div>
    </div>
</div>
