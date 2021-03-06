<?php

namespace App\Command;

use App\Helper\WordHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DailyCacheRestoreCommand extends ContainerAwareCommand
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
        $this->setName('refresh:daily');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var FilesystemCache $cache */
        $cache = new FilesystemCache();
        $words = $cache->get('words');
        array_shift($words);

        $word = $this->wordHelper->fetchNewRandomWord();
        array_push($words, $word);
        $cache->set('words', $words);

    }
}