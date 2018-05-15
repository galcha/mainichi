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
            /* @TODO : allow other APIs */
            $words = json_decode($this->client->request('GET', 'http://jisho.org/api/v1/search/words?keyword=jlpt-n5')->getBody()->getContents());
            $words = $this->formatJishoResponse($words);
            $randomKey = random_int(0, count($words) - 1);

            $this->cache->set('word', $words[$randomKey], strtotime('tomorrow') - time());
        }

        return $this->cache->get('word');
    }

    /**
     * @param object $response
     * @return array
     */
    private function formatJishoResponse($response)
    {
        $return = [];

        foreach($response->data as $word) {
            $return[] = [
                'original' => $word->japanese[0]->word,
                'originalReading' => $word->japanese[0]->reading,
                'translation' => $word->senses[0]->english_definitions,
                'wordType' => $word->senses[0]->parts_of_speech,
            ];
        }

        return $return;
    }
}