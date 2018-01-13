@extends('layouts.app')

@section('content')
    <div class="page page--home">
        <div class="page-top">
            @include('parts/header')
        </div>
        <div class="page-center page-description">
            <div class="page-container description animated fadeIn">

                <h1 class="description-caption">
                    Мы продаем
                    <a class="description-link" href="/catalog.html">рельсы,</a>
                </h1>
                <p class="description-text">
                    шпалы, брус, стрелочные переводы. Круглосуточно. РФ и зарубежье.
                </p>

                <?php
                $categories = [
                    'Рельсы' => 'relsy.png',
                    'Шпалы'  => 'shpala.png',
                    'Брус'   => 'brus.png',
                    'Метизы' => 'kostyl.png',
                ];
                ?>

                <div class="description-choices">
                    <?php

                    $index = 1;

                    foreach ($categories as $homeCategory=>$image) {

                    $category = \App\ProductsCategories::where('category', $homeCategory)
                                                       ->first();

                    if($category){
                    ?>

                    <a href="<?=$category->getHref()?>"
                       class="description-choice animated fadeInDown delay<?=$index++?>">
                        <img src="/assets/images/choiсes/<?=$image?>" alt=""
                             class="description-choice-img"/>
                        <span class="description-choice-text">
                        <?=$homeCategory?>
                        </span>
                    </a>

                    <?php
                    }
                    }
                    ?>
                </div>

            </div>
        </div>
        <div class="page-bottom">
            @include('parts/footer')
        </div>
    </div>
@endsection
