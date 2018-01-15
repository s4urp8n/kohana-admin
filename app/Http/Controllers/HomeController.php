<?php

namespace App\Http\Controllers;

use App\Mailer;
use App\Products;
use App\ProductsCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Zver\StringHelper;

class HomeController extends Controller
{

    public function email()
    {

        $mailTo = 'sibrodnic@mail.ru';

        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $text = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

        $success = false;

        if (!empty($phone) && !empty($name) && !empty($text)) {

            $body = "Сообщение с сайта kupitrelsy.ru\n";
            $body .= "Имя: " . $name . "\n";
            $body .= "Телефон: " . $phone . "\n";
            $body .= "Текст:\n" . $text . "\n\n";

            Mailer::send($mailTo, 'Сообщение с сайта kupitrelsy.ru', nl2br($body));

            $success = true;
        }

        if ($success) {

            \request()
                ->session()
                ->flash('status', 'Сообщение успешно отправлено, спасибо!');

            return redirect()
                ->back();
        }

        \request()
            ->session()
            ->flash('status', 'Сообщение НЕ отправлено, проверьте правильность ввода данных!');

        return redirect()
            ->back()
            ->withInput();
    }

    public function sitemapXml()
    {
        $urls = [];

        $sourcesData = [
            Products::all(),
            ProductsCategories::all()
        ];

        foreach ($sourcesData as $sources) {
            foreach ($sources as $source) {
                $urls[] = url($source->getHref());
            }
        }

        return view('sitemap', ['urls' => $urls]);
    }

    public function index()
    {
        return view('home');
    }

    public function search()
    {

        $searchString = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);

        $products = [];

        if (!empty($searchString)) {
            $products = Products::where('name', 'like', '%' . $searchString . '%')
                                ->orderBy('name')
                                ->get();

            if ($products->count() == 0) {
                $products = [];
            }
        }

        return view('search', ['products' => $products]);
    }

    public function news()
    {
        return view('news');
    }

    public function specs()
    {
        return view('specs');
    }

    public function newPage()
    {
        return view('new');
    }

    public function catalog($category = null)
    {

        $categories = ProductsCategories::getCategories();

        if (is_null($category)) {
            $category = $categories->first();
        } else {
            foreach ($categories as $possibleCategory) {

                $slug = $possibleCategory->getSlug();

                if ($slug == $category) {
                    $category = $possibleCategory;
                }
            }
        }

        if (is_string($category) || empty($category)) {
            return abort(404);
        }

        $products = Products::where('id_category', $category->id)
                            ->orderBy('name', 'price')
                            ->get();

        return view('catalog', [
            'categories'      => $categories,
            'currentCategory' => $category,
            'products'        => $products,
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function product($id, $title)
    {

        $product = Products::find($id);

        if (!$product) {
            return abort(404);
        }

        return view('product', ['product' => $product]);
    }

    public function contacts()
    {
        return view('contacts');
    }
}
