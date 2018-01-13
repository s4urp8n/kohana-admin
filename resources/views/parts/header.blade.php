<div class="page-container header">

    <a href="/" class="header-logo">
        <img src="/assets/images/logo.svg" class="header-logo-img" alt="logo">
    </a>

    <form action="/search" method="get" class="header-search">
        <span class="ion-search header-search-input-icon"></span>
        <input name="search" type="search" class="header-search-input" value="{{ request('search') }}" placeholder="Поиск"/>
    </form>

    <div class="header-contacts">
        <a class="header-contacts-map">
            <span class="ion-location"></span>
            Краснодар, ул. Железнодорожная, д. 4, офис 9
        </a>
        <a class="header-contacts-phone" href="tel:+79130263009">
            +7 913 026 30 09
        </a>
        <a class="header-contacts-email" href="mailto:sibrodnic@mail.ru">
            sibrodnic@mail.ru
        </a>
    </div>

    <div class="header-menu">
        @foreach(\App\Config::getMenu() as $menuItem)
            <a href="{{ $menuItem['href'] }}"
               class="{{ getHtmlElementActiveClass(\App\Config::isUrlActive($menuItem['href']),'header-menu-item') }}">
                {{ $menuItem['name'] }}
            </a>
        @endforeach
    </div>

</div>