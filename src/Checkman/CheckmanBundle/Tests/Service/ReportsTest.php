<?php
namespace Checkman\CheckmanBundle\Tests\Service;

use Checkman\CheckmanBundle\DataFixtures\Test\LoadTestData;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReportsFunctionalTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    private $users = [];
    private $reports = [];
    private $projects = [];
    private $regions = [];
    private $testYear = 0;
    private $testMonth = 0;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('em');

        $container = static::$kernel->getContainer();

        $this->users['Tgn'] = $container->get('r.user')->findOneByUsername('Tgn');
        $this->users['TgnOren'] = $container->get('r.user')->findOneByUsername('TgnOren');
        $this->users['Admin'] = $container->get('r.user')->findOneByUsername('Admin');

        $this->regions['Tgn'] = $container->get('r.region')->findOneByTitle('Moscow');
        $this->regions['Orn'] = $container->get('r.region')->findOneByTitle('Orenburg');
        $this->regions['Nsk'] = $container->get('r.region')->findOneByTitle('Novosibirsk');

        $this->projects['yandex'] = $container->get('r.project')->findOneByTitle('yandex.ru');
        $this->projects['habr'] = $container->get('r.project')->findOneByTitle('habrahabr.ru');
        $this->projects['stack'] = $container->get('r.project')->findOneByTitle('stackoverflow.com');
        $this->projects['ms'] = $container->get('r.project')->findOneByTitle('microsoft.com');
        $this->projects['lenta'] = $container->get('r.project')->findOneByTitle('lenta.ru');

        $this->projects['office.tgn'] = $container->get('r.project')->findOneByTitle('Офис. Moscow');
        $this->projects['office.oren'] = $container->get('r.project')->findOneByTitle('Офис. Orenburg');
        $this->projects['office.nsk'] = $container->get('r.project')->findOneByTitle('Офис. Novosibirsk');

        /** @var  $servicesFactory \Checkman\CheckmanBundle\Service\Factory */
        $servicesFactory = $container->get('checkman.reports');

        /** @var  $reports \Checkman\CheckmanBundle\Service\Reports */
        $this->reports['Tgn'] = $servicesFactory->getReportsForUser($this->users['Tgn']);

        /** @var  $reports \Checkman\CheckmanBundle\Service\Reports */
        $this->reports['TgnOren'] = $servicesFactory->getReportsForUser($this->users['TgnOren']);

        /** @var  $reports \Checkman\CheckmanBundle\Service\Reports */
        $this->reports['Admin'] = $servicesFactory->getReportsForUser($this->users['Admin']);

        foreach ($this->reports as $username => $report) {
            $user = $this->users[$username];
            $this->reports[$username . '.project'] = function (\Checkman\CheckmanBundle\Entity\Project $project) use (
                $servicesFactory,
                $user
            ) {
                return $servicesFactory->getProjectReportsForUser($project->getId(), $user);
            };
        }

        $this->testYear = explode('.', LoadTestData::$testDateStart)[2];
        $this->testMonth = (int)explode('.', LoadTestData::$testDateStart)[1];

    }

    public function testProjectSummaryClear()
    {

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
                'project' => $this->projects['yandex'],
                'results' => [
                    ['user' => $this->users['Tgn'], 'result' => 9900],
                    ['user' => $this->users['TgnOren'], 'result' => 34900],
                    ['user' => $this->users['Admin'], 'result' => 54700],
                ]
            ],
            [
                'project' => $this->projects['habr'],
                'results' => [
                    ['user' => $this->users['Tgn'], 'result' => 69900],
                    ['user' => $this->users['TgnOren'], 'result' => 69900],
                    ['user' => $this->users['Admin'], 'result' => 89700],
                ]
            ],
            [
                'project' => $this->projects['stack'],
                'results' => [
                    ['user' => $this->users['Tgn'], 'result' => 29900],
                    ['user' => $this->users['TgnOren'], 'result' => 29900],
                    ['user' => $this->users['Admin'], 'result' => 49700],
                ]
            ],
            [
                'project' => $this->projects['ms'],
                'results' => [
                    ['user' => $this->users['Tgn'], 'result' => 50000],
                    ['user' => $this->users['TgnOren'], 'result' => 50000],
                    ['user' => $this->users['Admin'], 'result' => 50000],
                ]
            ],
            [
                'project' => $this->projects['lenta'],
                'results' => [
                    ['user' => $this->users['Tgn'], 'result' => 0],
                    ['user' => $this->users['TgnOren'], 'result' => 0],
                    ['user' => $this->users['Admin'], 'result' => 13],
                ]
            ]
        ];

        foreach ($expectations as $expectation) {
            foreach ($expectation['results'] as $expectedUserResult) {
                $spendings = $this->reports[$expectedUserResult['user']->getUsername() . '.project'](
                    $expectation['project']
                )->getAnnualSpendings_Clear(
                    $this->testYear
                );
                $checkSummary(
                    $spendings,
                    $expectedUserResult['result'],
                    $expectation['project'] . ': ' . $expectedUserResult['user'] . ' total spendings'
                );
            }
        }
    }

    public function testProjectSummaryWithShared()
    {

        $checkSummary = function ($result, $expected, $description) {
            $result = array_reduce(
                $result,
                function ($start, $current) {
                    return $start + $current['total'];
                },
                0
            );
            $this->assertEquals(round($expected), round($result), $description);
        };

        /**
         * Вручную считаем общие затраты.
         * Берем общую сумму затрат, делим на количество работников в регионе и умножаем на процент участия работника в проекте
         */
        $expectations = [
            [
                'project' => $this->projects['yandex'],
                'results' => [
                    ['user' => $this->users['Tgn'], 'result' => 9900 + 12500 / 4 * 33 / 100],
                    [
                        'user' => $this->users['TgnOren'],
                        'result' => 34900 + 12500 / 4 * 33 / 100 + 23500 / 2 * 50 / 100 + 23500 / 2 * 100 / 100
                    ],
                    [
                        'user' => $this->users['Admin'],
                        'result' => 54700 + 12500 / 4 * 33 / 100 + 23500 / 2 * 50 / 100 + 23500 / 2 * 100 / 100 + 31540 / 2 * 33 / 100
                    ],
                ]
            ],
            [
                'project' => $this->projects['habr'],
                'results' => [
                    [
                        'user' => $this->users['Tgn'],
                        'result' => 69900 + 12500 / 4 * 33 / 100 + 12500 / 4 + 12500 / 4 * 50 / 100
                    ],
                    [
                        'user' => $this->users['TgnOren'],
                        'result' => 69900 + 12500 / 4 * 33 / 100 + 12500 / 4 + 12500 / 4 * 50 / 100
                    ],
                    [
                        'user' => $this->users['Admin'],
                        'result' => 89700 + 12500 / 4 * 33 / 100 + 12500 / 4 + 12500 / 4 * 50 / 100 + 31540 / 2 * 33 / 100
                    ],
                ]
            ],
            [
                'project' => $this->projects['stack'],
                'results' => [
                    ['user' => $this->users['Tgn'], 'result' => 29900 + 12500 / 4 * 33 / 100 + 12500 / 4 * 50 / 100],
                    [
                        'user' => $this->users['TgnOren'],
                        'result' => 29900 + 12500 / 4 * 33 / 100 + 12500 / 4 * 50 / 100
                    ],
                    [
                        'user' => $this->users['Admin'],
                        'result' => 49700 + 12500 / 4 * 33 / 100 + 12500 / 4 * 50 / 100 + 31540 / 2 * 33 / 100
                    ],
                ]
            ],
            [
                'project' => $this->projects['ms'],
                'results' => [
                    ['user' => $this->users['Tgn'], 'result' => 50000 + 12500 / 4 * 100 / 100],
                    ['user' => $this->users['TgnOren'], 'result' => 50000 + 12500 / 4 * 100 / 100],
                    ['user' => $this->users['Admin'], 'result' => 50000 + 12500 / 4 * 100 / 100],
                ]
            ],
            [
                'project' => $this->projects['lenta'],
                'results' => [
                    ['user' => $this->users['Tgn'], 'result' => 0],
                    ['user' => $this->users['TgnOren'], 'result' => 0],
                    ['user' => $this->users['Admin'], 'result' => 13 + 31540 / 2 * 100 / 100],
                ]
            ]
        ];

        foreach ($expectations as $expectation) {
            foreach ($expectation['results'] as $expectedUserResult) {
                $spendings = $this->reports[$expectedUserResult['user']->getUsername() . '.project'](
                    $expectation['project']
                )->getAnnualSpendings(
                    $this->testYear
                );
                $checkSummary(
                    $spendings,
                    $expectedUserResult['result'],
                    $expectation['project'] . ': ' . $expectedUserResult['user'] . ' total spendings'
                );
            }
        }
    }

    public function testRegionalYearlyReport()
    {

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
                'region' => 'Tgn',
                'results' => [
                    ['user' => $this->users['Tgn'], 'result' => 12500 + 30000 + 40000 + 40000 + 50000],
                    ['user' => $this->users['TgnOren'], 'result' => 12500 + 30000 + 40000 + 40000 + 50000],
                    ['user' => $this->users['Admin'], 'result' => 12500 + 30000 + 40000 + 40000 + 50000],
                ]
            ],
            [
                'region' => 'Orn',
                'results' => [
                    ['user' => $this->users['Tgn'], 'result' => 0],
                    ['user' => $this->users['TgnOren'], 'result' => 10000 + 20000 + 23500],
                    ['user' => $this->users['Admin'], 'result' => 10000 + 20000 + 23500],
                ]
            ],
            [
                'region' => 'Nsk',
                'results' => [
                    ['user' => $this->users['Tgn'], 'result' => 0],
                    ['user' => $this->users['TgnOren'], 'result' => 0],
                    ['user' => $this->users['Admin'], 'result' => 31540 + 60013],
                ]
            ]
        ];

        foreach ($expectations as $expectation) {
            foreach ($expectation['results'] as $expectedUserResult) {
                $spendings = $this->reports[$expectedUserResult['user']->getUsername()]->getRegionalYearlyReport(
                    $this->regions[$expectation['region']]->getId(),
                    $this->testYear
                );
                $checkSummary(
                    $spendings,
                    $expectedUserResult['result'],
                    $expectation['region'] . ': ' . $expectedUserResult['user'] . ' total spendings'
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