@extends('layouts.app')

@section('content')
    <div class="page page--home">
        <div class="page-top">
            @include('parts/header')
        </div>
        <div class="page-center">
            <div class="page-container content">

                @include('parts/breads',['links'=>[
                    ['name'=>'Регистрация',],
                ]])

                <h1 class="text-center">Регистрация</h1>

                <form class="form form--login" method="POST" action="{{ route('register') }}">

                    {{ csrf_field() }}

                    <label class="form__label">

                        Имя

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}" required autofocus/>

                        @if ($errors->has('name'))
                            <span class="form__label__error">{{ $errors->first('name') }} </span>
                        @endif

                    </label>

                    <label class="form__label">

                        Email

                        <input type="email" name="email"
                               value="{{ old('email') }}" required/>

                        @if ($errors->has('email'))
                            <span class="form__label__error">{{ $errors->first('email') }}</span>
                        @endif

                    </label>


                    <label class="form__label">

                        Пароль

                        <input type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="form__label__error">{{ $errors->first('password') }}</span>
                        @endif

                    </label>

                    <label class="form__label">

                        Повторите пароль

                        <input type="password" name="password_confirmation" required>

                    </label>

                    <button type="submit" class="form__button">
                        Зарегистрироваться
                    </button>

                    <a class="form__link"
                       href="{{ route('login') }}">
                        Войти
                    </a>

                </form>


            </div>
        </div>
        <div class="page-bottom">
            @include('parts/footer')
        </div>
    </div>
@endsection