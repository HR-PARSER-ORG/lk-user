<?php

namespace App\Command;

use App\Entity\HHRegion;
use App\Repository\HHRegionRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class FetchRegionsCommand extends Command
{
    private Client $httpClient;

    const ADDITIONAL_REGIONS = [
        'Екатеринбург' => '3',
    ];

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
        $io = new SymfonyStyle($input, $output);
        $io->title('Fetch regions');

        try {
            $regionsResponse = $this->httpClient
                ->request('GET', self::BASE_URI)
                ->getBody()
                ->getContents();

            $areas = json_decode($regionsResponse, true)[0]['areas'];

            $io->info('Fetching regions...');

            foreach ($areas as $area) {
                if ($region = $this->HHRegionRepository->findOneBy(['hhId' => $area['id']])) {
                    $region->setName($area['name']);
                    $region->setHhId($area['id']);
                    $io->writeln('Updated region: ' . $area['name']);
                } else {
                    $region = new HHRegion($area['name'], $area['id']);
                    $io->writeln('Added region: ' . $area['name']);
                }

                $this->HHRegionRepository->add($region);
            }

            $io->info('Fetching additional regions...');

            $additionalRegions = $this->getAdditionalRegions();

            foreach ($additionalRegions as $additionalRegion) {
                if ($region = $this->HHRegionRepository->findOneBy(['hhId' => $additionalRegion->getHhId()])) {
                    $io->writeln('Updated region: ' . $additionalRegion->getName());
                } else {
                    $region = $additionalRegion;
                    $io->writeln('Added region: ' . $additionalRegion->getName());
                }

                $this->HHRegionRepository->add($region);
            }

            $io->info('Regions fetched successfully!');
        } catch (\Exception $exception) {
            $io->error('Error fetching regions: ' . $exception->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    /**
     * @return HHRegion[]
     */
    protected function getAdditionalRegions(): array
    {
        $additionalRegions = [];
        foreach ($this::ADDITIONAL_REGIONS as $regionAlias => $regionId) {
            $additionalRegions[] = new HHRegion($regionAlias, $regionId);
        }

        return $additionalRegions;
    }
}
