<div class="authFormNew">
    <form role="form" action='<?php echo AdminHREF::getDefaultAdminRouteUri('register'); ?>' method="post">


        <?php
        if (!isset($embed)) {
            echo View::factory('Admin/authLangs');
        }
        ?>

        <div class="form-group">
            <h4 class="text-center">
                <i class="fa fa-lock"></i>
                <?= ___('РегистрацияТекст') ?>
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
                <?= ___('ПарольТекст') ?>:
            </label>

            <div>
                <input name='password'
                       type="password"
                       required
                       class="form-control"
                       id="password"
                       placeholder="<?= ___('ВведитеПарольТекст') ?>..."
                       value='<?= $password; ?>'/>
            </div>
        </div>

        <div class="form-group">

            <label for="phone" class="control-label">
                <?= ___('ТелефонТекст') ?>:
            </label>

            <div>
                <input name='phone'
                       type="text"
                       required
                       class="form-control"
                       id="phone"
                       placeholder="<?= ___('ВведитеТелефонТекст') ?>..."
                       value='<?= $phone; ?>'/>
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
                    <?= ___('ЗарегистрироватьсяКнопка') ?>
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
                <a href="/admin/restore" class="btn btn-link btn-block">
                    <i class="fa fa-external-link fa-flip-horizontal"></i>
                    <?= ___('ВосстановитьПароль') ?>
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
</div>