<form action="/email" method="post" class="form form--email">

    <h2 class="text-center">Напишите нам, если у Вас есть вопросы</h2>

    {{ csrf_field() }}

    <label class="form__label">
        Телефон
        <input type="text" required name="phone" value="{{ old('phone') }}">
    </label>

    <label class="form__label">
        Имя
        <input type="text" required name="name" value="{{ old('name') }}">
    </label>

    <label class="form__label">
        Сообщение
        <textarea required name="message">{{ old('message') }}</textarea>
    </label>

    <input type="submit" class="form__button" value="Отправить">

</form>