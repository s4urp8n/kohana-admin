<div class="authFormNew">
    <form role="form"
          action='<?php echo AdminHREF::getDefaultAdminRouteUri('auth'); ?>?ref=<?= urlencode(
              AdminHREF::getFullCurrentHREF()
          ) ?>'
          method="post">
        
        <?php
        if (!empty($embed))
        {
            ?>
            <div class="alert alert-info">
                Для оформления заказа войдите на сайт или зарегистрируйтесь
            </div>
            <?php
        }
        ?>
        
        <?php
        if (empty($embed))
        {
            ?>
            <div class="form-group">
                <h4 class="text-center">
                    <i class="fa fa-lock"></i>
                    Вход на сайт
                </h4>
            </div>
            <?php
        }
        ?>
        
        <?php
        if (!empty($error))
        {
            echo AdminHTML::renderMessage($error, 'danger');
        }
        ?>
        <div class="form-group">
            <label for="login" class="control-label">
                Имя пользователя:
            </label>
            
            <div>
                <input type="text"
                       name="login"
                       class="form-control"
                       id="login"
                       placeholder="Введите имя пользователя..."
                       value='<?= (empty($login)
                           ? ""
                           : $login) ?>'/>
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="control-label">
                Пароль:
            </label>
            
            <div>
                <input name='password'
                       type="password"
                       class="form-control"
                       id="password"
                       placeholder="Введите пароль..."
                       value='<?= (empty($password)
                           ? ""
                           : $password) ?>'/>
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input name='remember' <?= (empty($remember)
                        ? 'checked'
                        : '') ?>
                           type="checkbox">
                    Запомнить?
                </label>
            </div>
        </div>
        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-info btn-block">
                    Войти
                </button>
            </div>
        </div>
        <?php
        if (empty($embed))
        {
            ?>
            <div class="form-group">
                <div>
                    <a href="/" class="btn btn-link btn-block">
                        <i class="fa fa-external-link fa-flip-horizontal"></i>
                        Вернуться на главную
                    </a>
                </div>
            </div>
            <?php
        }
        ?>
    </form>
</div>
