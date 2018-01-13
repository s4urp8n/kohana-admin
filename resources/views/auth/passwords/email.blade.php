@extends('layouts.app')

@section('content')
    <div class="page page--home">
        <div class="page-top">
            @include('parts/header')
        </div>
        <div class="page-center">
            <div class="page-container content">

                @include('parts/breads',['links'=>[
                    ['name'=>'Вход',],
                ]])

                <h1 class="text-center">Вход</h1>

                <form class="form form--login" method="POST" action="{{ route('password.email') }}">

                    {{ csrf_field() }}

                    <label class="form__label">

                        Email

                        <input type="email" name="email"
                               value="{{ old('email') }}" required/>

                        @if ($errors->has('email'))
                            <span class="form__label__error">{{ $errors->first('email') }}</span>
                        @endif

                    </label>

                    <button type="submit" class="form__button">
                        Send Password Reset Link
                    </button>


                    <a class="form__link"
                       href="{{ route('login') }}">
                        Войти
                    </a>

                    <a class="form__link"
                       href="{{ route('register') }}">
                        Регистрация
                    </a>

                </form>


            </div>
        </div>
        <div class="page-bottom">
            @include('parts/footer')
        </div>
    </div>
@endsection
