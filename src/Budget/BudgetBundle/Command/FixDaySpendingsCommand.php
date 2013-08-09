<?php

namespace Budget\BudgetBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class FixDaySpendingsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('budget:spendings:day-fix')
            ->setDescription('Fixes day spendings in DB')
            ->addArgument('date', InputArgument::OPTIONAL, 'date in d.m.Y format', date("d.m.Y"))
            ->addOption("overwrite-day-spendings", "ods", InputOption::VALUE_OPTIONAL)
            ->addOption("not-verbose", "nv", InputOption::VALUE_OPTIONAL)
            ->setHelp(
                <<<EOF
                Help will be later. Or never :)
EOF
            );
    }

    protected $verbose = true;
    protected $input;
    protected $output;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->verbose = !$this->input->hasOption('not-verbose');

        $dateString = $input->getArgument('date');
        $date = new \DateTime();
        $date->createFromFormat('d.m.Y', $dateString);

        $repo = $this->getContainer()->get('r.spendings');

        // @TODO: check repo

        $hasDaySpendings = $repo->hasDaySpendings($date);

        if ($hasDaySpendings) {
            if (!$input->hasOption("ods")) {
                $this->log(
                    "<error>This day already has fixed spendings! Use --ods key if you want to overwrite them.<error>",
                    true
                );

                return false;
            } else {
                $this->log('<info>Existed day spendings cleared</info>');
                $repo->clearDaySpendings($date);
            }
        }



    }

    protected function log($text, $critical = false)
    {
        if ($this->verbose || $critical) {
            $this->input->writeln($text);
        }
    }

}