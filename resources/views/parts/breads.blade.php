@if(!empty($links))
    <div class="breads">

        <a class="breads-link" href="/">
            <span class="ion-home"></span>
        </a>
        <span class="ion-chevron-right breads-separator"></span>

        @foreach ($links as $link)
            @if ($loop->last)
                <span class="breads-current">
                    {{ $link['name'] }}
                </span>
            @else
                <a href="{{ $link['href'] }}"
                   class="breads-link">
                    {{ $link['name'] }}
                </a>
                <span class="ion-chevron-right breads-separator"></span>
            @endif
        @endforeach

    </div>
@endif