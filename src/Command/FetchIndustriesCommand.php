<?php

namespace App\Command;

use App\Entity\HHIndustry;
use App\Entity\HHSubIndustry;
use App\Repository\HHIndustryRepository;
use App\Repository\HHSubIndustryRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FetchIndustriesCommand extends Command
{
    private Client $httpClient;

    const BASE_URI = 'https://api.hh.ru/industries';

    public function __construct(
        private HHIndustryRepository $HHIndustryRepository,
        private HHSubIndustryRepository $HHSubIndustryRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('hh:fetch:industries')
            ->addOption('refresh', 'r', InputOption::VALUE_OPTIONAL, 'Hard refresh head hunter industries', false)
            ->setDescription('Fetch industries')
            ->setHelp('This command allows you to fetch industries');

        $this->httpClient = new Client();
    }

    /**
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Fetch industries');

        try {
            $industriesResponse = $this->httpClient
                ->request('GET', self::BASE_URI)
                ->getBody()
                ->getContents();

            $industries = json_decode($industriesResponse, true);

            $io->info('Fetching industries...');

            if ($input->getOption('refresh')) {
                $this->HHIndustryRepository->deleteAll();
            }

            foreach ($industries as $industry) {
                $hhIndustry = new HHIndustry();
                $hhIndustry->setName($industry['name']);
                $hhIndustry->setHhId($industry['id']);
                $subIndustries = $industry['industries'];
                foreach ($subIndustries as $subIndustry) {
                    $hhSubIndustry = new HHSubIndustry();
                    $hhSubIndustry->setName($subIndustry['name']);
                    $hhSubIndustry->setHhId($subIndustry['id']);
                    $hhSubIndustry->setHhIndustry($hhIndustry);
                    $this->HHSubIndustryRepository->add($hhSubIndustry);
                    $io->writeln('Added SubIndustry: ' . $subIndustry['name']);
                }

                $io->writeln('Added Industry: ' . $industry['name']);

            }

            $io->info('Industries fetched successfully!');
        } catch (\Exception $exception) {
            $io->error('Error fetching industries: ' . $exception->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
