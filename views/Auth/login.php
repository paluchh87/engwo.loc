<div class="row justify-content-center align-items-center">
    <div class="card card-login mx-auto mt-5">
        <?php echo flash(); ?>

        <div class="card-header"><b>Вход:</b></div>
        <div class="card-body">
            <form action="/engwo/login" method="post">
                <div class="field">
                    <label class="label">Email</label>
                    <div>
                        <span class="icon"><i class="fas fa-envelope"></i></span>
                        <input class="input" type="email" name="email">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Пароль</label>
                    <div>
                        <span class="icon"><i class="fas fa-lock"></i></span>
                        <input class="input" type="password" name="password">
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary btn-block">Вход</button>
            </form>
            <div class="field">
                <br>
                <p>Забыли пароль? <br><b><a href="/engwo/recovery">Восстановление пароля</a></b></p>
            </div>
        </div>
    </div>
</div>
