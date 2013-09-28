<?php

namespace Budget\BudgetBundle\Command;

use Budget\BudgetBundle\Entity\Employee;
use Budget\BudgetBundle\Entity\ProjectInvolvement;
use Budget\BudgetBundle\Entity\Spendings;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class FixIntervalSpendingsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('budget:spendings:interval-fix')
            ->setDescription('Fixes interval of days spendings in DB')
            ->addArgument('startDate', InputArgument::REQUIRED, 'date in d.m.Y format')
            ->addArgument('endDate', InputArgument::OPTIONAL, 'date in d.m.Y format', date("d.m.Y"))
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

        $dateString = $input->getArgument('startDate');
        $startDate = \DateTime::createFromFormat('d.m.Y', $dateString);

        $dateString = $input->getArgument('endDate');
        $endDate = \DateTime::createFromFormat('d.m.Y', $dateString);

        $interval = new \DatePeriod($startDate, new \DateInterval('P1D'), $endDate);

        foreach($interval as $date){
            $output->writeln('Processing: '.$date->format('d.m.Y'));
            $this->getContainer()->get('em')->clear();
            $command = $this->getApplication()->find('budget:spendings:day-fix');

            $arguments = array(
                'command' => 'budget:spendings:day-fix',
                'date'    => $date->format('d.m.Y'),
                '--overwrite-day-spendings'  => true,
                '--not-verbose' => true,
            );

            $input = new \Symfony\Component\Console\Input\ArrayInput($arguments);
            $command->run($input, $output);

            $output->writeln('Done processing: '.$date->format('d.m.Y'));
        }

    }

}