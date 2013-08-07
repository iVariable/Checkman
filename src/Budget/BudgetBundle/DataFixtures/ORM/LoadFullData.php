<?php

namespace Budget\BudgetBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Budget\BudgetBundle\Entity;
use Symfony\Component\DependencyInjection\ContainerAware;

class LoadUserData extends ContainerAware implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        $occupations = $this->loadOccupations($manager);
        $projects = $this->loadProjects($manager);

        $employees = $this->loadEmployees($manager, $occupations, $projects);

    }

    /**
     * @param ObjectManager $manager
     * @return array
     */
    public function loadOccupations(ObjectManager $manager)
    {
        $occupationTitles = [
            "Разработчик. PHP",
            "Разработчик. .NET",
            "Разработчик. JAVA",
            "Верстальщик",
            "Аналитик",
            "Тестировщик",
            "Менеджер проектов",
            "Системный администратор",
            "Дизайнер",
            "Руководитель",
            "Администратор офиса"
        ];

        $occupations = [];

        $repo = $this->container->get('r.occupation');

        foreach ($occupationTitles as $title) {
            /* @var $occupation  \Budget\BudgetBundle\Entity\Occupation*/
            $occupation = $repo->newEntity();
            $occupation->setTitle($title);
            $occupations[] = $occupation;
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
        $projectTitles = [
            "*.softline.ru",
            "edu.softline.ru",
            "Якутск (портал)",
            "Axoft",
            "alsoft.ru",
            "gazprom",
            "store.softline.ru",
        ];

        $projects = [];

        $repo = $this->container->get('r.project');

        foreach ($projectTitles as $title) {
            /* @var $project  \Budget\BudgetBundle\Entity\Project*/
            $project = $repo->newEntity();
            $project->setTitle($title);
            $project->setStatus($project::STATUS_ACTIVE);
            $projects[] = $project;
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
    public function loadEmployees(ObjectManager $manager, $occupations, $projects)
    {
        $employeeData = [
            ["Савенков", "Владимир", 50000],
            ["Клименков", "Александр", 50000],
            ["Петренко", "Якипупко", 20400],
            ["Тратата", "Зергут", 15000],
            ["Осман", "Федько", 32000],
            ["Зюльбаган", "Шерхан", 37000],
            ["Зарган", "Зюган", 17000],
            ["Обложихин", "михаил", 27000],
            ["Хипхап", "Маста", 17040],
        ];

        $employees = [];

        $repo = $this->container->get('r.employee');
        $involvementRepo = $this->container->get('r.project_involvement');

        foreach ($employeeData as $data) {
            /* @var $employee  \Budget\BudgetBundle\Entity\Employee*/
            $employee = call_user_func_array([$repo, "newEntity"], $data);
            $employee->setStatus($employee::STATUS_ACTIVE);

            for ($i = 0, $count = mt_rand(1,3); $i < $count; $i++) {
                $occupation = $occupations[array_rand($occupations)];
                $employee->addOccupation($occupation);
            }
            for ($i =0, $count = mt_rand(1,4); $i < $count; $i++) {
                $project = $projects[array_rand($projects)];
                /* @var $involvement Entity\ProjectInvolvement*/
                $involvement = $involvementRepo->newEntity(
                    $project,
                    $employee,
                    100/$count,
                    ""
                );
                $manager->persist($involvement);
                $employee->addProjectInvolvement($involvement);
            }

            $employees[] = $employee;
            $manager->persist($employee);
        }

        $manager->flush();

        return $employees;
    }
}