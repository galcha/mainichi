<?php

namespace App\Command;

use App\Helper\WordHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DailyCacheRestoreCommand extends ContainerAwareCommand
{
    protected function configure()
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var FilesystemCache $cache */
        $cache = $this->getContainer()->get(FilesystemCache::class);
        $words = $cache->get('words');
        array_shift($words);

        $word = $this->getContainer()->get(WordHelper::class)->fetchNewRandomWord();
        array_push($words, $word);
        $cache->set('words', $words);

    }
}