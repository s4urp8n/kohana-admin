<?php

$user = Auth::instance()
            ->get_user();

$profileInformation = [
    ___('ПрофильEmail')   => $user->email,
    ___('ПрофильТелефон') => $user->phone,
];

?>


<h3><?= ___('ПрофильИнформация') ?></h3>

<table class="profile-table">
    <?php
    foreach ($profileInformation as $informationKey => $informationValue) {

        ?>
        <tr>
            <td><?= $informationKey ?></td>
            <td><?= $informationValue ?></td>
        </tr>
        <?php

    }
    ?>
</table>

<br>
<br>

<h3><?= ___('ПрофильСменитьПарольТекст') ?></h3>

<form action="/change-pass" method="post">

    <?php

    if (!empty($_GET['error'])) {
        ?>
        <div class="alert alert-error">
            <?= ___('ПарольНеБылИзмененПотомуЧтоПроизошлаОшибка') ?>
        </div>
        <?php
    }

    if (!empty($_GET['success'])) {
        ?>
        <div class="alert alert-info">
            <?= ___('ПарольУспешноИзменен') ?>
        </div>
        <?php
    }

    ?>

    <input type="password" required name="password"/>

    <input type="submit" value="<?= ___('ПрофильСменитьПарольКнопка') ?>">

    <input type="hidden" name="ref" value="<?= AdminHREF::getFullCurrentHREF(['success', 'error']) ?>">

</form>
