<?php

namespace App\Helper;

use Symfony\Component\Cache\Simple\FilesystemCache;

class WordHelper {

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var FilesystemCache
     */
    private $cache;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
        $this->cache = new FilesystemCache();
    }

    public function getWordOfTheDay()
    {
        if (!$this->cache->has('word')) {
            $words = json_decode($this->client->request('GET', 'http://jisho.org/api/v1/search/words?keyword=jlpt-n5')->getBody()->getContents());
            $randomKey = random_int(0, count($words->data) - 1);

            $this->cache->set('word', $words->data[$randomKey], strtotime('tomorrow') - time());
        }

        return $this->cache->get('word');
    }
}