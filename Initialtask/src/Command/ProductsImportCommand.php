<?php

namespace App\Command;

use App\Entity\FileParser;
use App\Entity\Product;
use App\Repository\FileParserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;


class ProductsImportCommand extends Command
{
    protected static $defaultName = 'products:import';
    protected static $defaultDescription = 'import products from *.csv file';

    private $entityManager;

    private $processedCount = 0;
    private $skippedCount = 0;
    private $successCount = 0;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->EntityManager = $em;
    }

    protected function configure(): void
    {
        $this->addOption('testMode', null, InputOption::VALUE_NONE, 'is test mode enabled');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $testMode = $input->getOption('testMode');  // if running:  products:import --testMode  == test mode;

        $now = new \DateTimeImmutable('now');

        $filePath = "%kernel.root_dir%/../public/1stock.csv";    //CSV file for import

        $fileData = $this->EntityManager->getRepository(FileParser::class)->loadData($filePath);    //loading CSV data

        if (!is_object($fileData)) {
            $io->writeln("<error>".$fileData['error']."</error>");  exit(); // File reading error
        }

        $skippedProducts = [];

        foreach ($fileData as $fileRow){

            $product = $this->EntityManager->getRepository(Product::class)->findOneBy([
                'code' => $fileRow['Product Code']
            ]);

            if ($product === null){     // if product absent in database
                if (((float)$fileRow['Cost in GBP'] < Product::MIN_COST && (int)$fileRow['Stock'] < Product::MIN_STOCK ) || ((float)$fileRow['Cost in GBP'] > Product::MAX_COST) ){
                    // Import Rules implementation
                    $skippedProducts[] = $fileRow['Product Name']." (".$fileRow['Product Code']."). Import rules restrict inserting.";
                    $this->skippedCount++;
                } else {
                    if ($fileRow['Discontinued'] === 'yes'){
                        $discounted = $now;     //if discontinued setting current date
                    } else {
                        $discounted = null;
                    }
                    $product  = (new Product())
                        ->setName($fileRow['Product Name'])
                        ->setCode($fileRow['Product Code'])
                        ->setDescription($fileRow['Product Description'])
                        ->setCost((float)$fileRow['Cost in GBP'])
                        ->setStock((int)$fileRow['Stock'])
                        ->setAdded($now)
                        ->setDiscontinued($discounted)
                        ->setUpdated($now);

                    if (!$testMode) { // NO any actions in database during  test mode
                        $this->EntityManager->persist($product);
                        $this->EntityManager->flush();
                    }
                    $this->successCount++;
                }

            } else {
                $skippedProducts[] = $fileRow['Product Name']." (".$fileRow['Product Code']."). Product with this code already exist.";
                $this->skippedCount++;
            }
            $this->processedCount++;
        }

        $io->writeln("<info>Counters:</info>");
        $io->writeln("Records processed: ".$this->processedCount);
        $io->writeln("Records inserted: ".$this->successCount);
        $io->writeln("Records skipped: ".$this->skippedCount);
        if (count($skippedProducts)>0) {
            $io->writeln("<error>Skipped records:</error>");
            foreach ($skippedProducts as $sp){
                $io->writeln($sp);
            }
        }

        return Command::SUCCESS;
    }
}
