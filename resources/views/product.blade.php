@extends('layouts.app')

@section('content')
    <div class="page page--home">
        <div class="page-top">
            @include('parts/header')
        </div>
        <div class="page-center">
            <div class="page-container content">

                @include('parts/breads',['links'=>[
                  [
                    'name'=>'Каталог - ' .$product->getCategory()->category,
                    'href'=>$product->getCategory()->getHref()
                  ],
                  [
                    'name'=>$product->name,
                  ],
                ]])

                <div class="catalog">

                    @include('parts/catalog-categories',['currentCategory'=>$product->getCategory()])

                    <div class="catalog-products">

                        <h1 class="h2">{{ $product->name }}</h1>

                        <table class="catalog-products-table">
                            <tr>
                                <th>Вес</th>
                                <th>Единица измерения</th>
                                <th>Цена с НДС, руб</th>
                            </tr>
                            <tr>
                                <td>{{ $product->weight }}</td>
                                <td>{{ $product->unit }}</td>
                                <td>от {{ $product->price }}</td>
                            </tr>
                        </table>

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
