<?php

namespace Checkman\CheckmanBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Checkman\CheckmanBundle\Entity;
use Symfony\Component\DependencyInjection\ContainerAware;

class LoadFullData extends ContainerAware implements FixtureInterface
{
    public static $regionsTitles = [
        'Orenburg',
        'Moscow',
        'Novosibirsk',
        'New York',
    ];

    public static $projectTitles = [
        "yandex.ru",
        "google.com",
        "habrahabr.ru",
        "stackoverflow.com",
        "lenta.ru",
        "alfabank.ru",
        "microsoft.com",
        "apple.com",
        "translate.google.com",
        "yandex.ru (android)",
        "yandex.ru (ios)",
        "yandex.ru (winphone)",
        "cnn.com",
        "porn.com",
        "twitch.com",
        "twitter.com",
        "instagram",
    ];

    public static $occupationTitles = [
        "PHP developer",
        "System analyst",
        "Frontend developer",
        "QA engineer",
        "Designer",
        "JS developer",
        "iOS developer",
        "Android developer",
        "WinPhone developer",
        ".NET developer",
        "JAVA developer",
        "Project manager",
        "System administrator",
        "Office manager",
        "Head of dept.",
    ];

    protected $occupations;
    protected $projects;
    protected $sharedProjects;
    protected $regions;
    protected $salaryTypes;
    protected $employees;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->salaryTypes = $this->createSalaryTypes($manager);

        $this->occupations = $occupations = $this->loadOccupations($manager);
        $this->projects = $projects = $this->loadProjects($manager);
        $this->regions = $regions = $this->loadRegions($manager);
        $this->sharedProjects = $this->createSharedProjects($manager, $regions);

        $this->employees = $this->loadEmployees($manager, $occupations, $projects, $regions);

        $this->loadAdditionalData($manager);
    }

    protected function loadAdditionalData(ObjectManager $manager)
    {
        //for extension
    }

    public function loadRegions(ObjectManager $manager)
    {
        $regions = [];

        $repo = $this->container->get('r.region');

        foreach (self::$regionsTitles as $title) {
            /* @var $region  \Checkman\CheckmanBundle\Entity\Region */
            $region = $repo->newEntity();
            $region->setTitle($title);
            $regions[$title] = $region;
            $manager->persist($region);
        }

        $manager->flush();

        return $regions;
    }

    public function createSharedProjects(ObjectManager $manager, $regions)
    {
        $sharedProjects = [];

        $repo = $this->container->get('r.project');
        foreach ($regions as $region) {
            /* @var $project  \Checkman\CheckmanBundle\Entity\Project */
            $project = $repo->newEntity();
            $project->setTitle('Офис. ' . $region->getTitle());
            $project->setRegion($region);
            $project->setStatus($project::STATUS_ACTIVE);
            $manager->persist($project);
            $sharedProjects[$region->getTitle()] = $project;
        }

        $manager->flush();

        return $sharedProjects;
    }

    /**
     * @param ObjectManager $manager
     * @return array
     */
    public function loadOccupations(ObjectManager $manager)
    {
        $occupations = [];

        $repo = $this->container->get('r.occupation');

        foreach (self::$occupationTitles as $title) {
            /* @var $occupation  \Checkman\CheckmanBundle\Entity\Occupation */
            $occupation = $repo->newEntity();
            $occupation->setTitle($title);
            $occupations[$title] = $occupation;
            $manager->persist($occupation);
        }

        $manager->flush();

        return $occupations;
    }

    /**
     * @param ObjectManager $manager
     */
    public function loadProjects(ObjectManager $manager)
    {
        $projects = [];

        $repo = $this->container->get('r.project');

        foreach (self::$projectTitles as $title) {
            /* @var $project  \Checkman\CheckmanBundle\Entity\Project */
            $project = $repo->newEntity();
            $project->setTitle($title);
            $project->setStatus($project::STATUS_ACTIVE);
            $projects[$title] = $project;
            $manager->persist($project);
        }

        $manager->flush();

        return $projects;
    }

    /**
     * @param ObjectManager $manager
     * @param $occupations
     * @param $employee
     */
    public function loadEmployees(ObjectManager $manager, $occupations, $projects, $regions)
    {
        $fio = [
            "Steve Jobs",
            "Bill Gates",
            "Vladimir Savenkov",
            "Strager Lol",
            "Linus Torvalds",
            "Fabien Potencier",
            "Trash bin",
            "Walter White",
            "Superman Alibabaevich",
            "Barak Obama",
            "Vladimir Putin",
            "Alla Pugacheva",
            "Jessie Pinkman",
            "Indiana Jones",
            "Steve Vai",
            "Andrey Golubev",
            "Nobody man",
            "Daenerys Targaryen",
            "Ned Stark",
            "Arya Stark",
            "Luke Skywalker",
            "Obiwan Kenobi",
            "MonkeyD Luffy",
            "Lady Gaga",
            "Ayshwaria Rai",
            "Alexey Navalny",
        ];

        $employees = [];

        $repo = $this->container->get('r.employee');
        $involvementRepo = $this->container->get('r.project_involvement');

        foreach ($fio as $fioString) {
            $fioData = explode(' ', $fioString);
            $data = [
                $fioData[0],
                $fioData[1],
                mt_rand(10000, 50000)
            ];
            /* @var $employee  \Checkman\CheckmanBundle\Entity\Employee */
            $employee = call_user_func_array([$repo, "newEntity"], $data);
            $employee->setStatus($employee::STATUS_ACTIVE);

            $employee->addOccupation($occupations[array_rand($occupations)]);
            $employee->setRegion($regions[array_rand($regions)]);

            for ($i = 0, $count = mt_rand(1, 4); $i < $count; $i++) {
                if (mt_rand(0, 2) == 1) {
                    continue;
                }
                $project = $projects[array_rand($projects)];
                /* @var $involvement Entity\ProjectInvolvement */
                $involvement = $involvementRepo->newEntity(
                    $project,
                    $employee,
                    100 / $count,
                    ""
                );
                $manager->persist($involvement);
                $employee->addProjectInvolvement($involvement);
            }

            $employees[$fioString] = $employee;
            $manager->persist($employee);
        }

        $manager->flush();

        return $employees;
    }

    /**
     * @param ObjectManager $manager
     */
    public function createSalaryTypes(ObjectManager $manager)
    {
        $types = [];

        $typeTitles = [
            'Зарплата',
            'Премия',
            'Железо',
            'Командировка',
            'Уборка офиса',
        ];

        foreach ($typeTitles as $type) {
            /* @var $salarySpendingsType Entity\SpendingsType */
            $salarySpendingsType = $this->container->get('r.spendings_type')->newEntity();

            $salarySpendingsType->setTitle($type)
                ->setCanBeDeleted(false)
                ->setDescription("");

            $manager->persist($salarySpendingsType);
            $types[$type] = $salarySpendingsType;
        }

        $manager->flush();

        return $types;
    }
}