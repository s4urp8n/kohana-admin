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

                <form class="form form--login" method="POST" action="{{ route('login') }}">

                    {{ csrf_field() }}

                    <label class="form__label">

                        Email

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus/>

                        @if ($errors->has('email'))
                            <span class="form__label__error">{{ $errors->first('email') }}</span>
                        @endif

                    </label>

                    <label class="form__label">

                        Пароль

                        <input type="password"
                               name="password"
                               value="{{ old('password') }}"
                               required
                               autofocus/>

                        @if ($errors->has('password'))
                            <span class="form__label__error">{{ $errors->first('password') }}</span>
                        @endif

                    </label>

                    <label class="form__label form__label--checkbox">
                        <input type="checkbox"
                               name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Запомнить
                    </label>

                    <button type="submit" class="form__button">
                        Войти
                    </button>

                    <a class="form__link"
                       href="{{ route('password.request') }}">
                        Забыли пароль?
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