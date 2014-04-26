<?php

namespace Checkman\CheckmanBundle\DataFixtures\Test;

use Checkman\CheckmanBundle\CheckmanBundle;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Checkman\CheckmanBundle\Entity;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Form\Extension\Core\ChoiceList\ObjectChoiceList;

class LoadTestData extends \Checkman\CheckmanBundle\DataFixtures\ORM\LoadFullData implements FixtureInterface
{
    public static $testDateStart = '01.03.2012';
    public static $testDateEnd = '01.04.2012';

    public static $users = [
        'Admin' => [
            'Orenburg',
            'Moscow',
            'Novosibirsk',
            'New York',
        ],
        'TgnOren' => [
            'Orenburg',
            'Moscow',
        ],
        'Tgn' => [
            'Moscow',
        ]
    ];

    public static $employeeInfo = [
        'Orenburg' => [
            'orn1 1' => [
                'salary' => 10000,
                'projects' => [
                    "yandex.ru",//'yandex.ru',
                    "google.com", //'google.com',
                ]
            ],
            'orn2 2' => [
                'salary' => 20000,
                'projects' => [
                    'yandex.ru'
                ]
            ],
        ],
        'Moscow' => [
            'tgn1 1' => [
                'salary' => 30000,
                'projects' => [
                    'yandex.ru',
                    'habrahabr.ru',
                    "stackoverflow.com"
                ]
            ],
            'tgn2 2' => [
                'salary' => 40000,
                'projects' => [
                    'habrahabr.ru'
                ]
            ],
            'tgn3 2' => [
                'salary' => 40000,
                'projects' => [
                    'habrahabr.ru',
                    'stackoverflow.com'
                ]
            ],
            'tgn4 2' => [
                'salary' => 50000,
                'projects' => [
                    'microsoft.com'
                ]
            ],
        ],
        'Novosibirsk' => [
            'nsk 1' => [
                'salary' => 60000,
                'projects' => [
                    'yandex.ru',
                    'habrahabr.ru',
                    "stackoverflow.com"
                ]
            ],
            'nsk 2' => [
                'salary' => 13,
                'projects' => [
                    'lenta.ru'
                ]
            ],
        ]
    ];


    protected function loadAdditionalData(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->fixSharedSpendings($manager);
    }

    protected function fixSharedSpendings(ObjectManager $manager)
    {
        $sharedSpendings = [
            'Moscow' => 12500,
            'Orenburg' => 23500,
            'Novosibirsk' => 31540,
        ];

        $date = \DateTime::createFromFormat('d.m.Y', self::$testDateStart);

        $spendingsRepo = $this->container->get('r.spendings');

        foreach ($sharedSpendings as $title => $amount) {
            /* @var $spending Spendings */
            $spending = $spendingsRepo->newEntity();

            $spending
                ->setProject($this->sharedProjects[$title])
                ->setDate($date)
                ->setType($this->salaryTypes['Уборка офиса'])
                ->setValue($amount)
            ;

            $manager->persist($spending);
            $manager->flush();
        }

    }

    protected function loadUsers(ObjectManager $manager)
    {

        $manipulator = $this->container->get('fos_user.util.user_manipulator');

        foreach (self::$users as $username => $regions) {
            /** @var $user \Checkman\ApplicationBundle\Entity\User */
            $user = $manipulator->create($username, $username, $username . '@test.local', true, false);
            foreach ($regions as $regionName) {
                $user->addRegion($this->regions[$regionName]);
            }
            $manager->persist($user);
        }
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param $occupations
     * @param $employee
     */
    public function loadEmployees(ObjectManager $manager, $occupations, $projects, $regions)
    {

        $employees = [];

        $repo = $this->container->get('r.employee');
        $involvementRepo = $this->container->get('r.project_involvement');

        foreach (self::$employeeInfo as $regionName => $info) {
            $region = $this->regions[$regionName];
            foreach ($info as $fioString => $eInfo) {
                $fioData = explode(' ', $fioString);
                $data = [
                    $fioData[0],
                    $fioData[1],
                    $eInfo['salary']
                ];
                /* @var $employee  \Checkman\CheckmanBundle\Entity\Employee */
                $employee = call_user_func_array([$repo, "newEntity"], $data);
                $employee->setStatus($employee::STATUS_ACTIVE);

                $employee->addOccupation($occupations[array_rand($occupations)]);
                $employee->setRegion($region);

                foreach ($eInfo['projects'] as $projectName) {
                    $project = $this->projects[$projectName];
                    /* @var $involvement Entity\ProjectInvolvement */
                    $involvement = $involvementRepo->newEntity(
                        $project,
                        $employee,
                        100 / count($eInfo['projects']),
                        ""
                    );
                    $manager->persist($involvement);
                    $employee->addProjectInvolvement($involvement);
                }

                $employees[$fioString] = $employee;
                $manager->persist($employee);
            }
        }


        $manager->flush();

        return $employees;
    }
}