@extends('layouts.app')

@section('content')
    <div class="page page--home">
        <div class="page-top">
            @include('parts/header')
        </div>
        <div class="page-center">
            <div class="page-container content">

                @include('parts/breads',['links'=>[
                   ['name'=>'Поиск'],
               ]])

                <div>
                    @if($products)

                        <h2>Результаты:</h2>

                        @include('parts/products-table',['products'=>$products])

                    @else

                        <h2>По запросу ничего не нашлось или запрос пустой</h2>

                    @endif
                </div>

            </div>
        </div>
        <div class="page-bottom">
            @include('parts/footer')
        </div>
    </div>
@endsection
