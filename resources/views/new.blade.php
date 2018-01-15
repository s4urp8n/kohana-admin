@extends('layouts.app')

@section('content')
    <div class="page page--home">
        <div class="page-top">
            @include('parts/header')
        </div>
        <div class="page-center">
            <div class="page-container content">

                <div class="breads">
                    <a class="breads-link" href="/">
                        <span class="ion-home"></span>
                    </a>
                    <span class="ion-chevron-right breads-separator"></span>
                    <a href="news.html" class="breads-link">Новости</a>
                    <span class="ion-chevron-right breads-separator"></span>
                    <span class="breads-current">Теперь у нас еще больше рельс!</span>
                </div>

                <div class="news-content-date">
                    21.11.2017
                </div>

                <h1>Теперь у нас еще больше рельс!</h1>

                <div>

                    <p style="background-image: url('/assets/images/news/1.jpg');" class="news-content-image"></p>

                    <div class="news-content-content">

                        <p>
                            Промоакция изменяет креативный потребительский рынок. Взаимодействие корпорации и
                            клиента, конечно,
                            категорически упорядочивает культурный портрет потребителя, учитывая современные тенденции.
                            Ребрендинг,
                            согласно Ф.Котлеру, сфокусирован.
                        </p>
                        <p>
                            Потребление тормозит фирменный стиль. SWOT-анализ притягивает популярный анализ зарубежного
                            опыта.
                        </p>
                        <p>
                            Позиционирование на рынке стабилизирует поведенческий таргетинг. Презентация, конечно,
                            подсознательно
                            оправдывает тактический бизнес-план.
                        </p>
                        <p>
                            Нишевый проект охватывает культурный отраслевой стандарт. Рыночная информация, пренебрегая
                            деталями,
                            трансформирует коллективный медиамикс, осознав маркетинг как часть производства. К тому же
                            бюджет на
                            размещение недостаточно создает медиамикс. Ретроконверсия национального наследия,
                            пренебрегая
                            деталями,
                            уравновешивает бюджет на размещение. По мнению ведущих маркетологов, маркетинговая
                            активность
                            методически усиливает традиционный канал.
                        </p>
                        <p>
                            Имиджевая реклама без оглядки на авторитеты охватывает экспериментальный медиамикс.
                            Пресс-клиппинг
                            допускает метод изучения рынка, повышая конкуренцию. Стиль менеджмента, как следует из
                            вышесказанного,
                            неестественно стабилизирует рекламный бриф. Поэтому побочный PR-эффект специфицирует
                            социометрический
                            отраслевой стандарт. Создание приверженного покупателя притягивает выставочный стенд.
                        </p>
                        <p>
                            До недавнего времени считалось, что бренд регулярно специфицирует институциональный BTL. Еще
                            Траут
                            показал, что анализ зарубежного опыта развивает SWOT-анализ. Поэтому высокая информативность
                            существенно
                            развивает традиционный канал, расширяя долю рынка.
                        </p>

                        <p>
                            VIP-мероприятие как всегда непредсказуемо. Потребление восстанавливает из ряда вон выходящий
                            комплексный
                            анализ ситуации, повышая конкуренцию. Организация практического взаимодействия индуцирует
                            медиавес.
                            А вот по мнению аналитиков побочный PR-эффект основан на тщательном анализе данных. Целевой
                            трафик
                            транслирует ребрендинг. Сущность и концепция маркетинговой программы порождена временем.
                        </p>

                    </div>

                    <div class="lightgallery">

                        <a href="http://www.youtube.com/embed/eJoxbpNwAI8" rel="video"
                           style="background-image: url('http://img.youtube.com/vi/eJoxbpNwAI8/0.jpg')">
                            <img title='Тут будет название 0' src="http://img.youtube.com/vi/eJoxbpNwAI8/0.jpg"/>
                        </a>

                        <a href="/assets/images/photos/1.jpg"
                           style="background-image: url('/assets/images/photos/1.jpg')">
                            <img title='Тут будет название 1' src="/assets/images/photos/1.jpg"/>
                        </a>

                        <a href="/assets/images/photos/2.jpg"
                           style="background-image: url('/assets/images/photos/2.jpg')">
                            <img title='Тут будет название 2' src="/assets/images/photos/2.jpg"/>
                        </a>

                        <a href="/assets/images/photos/3.jpg"
                           style="background-image: url('/assets/images/photos/3.jpg')">
                            <img title='Тут будет название 3' src="/assets/images/photos/3.jpg"/>
                        </a>

                        <a href="/assets/images/photos/4.jpg"
                           style="background-image: url('/assets/images/photos/4.jpg')">
                            <img title='Тут будет название 4' src="/assets/images/photos/4.jpg"/>
                        </a>

                        <a href="/assets/images/photos/5.jpg"
                           style="background-image: url('/assets/images/photos/5.jpg')">
                            <img title='Тут будет название 5' src="/assets/images/photos/5.jpg"/>
                        </a>

                    </div>
                </div>

            </div>
        </div>
        <div class="page-bottom">
            @include('parts/footer')
        </div>
    </div>
@endsection