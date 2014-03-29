<?php

require_once __DIR__ . '/bootstrap.php.cache';

require_once __DIR__ . '/AppKernel.php';

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

$kernel = new AppKernel('test', true); // create a "test" kernel
$kernel->boot();

$application = new Application($kernel);
$application->setAutoExit(false);
//executeCommand($application, "doctrine:schema:create");
executeCommand($application, "doctrine:fixtures:load", ["--fixtures" => "src/Budget/BudgetBundle/DataFixtures/Test"]);

//Shiiiiit
executeCommand(
    $application,
    'budget:spendings:interval-fix',
    [
        'startDate' => \Budget\BudgetBundle\DataFixtures\Test\LoadTestData::$testDateStart,
        'endDate' => \Budget\BudgetBundle\DataFixtures\Test\LoadTestData::$testDateEnd,

    ]
);

function executeCommand($application, $command, Array $options = array())
{
    $options["--env"] = "test";
    $options["--quiet"] = true;
    $options["--no-interaction"] = true;
    $options = array_merge(array('command' => $command), $options);

    $application->run(new ArrayInput($options));
}
