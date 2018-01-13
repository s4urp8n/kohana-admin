<?php

namespace App\Http\Controllers;

use App\Products;
use App\ProductsCategories;
use Illuminate\Http\Request;
use Zver\StringHelper;

class HomeController extends Controller
{
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
