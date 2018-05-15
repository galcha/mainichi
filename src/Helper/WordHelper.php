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

    /**
     * Returns the current top of the pile of saved words.
     * The offset is defined by client when using the refresh function.
     * Every day, the top of the pile is poped, ensuring a new word.
     * @param int $offset
     * @return mixed
     */
    public function getWordOfTheDay($offset = 0)
    {
        if (!$this->cache->has('words')) {
            $words = $this->initWordsOfTheDay();
        } else {
            $words = $this->cache->get('words');
        }

        return $words[$offset%19];
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

    /**
     * Used for initial warming of the cache
     * @return object
     */
    public function initWordsOfTheDay()
    {
        $words = json_decode($this->client->request('GET', 'https://jisho.org/api/v1/search/words?keyword=%23common&page='.rand(1, 15))->getBody()->getContents());
        $words = $this->formatJishoResponse($words);
        $this->cache->set('words', $words, strtotime('next month') - time());

        return $words;
    }


    /**
     * Used for daily cache warmingu
     * @return object
     */
    public function fetchNewRandomWord()
    {
        $words = json_decode($this->client->request('GET', 'https://jisho.org/api/v1/search/words?keyword=%23common&page='.rand(1, 30))->getBody()->getContents());
        $words = $this->formatJishoResponse($words);

        return $words[rand(0, 19)];
    }
}