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

                        <h1 class="h2">Характеристики</h1>

                        <table class="catalog-products-table">
                            <tr>
                                <th>Наименование</th>
                                <th>Длина, м</th>
                                <th>ГОСТ/ТУ</th>
                                <th>Вес 1 шт, т</th>
                                <th>Вес 1 м, кг</th>
                                <th>Схема</th>
                            </tr>

                            @foreach(\App\Specs::orderBy('name')->get() as $spec)
                                <tr>
                                    <td>{{ $spec->name }}</td>
                                    <td>{{ $spec->length }}</td>
                                    <td>{{ $spec->gost }}</td>
                                    <td>{{ $spec->weightT }}</td>
                                    <td>{{ $spec->weightM }}</td>
                                    <td>
                                        @if(!empty($spec->img))
                                            <div class="lightgallery">
                                                <a target="_blank" class="catalog-products-table-aimg"
                                                   href="/assets/images/specs/{{ $spec->img }}"
                                                   style="background-image: url('/assets/images/specs/{{ $spec->img }}')">
                                                    <img src="/assets/images/specs/{{ $spec->img }}"/>
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>

                </div>
            </div>
        </div>
        <div class="page-bottom">
            @include('parts/footer')
        </div>
    </div>
@endsection
