<?php

namespace Budget\BudgetBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class FixDaySpendingsCommandCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('budget:spendings:dayFix')
            ->setDescription('Fixes day spendings in DB')
            ->addArgument('date', InputArgument::REQUIRED, 'date in d.m.Y format',date("d.m.Y") )
            ->addOption("overwrite-day-spendings", "ods", InputOption::VALUE_OPTIONAL)
            ->setHelp(<<<EOF
Help will be later. Or never :)
EOF
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dateString = $input->getArgument('date');
        $date = new \DateTime();
        $date->createFromFormat('d.m.Y', $dateString);

        $repo = $this->getContainer()->get('r.spendings');

        // @TODO: check repo

        $hasDaySpendings = $repo->hasDaySpendings($date);

        if($hasDaySpendings && !$input->hasOption("ods")) {
            $output->writeln("<error>This day already has fixed spendings! Use --ods key if you want to overwrite them.<error>");
            return false;
        }

        $repo->clearDaySpendings($date);



    }


}