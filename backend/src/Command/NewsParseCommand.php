<?php

namespace App\Command;

use App\Service\{NewsCollectorService, FilterPostListService};
use App\Utils\NewsParser\NewsCollectorFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:news-parse',
    description: 'The command to start parsing and add news to the database',
)]
class NewsParseCommand extends Command
{
    public function __construct(
        private NewsCollectorService $newsSaverService,
        private FilterPostListService $filterPostListService,
        private int $newsLimit,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('sourceNews', InputArgument::REQUIRED, 'Argument description')
            ->addOption('count', 'c', InputOption::VALUE_REQUIRED, 'Maximum number of news', $this->newsLimit);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $sourceNews = $input->getArgument('sourceNews');

        if ($sourceNews) {
            $io->note(sprintf('Your source news: %s', $sourceNews));
        }

        $count = intval($input->getOption('count'));
        if (!$count) {
            $io->warning('Invalid value entered, use default: ' . $this->newsLimit);
            $count = $this->newsLimit;
        }

        $io->info('News that is not in the database will be added.');

        $newsCollector = NewsCollectorFactory::makeNews($sourceNews, [$count]);
        $newsCollector->process();
        $newsCollector->filtredPostList($this->filterPostListService);
        $newsCollector->handlePostItems();

        $newsListDTO = $newsCollector->getData();
        if ($newsListDTO->count() > 0) {
            $this->newsSaverService->save($newsListDTO);
            $io->success('News parsing completed.');
        } else {
            $io->warning('News not received.');
        }

        return Command::SUCCESS;
    }
}
