<?php

namespace Budget\BudgetBundle\DataFixtures\Test;

use Budget\BudgetBundle\BudgetBundle;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Budget\BudgetBundle\Entity;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Form\Extension\Core\ChoiceList\ObjectChoiceList;

class LoadTestData extends \Budget\BudgetBundle\DataFixtures\ORM\LoadFullData implements FixtureInterface
{
    public static $testDateStart = '01.03.2012';
    public static $testDateEnd = '01.04.2012';

    public static $users = [
        'Admin' => [
            'Оренбург',
            'Таганрог',
            'Красноярск',
            'Новосибирск',
        ],
        'TgnOren' => [
            'Оренбург',
            'Таганрог',
        ],
        'Tgn' => [
            'Таганрог',
        ]
    ];

    public static $employeeInfo = [
        'Оренбург' => [
            'orn1 1' => [
                'salary' => 10000,
                'projects' => [
                    'ВТБ24',
                    'Газпром'
                ]
            ],
            'orn2 2' => [
                'salary' => 20000,
                'projects' => [
                    'ВТБ24'
                ]
            ],
        ],
        'Таганрог' => [
            'tgn1 1' => [
                'salary' => 30000,
                'projects' => [
                    'ВТБ24',
                    '*.softline',
                    "ЕТП"
                ]
            ],
            'tgn2 2' => [
                'salary' => 40000,
                'projects' => [
                    '*.softline'
                ]
            ],
            'tgn3 2' => [
                'salary' => 40000,
                'projects' => [
                    '*.softline',
                    'ЕТП'
                ]
            ],
            'tgn4 2' => [
                'salary' => 50000,
                'projects' => [
                    'edu.softline'
                ]
            ],
        ],
        'Новосибирск' => [
            'nsk 1' => [
                'salary' => 60000,
                'projects' => [
                    'ВТБ24',
                    '*.softline',
                    "ЕТП"
                ]
            ],
            'nsk 2' => [
                'salary' => 13,
                'projects' => [
                    'Альфастрахование'
                ]
            ],
        ]
    ];


    protected function loadAdditionalData(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        //$this->fixSpendings($manager);
    }

    protected function loadUsers(ObjectManager $manager)
    {

        $manipulator = $this->container->get('fos_user.util.user_manipulator');

        foreach (self::$users as $username => $regions) {
            /** @var $user \Budget\ApplicationBundle\Entity\User */
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
                /* @var $employee  \Budget\BudgetBundle\Entity\Employee */
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