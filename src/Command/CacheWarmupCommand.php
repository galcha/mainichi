<?php

namespace App\Command;

use App\Helper\WordHelper;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CacheWarmupCommand extends Command
{
    /**
     * @var WordHelper
     */
    private $wordHelper;

    /**
     * @param WordHelper $wordHelper
     */
    public function __construct(WordHelper $wordHelper)
    {
        parent::__construct();
        $this->wordHelper = $wordHelper;
    }

    protected function configure()
    {
        $this->setName('cache:warmup');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var FilesystemCache $cache */
        $cache = new FilesystemCache();
        $cache->delete('words');

        $this->wordHelper->initWordsOfTheDay();
    }
}