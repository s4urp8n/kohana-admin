<table class="catalog-products-table">
    <tr>
        <th>Наименование</th>
        <th>Вес</th>
        <th>Единица измерения</th>
        <th>Цена с НДС, руб</th>
    </tr>
    @foreach($products as $product)
        <tr>
            <td>
                <a href="{{ $product->getHref() }}">
                    {{ $product->name }}
                </a>
            </td>
            <td>{{ $product->weight }}</td>
            <td>{{ $product->unit }}</td>
            <td>от {{ $product->price }}</td>
        </tr>
    @endforeach
</table>