<div class="authFormNew">
    <form role="form"
          action='<?php echo AdminHREF::getDefaultAdminRouteUri('auth'); ?>?ref=<?= urlencode(
              AdminHREF::getFullCurrentHREF()
          ) ?>'
          method="post">

        <?php
        if (!isset($embed)) {
            echo View::factory('Admin/authLangs');
        }
        ?>


        <?php
        if (!empty($embed)) {
            ?>
            <div class="alert alert-info">
                <?= ___('ДляОформленияЗаказаВойдитеИлиЗарегистрируйтесь') ?>
            </div>
            <?php
        }
        ?>

        <?php
        if (empty($embed)) {
            ?>
            <div class="form-group">
                <h4 class="text-center">
                    <i class="fa fa-lock"></i>
                    <?= ___('ВходНаСайтТекст') ?>
                </h4>
            </div>
            <?php
        }
        ?>

        <?php
        if (!empty($error)) {
            echo AdminHTML::renderMessage($error, 'danger');
        }
        ?>
        <div class="form-group">
            <label for="login" class="control-label">
                <?= ___('ИмяПользователяТекст') ?>:
            </label>

            <div>
                <input type="text"
                       name="login"
                       class="form-control"
                       id="login"
                       placeholder="<?= ___('ВведитеИмяПользователяТекст') ?>..."
                       value='<?= (empty($login)
                           ? ""
                           : $login) ?>'/>
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="control-label">
                <?= ___('ПарольТекст') ?>:
            </label>

            <div>
                <input name='password'
                       type="password"
                       class="form-control"
                       id="password"
                       placeholder="<?= ___('ВведитеПарольТекст') ?>..."
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
                    <?= ___('ЗапомнитьМеня') ?>?
                </label>
            </div>
        </div>
        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-info btn-block">
                    <?= ___('ВойтиТекст') ?>
                </button>
            </div>
        </div>
        <div class="form-group">
            <div>
                <a href="/admin/register" class="btn btn-link btn-block">
                    <i class="fa fa-external-link fa-flip-horizontal"></i>
                    <?= ___('РегистрацияТекст') ?>
                </a>
            </div>
        </div>

        <div class="form-group">
            <div>
                <a href="/admin/restore" class="btn btn-link btn-block">
                    <i class="fa fa-external-link fa-flip-horizontal"></i>
                    <?= ___('ВосстановитьПароль') ?>
                </a>
            </div>
        </div>

        <?php
        if (empty($embed)) {
            ?>
            <div class="form-group">
                <div>
                    <a href="/" class="btn btn-link btn-block">
                        <i class="fa fa-external-link fa-flip-horizontal"></i>
                        <?= ___('ВернутьсяНаГлавнуюТекст') ?>
                    </a>
                </div>
            </div>
            <?php
        }
        ?>
    </form>
</div>
