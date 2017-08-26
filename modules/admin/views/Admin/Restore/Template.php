<?= View::factory('Admin/authLogo') ?>

<div class="authFormNew">

    <?php
    if (empty($error) && !empty($_POST)) {
        ?>

        <form role="form" method="post">

            <?php
            if (!isset($embed)) {
                echo View::factory('Admin/authLangs');
            }
            ?>

            <?= AdminHTML::renderMessage(___('На Ваш почтовый ящик отправлен новый пароль. Используйте его для входа на сайт.'),
                                         'info') ?>

            <div class="form-group">
                <div>
                    <a href="/admin/auth" class="btn btn-link btn-block">
                        <i class="fa fa-external-link fa-flip-horizontal"></i>
                        <?= ___('ВойтиТекст') ?>
                    </a>
                </div>
            </div>

            <div class="form-group">
                <div>
                    <a href="/" class="btn btn-link btn-block">
                        <i class="fa fa-external-link fa-flip-horizontal"></i>
                        <?= ___('ВернутьсяНаГлавнуюТекст') ?>
                    </a>
                </div>
            </div>

        </form>

        <?php
    } else {
        ?>
        <form role="form" action='<?php echo AdminHREF::getDefaultAdminRouteUri('restore'); ?>' method="post">

            <?php
            if (!isset($embed)) {
                echo View::factory('Admin/authLangs');
            }
            ?>

            <div class="form-group">
                <h4 class="text-center">
                    <i class="fa fa-lock"></i>
                    <?= ___('ВосстановлениеПароляТекст') ?>
                </h4>
            </div>

            <?php
            if (!empty($error)) {
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
                           placeholder="<?= ___('ВведитеИмяПользователяТекст') ?>..."
                           value='<?= $email ?>'/>
                </div>
            </div>
            <div class="form-group">

                <label for="password" class="control-label">
                    <?= ___('ПроверочныйКод') ?>:
                </label>

                <div>
                    <?= Captcha::instance()
                               ->render() ?>
                    <input name='captcha'
                           type="text"
                           required
                           class="form-control"
                           placeholder="<?= ___('ВведитеПроверочныйКод') ?>..."
                    />
                </div>
            </div>
            <div class="form-group">
                <div>
                    <button type="submit" class="btn btn-info btn-block">
                        <?= ___('ВосстановитьПарольКнопка') ?>
                    </button>
                </div>
            </div>
            <div class="form-group">
                <div>
                    <a href="/admin/auth" class="btn btn-link btn-block">
                        <i class="fa fa-external-link fa-flip-horizontal"></i>
                        <?= ___('ВойтиТекст') ?>
                    </a>
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
                    <a href="/" class="btn btn-link btn-block">
                        <i class="fa fa-external-link fa-flip-horizontal"></i>
                        <?= ___('ВернутьсяНаГлавнуюТекст') ?>
                    </a>
                </div>
            </div>
        </form>
        <?php
    }
    ?>


</div>