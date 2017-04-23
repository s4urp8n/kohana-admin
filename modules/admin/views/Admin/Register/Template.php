<div class="authFormNew">
    <form role="form" action='<?php echo AdminHREF::getDefaultAdminRouteUri('register'); ?>' method="post">
        <div class="form-group">
            <h4 class="text-center">
                <i class="fa fa-lock"></i>
                Регистрация
            </h4>
        </div>
        <?php
        if (!empty($error))
        {
            echo AdminHTML::renderMessage($error, 'danger');
        }
        ?>
        <div class="form-group">
            
            <label for="email" class="control-label">
                Email:
            </label>
            
            <div>
                <input type="email"
                       name="email"
                       required
                       class="form-control"
                       id="email"
                       placeholder="Введите имя пользователя..."
                       value='<?= $email ?>'/>
            </div>
        </div>
        <div class="form-group">
            
            <label for="password" class="control-label">
                Пароль:
            </label>
            
            <div>
                <input name='password'
                       type="password"
                       required
                       class="form-control"
                       id="password"
                       placeholder="Введите пароль..."
                       value='<?= $password; ?>'/>
            </div>
        </div>
        <div class="form-group">
            
            <label for="password" class="control-label">
                Проверочный код с картинки:
            </label>
            
            <div>
                <?= Captcha::instance()
                           ->render() ?>
                <input name='captcha'
                       type="text"
                       required
                       class="form-control"
                       placeholder="Введите код с картинки..."
                />
            </div>
        </div>
        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-info btn-block">
                    Зарегистрироваться
                </button>
            </div>
        </div>
        <div class="form-group">
            <div>
                <a href="/" class="btn btn-link btn-block">
                    <i class="fa fa-external-link fa-flip-horizontal"></i>
                    Вернуться на главную
                </a>
            </div>
        </div>
    </form>
</div>