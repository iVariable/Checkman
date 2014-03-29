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

class FixDaySpendingsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('budget:spendings:day-fix')
            ->setDescription('Fixes day spendings in DB')
            ->addArgument('date', InputArgument::OPTIONAL, 'date in d.m.Y format', date("d.m.Y"))
            ->addOption("overwrite-day-spendings", "o", InputOption::VALUE_NONE)
            ->addOption("not-verbose", "w", InputOption::VALUE_NONE)
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
        $this->verbose = !$this->input->getOption('not-verbose');

        $dateString = $input->getArgument('date');
        $date = \DateTime::createFromFormat('d.m.Y', $dateString);

        $spendingsRepo = $this->getContainer()->get('r.spendings');

        // @TODO: check repo

        $hasDaySpendings = $spendingsRepo->hasDaySpendings($date);
        $salaryType = $this->getContainer()->get('r.spendings_type')->getSalaryType();

        if ($hasDaySpendings) {
            if (!$input->getOption("overwrite-day-spendings")) {
                $this->log(
                    "<error>This day already has fixed spendings! Use --overwrite-day-spendings key if you want to overwrite them.<error>",
                    true
                );

                return false;
            } else {
                $this->log('<info>Existed day salary spendings cleared</info>');
                $spendingsRepo->clearDaySpendings($date, $salaryType);
            }
        }

        $employees = $this->getContainer()->get('r.employee')->getActiveEmployees();

        $numberDaysInMonth = date('t', $date->getTimestamp());

        $this->log('<info>Processing employees</info>');

        $em = $this->getContainer()->get('em');

        $lostMoneyProject = $this->getContainer()->get('r.project')->getLostMoneyProject();

        /* @var $employee Employee */
        foreach ($employees as $employee) {

            $this->log("<comment>Employee: </comment>" . $employee);

            $projects = $employee->getProjectInvolvements();

            $daySalary = $employee->getSalary() / $numberDaysInMonth;

            $totalEmployment = 0;

            /* @var $projectInvolvement ProjectInvolvement */
            foreach ($projects as $projectInvolvement) {

                /* @var $salarySpending Spendings */
                $salarySpending = $spendingsRepo->newEntity();

                $totalEmployment += $projectInvolvement->getInvolvement();

                $salarySpending
                    ->setProject($projectInvolvement->getProject())
                    ->setEmployee($employee)
                    ->setDate($date)
                    ->setType($salaryType)
                    ->setValue($daySalary / 100 * $projectInvolvement->getInvolvement())
                    ->setExtra($projectInvolvement->getInvolvement())
                ;

                $em->persist($salarySpending);
            }

            if($totalEmployment < 100) {
                /* @var $salarySpending Spendings */
                $salarySpending = $spendingsRepo->newEntity();

                $salarySpending
                    ->setProject($lostMoneyProject)
                    ->setEmployee($employee)
                    ->setDate($date)
                    ->setType($salaryType)
                    ->setValue($daySalary / 100 * (100-$totalEmployment))
                    ->setExtra((100-$totalEmployment))
                ;

                $em->persist($salarySpending);
            }

        }

        $em->flush();

        $this->log('<info>Done.</info>');

    }

    protected function log($text, $critical = false)
    {
        if ($this->verbose || $critical) {
            $this->output->writeln($text);
        }
    }

}