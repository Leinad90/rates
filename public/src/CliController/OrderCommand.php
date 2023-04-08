<?php

namespace App\CliController;

use App\Model\OrderNumbers;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:order')]
class OrderCommand extends Command
{

    public function __construct(
        private readonly OrderNumbers $orderNumbers
    )
    {
        parent::__construct();

    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $ui = new SymfonyStyle($input, $output);
        $arr = [
            '0' => 'ahoj1',
            '1' => 'Ahoj10',
            '2' => 'ahoj12',
            '3' => 'Ahoj2',
            '4' => 'ahoj3',
        ];
        $ui->writeln($this->orderNumbers->sort($arr));
        return self::SUCCESS;
    }
}