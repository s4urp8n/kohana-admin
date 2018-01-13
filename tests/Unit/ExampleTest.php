<?php

namespace Tests\Unit;

use App\Config;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testConfigIsUrlActive()
    {
        $tests = [
            [
                '/contacts',
                '/',
                false
            ],
            [
                '/',
                '/contacts',
                false
            ],
            [
                '/',
                '/',
                true
            ],
            [
                '/news',
                '/news/new',
                true
            ],
            [
                '/news/upload',
                '/news/new',
                true
            ],
            [
                '/news',
                '/newspaper',
                false
            ],
        ];

        foreach ($tests as $test) {

            $url1 = $test[0];
            $url2 = $test[1];
            $result = $test[2];

            $_SERVER['HTTP_HOST'] = 'localhost';

            $message = 'Result for ' . $url1 . ' and ' . $url2 . ' is not  equals ' . ($result ? 'true' : 'false');

            $this->assertSame(Config::isUrlActive($url1, $url2), $result, $message);
        }
    }
}
