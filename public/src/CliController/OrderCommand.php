<?php

namespace App\CliController;

use App\Model\OrderNumbers;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:order', description: 'Seřadí zadaná čísla')]
class OrderCommand extends Command
{

    public function __construct(
        private readonly OrderNumbers $orderNumbers
    ) {
        parent::__construct();
    }

    public function configure(): void
    {
        parent::configure();
        $this->addArgument(
            'numbers',
            InputArgument::IS_ARRAY|InputArgument::OPTIONAL,
            'Čísla k seřazení',
            [
                '0' => 'ahoj1',
                '1' => 'Ahoj10',
                '2' => 'ahoj12',
                '3' => 'Ahoj2',
                '4' => 'ahoj3',
            ]
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $ui = new SymfonyStyle($input, $output);
        $arr = $input->getArgument('numbers');

        $ui->writeln('Seřazení čísel: ');
        $ui->writeln(print_r($arr,true));
        $ui->writeln('');
        $ui->writeln('Seřazeno: ');
        $ui->writeln(print_r($this->orderNumbers->sort($arr),true));
        return self::SUCCESS;
    }
}