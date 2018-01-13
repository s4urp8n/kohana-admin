<div class="page-container footer">

    <div class="footer-social">

        @foreach(\App\Config::getMenu() as $menuItem)
            <a href="{{ $menuItem['href'] }}"
               @if(\App\Config::isUrlActive($menuItem['href']))
               class="footer-social-link  footer-social-link--active "
               @else
               class="footer-social-link"
                    @endif
            >
                {{ $menuItem['name'] }}
            </a>
        @endforeach

        <a download href="/assets/files/map.dotx" target="_blank" class="footer-social-link">
            Карта предприятия <i class="la la-download"></i>
        </a>

        <a download href="/assets/files/requisites.dotx" target="_blank" class="footer-social-link">
            Реквизиты <i class="la la-download"></i>
        </a>

        <a href="https://tochka.com/my/02b1ccac59ff43f49be7f5466a51d31e" class="footer-social-link">
            Онлайн-оплата <i class="la la-credit-card"></i>
        </a>

    </div>
    <div class="footer-social">
        <a class="footer-social-link" href="//vk.com/kupitrelsy" target="_blank">
            <i class="la la-vk"></i>
            vk
        </a>
        <a class="footer-social-link" href="//www.facebook.com/groups/1921075574798168/" target="_blank">
            <i class="la la-facebook"></i>
            facebook
        </a>
        <a class="footer-social-link" href="//plus.google.com/communities/102161111287666251042"
           target="_blank">
            <i class="la la-google-plus"></i>
            google+
        </a>
        <a class="footer-social-link" href="//twitter.com/kupitrelsy" target="_blank">
            <i class="la la-twitter"></i>
            twitter
        </a>
    </div>
    {{--<div class="footer-social">--}}
        {{--@if(Auth::guest())--}}
            {{--<a class="footer-social-link" href="/login">--}}
                {{--<i class="la la-lock"></i>--}}
                {{--Вход--}}
            {{--</a>--}}
        {{--@else--}}
            {{--<a class="footer-social-link" href="/admin">--}}
                {{--<i class="la la-lock"></i>--}}
                {{--Администрирование--}}
            {{--</a>--}}
        {{--@endif--}}
    {{--</div>--}}

    <div class="footer-text">
        <div class="footer-text-left">
            <p>&copy; 2001-2017</p>
            <p>Холдинг «Рельсовый завод «Опт-рельс»</p>
        </div>
        <div class="footer-text-right">
            <p>Управление холдингом: ООО «Торговый дом «Сибирский родник»</p>
            <p>ИНН 2311242581, КПП 231101001, ОГРН 1172375064685</p>
        </div>
    </div>


</div>