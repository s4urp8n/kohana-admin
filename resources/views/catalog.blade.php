@extends('layouts.app')

@section('content')
    <div class="page page--home">
        <div class="page-top">
            @include('parts/header')
        </div>
        <div class="page-center">
            <div class="page-container content">

                @include('parts/breads',['links'=>[
                    ['name'=>'Каталог' .(isset($currentCategory)?' - '.$currentCategory->category:''),],
                ]])

                <div class="catalog">

                    @include('parts/catalog-categories')

                    <div class="catalog-products">

                        <h1 class="h2">{{ $currentCategory->category }}</h1>

                        @include('parts/products-table',['products'=>$products])

                        @include('parts/form')

                    </div>
                </div>
            </div>
        </div>

        <div class="page-bottom">
            @include('parts/footer')
        </div>
    </div>
@endsection
