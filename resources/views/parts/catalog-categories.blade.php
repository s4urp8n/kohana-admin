<div class="catalog-categories">

    <h2>Категории</h2>

    @foreach(\App\ProductsCategories::getCategories() as $category)
        <a href="{{ $category->getHref() }}"
           class="{{ getHtmlElementActiveClass(isset($currentCategory) && $category->id==$currentCategory->id,'catalog-categories-url') }}">
            {{ $category->category }}
        </a>
    @endforeach

    <br>
    <hr>
    <br>

    <a href="/specs"
       class="{{ getHtmlElementActiveClass(\App\Config::isUrlActive('/specs'),'catalog-categories-url') }}">
        Характеристики
    </a>

</div>