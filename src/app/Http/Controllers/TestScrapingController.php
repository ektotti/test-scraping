<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Dusk\Browser;
use Symfony\Component\DomCrawler\Crawler;
use Revolution\Salvager\Facades\Salvager;


class TestScrapingController extends Controller
{
    public function test()
    {
        Salvager::browse(function (Browser $browser) use (&$crawler) {
            $crawler = $browser->visit('https://www.google.com/')
                               ->keys('input[name=q]', 'Laravel', '{enter}')
                               ->screenshot('google-laravel')
                               ->crawler();
        });

        /**
         * @var Crawler $crawler
         */
        $crawler->filter('.r')->each(function (Crawler $node) {
            dump($node->filter('h3')->text());
            dump($node->filter('a')->attr('href'));
        });
    }
}
