<?= View::factory('template', [
    'header'  => View::factory('parts/header'),
    'content' => View::factory('errors/error-content', [
        'title'   => ___('ОшибкаЗаголовок'),
        'content' => ___('ОшибкаТекст'),
    ]),
    'footer'  => View::factory('parts/footer'),
]) ?>