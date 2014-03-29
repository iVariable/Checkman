<?php
namespace Budget\BudgetBundle\Tests\Service;

use Budget\BudgetBundle\DataFixtures\Test\LoadTestData;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReportsFunctionalTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('em');
    }

    public function testProjectSummaryClear()
    {
        $container = static::$kernel->getContainer();

        $tgnUser = $container->get('r.user')->findOneByUsername('Tgn');
        $tgnOrnUser = $container->get('r.user')->findOneByUsername('TgnOren');
        $adminUser = $container->get('r.user')->findOneByUsername('Admin');

        $project_vtb24 = $container->get('r.project')->findOneByTitle('ВТБ24');
        $project_softline = $container->get('r.project')->findOneByTitle('*.softline');
        $project_etp = $container->get('r.project')->findOneByTitle('ЕТП');
        $project_edu = $container->get('r.project')->findOneByTitle('edu.softline');
        $project_alpha = $container->get('r.project')->findOneByTitle('Альфастрахование');

        $reports = [];

        /** @var  $servicesFactory \Budget\BudgetBundle\Service\Factory */
        $servicesFactory = $container->get('budget.services.factory');

        /** @var  $reports \Budget\BudgetBundle\Service\Reports */
        $reports['Tgn'] = $servicesFactory->getReportsForUser($tgnUser);

        /** @var  $reports \Budget\BudgetBundle\Service\Reports */
        $reports['TgnOren'] = $servicesFactory->getReportsForUser($tgnOrnUser);

        /** @var  $reports \Budget\BudgetBundle\Service\Reports */
        $reports['Admin'] = $servicesFactory->getReportsForUser($adminUser);

        $testYear = explode('.', LoadTestData::$testDateStart)[2];
        $testMonth = (int)explode('.', LoadTestData::$testDateStart)[1];

        $checkSummary = function ($result, $expected, $description) {
            $result = array_reduce(
                $result,
                function ($start, $current) {
                    return $start + $current['total'];
                },
                0
            );
            $this->assertEquals($expected, round($result), $description);
        };

        $expectations = [
            [
                'project' => $project_vtb24,
                'results' => [
                    ['user' => $tgnUser, 'result' => 9900],
                    ['user' => $tgnOrnUser, 'result' => 34900],
                    ['user' => $adminUser, 'result' => 54700],
                ]
            ],
            [
                'project' => $project_softline,
                'results' => [
                    ['user' => $tgnUser, 'result' => 69900],
                    ['user' => $tgnOrnUser, 'result' => 69900],
                    ['user' => $adminUser, 'result' => 89700],
                ]
            ],
            [
                'project' => $project_etp,
                'results' => [
                    ['user' => $tgnUser, 'result' => 29900],
                    ['user' => $tgnOrnUser, 'result' => 29900],
                    ['user' => $adminUser, 'result' => 49700],
                ]
            ],
            [
                'project' => $project_edu,
                'results' => [
                    ['user' => $tgnUser, 'result' => 50000],
                    ['user' => $tgnOrnUser, 'result' => 50000],
                    ['user' => $adminUser, 'result' => 50000],
                ]
            ],
            [
                'project' => $project_alpha,
                'results' => [
                    ['user' => $tgnUser, 'result' => 0],
                    ['user' => $tgnOrnUser, 'result' => 0],
                    ['user' => $adminUser, 'result' => 13],
                ]
            ]
        ];

        foreach ($expectations as $expectation) {
            foreach ($expectation['results'] as $expectedUserResult) {
                $spendings = $reports[$expectedUserResult['user']->getUsername()]->getProjectSummaryClear(
                    $expectation['project']->getId(),
                    $testYear
                );
                $checkSummary(
                    $spendings,
                    $expectedUserResult['result'],
                    $expectation['project'] . ': ' . $expectedUserResult['user'] . ' total spendings'
                );
            }
        }

    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }
}