<?php

namespace App\Command;

use App\Entity\HHIndustry;
use App\Entity\HHRegion;
use App\Repository\HHRegionRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchRegionsCommand extends Command
{
    private Client $httpClient;

    const BASE_URI = 'https://api.hh.ru/areas';

    public function __construct(
        private HHRegionRepository $HHRegionRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('hh:fetch:regions')
            ->setDescription('Fetch regions')
            ->setHelp('This command allows you to fetch regions');

        $this->httpClient = new Client();
    }

    /**
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        try {
            $regionsResponse = $this->httpClient
                ->request('GET', self::BASE_URI)
                ->getBody()
                ->getContents();

            $areas = json_decode($regionsResponse, true)[0]['areas'];

            $output->writeln('<info>Fetching regions...</info>');

            foreach ($areas as $area) {
                if ($region = $this->HHRegionRepository->findOneBy(['hhId' => $area['id']])) {
                    $region->setName($area['name']);
                    $region->setHhId($area['id']);
                    $output->writeln('<comment>Updated region:</comment> ' . $area['name']);
                } else {
                    $region = new HHRegion($area['name'], $area['id']);
                    $output->writeln('<comment>Added region:</comment> ' . $area['name']);
                }

                $this->HHRegionRepository->add($region);
            }

            $output->writeln('<info>Regions fetched successfully!</info>');
        } catch (\Exception $exception) {
            $output->writeln('<error>Error fetching regions:</error> ' . $exception->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
