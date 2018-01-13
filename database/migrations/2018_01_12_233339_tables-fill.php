<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablesFill extends Migration
{

    public function up()
    {

        $this->down();

        $getValue = function ($value, $spaces = false, $lowercase = false) {

            $value = \Zver\StringHelper::load($value)
                                       ->trimSpaces();

            if ($spaces) {
                $value->replace('\s', '');
            }

            if ($lowercase) {
                $value->toLowerCase();
            }

            /**
             * special
             */

            if ($value->isContain('позапросу')) {
                return null;
            }

            $value = $value->get();

            if (empty($value)) {
                return null;
            }

            return $value;

        };

        $sourcesDir = base_path() . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'source' . DIRECTORY_SEPARATOR;

        /**
         * products
         */
        $products = json_decode(file_get_contents($sourcesDir . 'products.json'), true);

        foreach ($products as $product) {

            $category = \App\ProductsCategories::firstOrCreate(['category' => $product['category']]);

            \App\Products::firstOrCreate([
                'id_category' => $category->id,
                'name'        => $getValue($product['name']),
                'weight'      => $getValue($product['weight'], true, true),
                'unit'        => $getValue($product['unit'], true),
                'price'       => $getValue($product['price'], true),
            ]);
        }

        /**
         * specs
         */
        $specs = json_decode(file_get_contents($sourcesDir . 'specs.json'), true);

        foreach ($specs as $spec) {
            $record = \App\Specs::firstOrCreate([
                'name'    => $getValue($spec['name']),
                'length'  => $getValue($spec['length']),
                'gost'    => $getValue($spec['gost']),
                'weightT' => $getValue($spec['weightT']),
                'weightM' => $getValue($spec['weightM']),
            ]);

            if (isset($spec['img'])) {
                $record->img = $spec['img'];
                $record->save();
            }
        }

    }

    public function down()
    {

        DB::table('news')
          ->delete();

        DB::table('products')
          ->delete();

        DB::table('products_categories')
          ->delete();

        DB::table('specs')
          ->delete();

    }
}
