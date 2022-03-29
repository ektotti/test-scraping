<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Dusk\Browser;
use Symfony\Component\DomCrawler\Crawler;
use Revolution\Salvager\Facades\Salvager;

class testscraping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:scraping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
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
