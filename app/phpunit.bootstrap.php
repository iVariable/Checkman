<?php

require_once __DIR__ . '/bootstrap.php.cache';

require_once __DIR__ . '/AppKernel.php';

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

$kernel = new AppKernel('test', true); // create a "test" kernel
$kernel->boot();

$application = new Application($kernel);
$application->setAutoExit(false);

executeCommand($application, "doctrine:database:drop", ['--force' => true]);
executeCommand($application, "doctrine:database:create");
executeCommand($application, "doctrine:migrations:migrate");
executeCommand($application, "doctrine:fixtures:load", ["--fixtures" => "src/Checkman/CheckmanBundle/DataFixtures/Test"]);

//Shiiiiit
executeCommand(
    $application,
    'budget:spendings:interval-fix',
    [
        'startDate' => \Checkman\CheckmanBundle\DataFixtures\Test\LoadTestData::$testDateStart,
        'endDate' => \Checkman\CheckmanBundle\DataFixtures\Test\LoadTestData::$testDateEnd,
    ]
);

function executeCommand($application, $command, Array $options = array())
{
    $options["--env"] = "test";
    //$options["--verbose"] = true;
    $options["--quiet"] = true;
    $options["--no-interaction"] = true;
    $options = array_merge(array('command' => $command), $options);

    $application->run(new ArrayInput($options));
}
