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
        $this->createSalaryType($manager);

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
            "ВТБ24",
            "*.softline",
            "edu.softline",
            "store.softline",
            "ЕТП",
            "Axoft",
            "Якутск (портал)",
            "Газпром",
            "Альфастрахование",
            "Дезигно-интеро (РОСПАН)",
            "КГУ",
            "Русэнерго",
            "sl-matlab",
            "softcloud.ru",
            "ITMan",
            "МТА внутренний",
            "МТА Внешний",
            "ДГК",
            "Нанословарь",
            "FAST на касперском",
            "Мобильный Якутск",
            "Япошка",
            "Россельхоз",
            "BI-Холдинг",
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
        $fio = [
            "Абдуллаев Руслан Романович",
            "Агишева  Эльвина Марселевна",
            "Акимова Анна Валерьевна",
            "Булычев Сергей Викторович",
            "Гарварт Лилия Игоревна",
            "Гороховская Екатерина Олеговна",
            "Гребенников Дмитрий Николаевич",
            "Дударев Михаил Михайлович",
            "Зюбанов Ярослав Юрьевич",
            "Ибрагимов Тимур Исмаилович",
            "Иванов Алексей Александрович",
            "Икрянников Андрей Викторович",
            "Калдузов Алексей Сергеевич",
            "Каляда Евгений Александрович",
            "Карпочев Павел Игоревич",
            "Кириллов Максим Викторович",
            "Комиссарова Анастасия Валерьяновна",
            "Красноярцев Никата Олегович",
            "Кузьмин Сергей Александрович",
            "Мадар Екатерина Михайловна",
            "Мельков Сергей Николаевич",
            "Минимулин Артур Ринатович",
            "Молчанов Виталий Вячеславович",
            "Молчанова Екатерина Ивановна",
            "Ненашев Виталий Владленович",
            "Никулин Вячеслав Николаевич",
            "Обложихина Елена Александровна",
            "Олизарко Роман Владимирович",
            "Паршута Арсений Александрович",
            "Плохих Сергей Михайлович",
            "Поддубный Евгений Геннадьевич",
            "Пономарев Алексей Борисович",
            "Решетов Антон Анатольевич",
            "Рябин Андрей Юрьевич",
            "Савенков Владимир Владимирович",
            "Садовникова Надежда Михайловна",
            "Седова Дарья Александровна",
            "Селезнев Дмитрий Сергеевич",
            "Серединов Алексей Николаевич",
            "Тимонин Игорь Владимирович",
            "Удовик Александр Викторович",
            "Филатова Ольга Владимировна",
            "Филимошин Олег Владимирович",
            "Фомин Эдуард Михайлович",
            "Фурса Сергей Олегович",
            "Чернов Артур Владимирович",
            "Чернов Василий Вадимович",
            "Шабакаева Лия Рашидовна",
            "Шабанов Сергей Александрович",
            "Шатов Максим Сергеевич",
            "Шкатов Дмитрий Михайлович",
            "Щелков Алексей Иванович"
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
            /* @var $employee  \Budget\BudgetBundle\Entity\Employee*/
            $employee = call_user_func_array([$repo, "newEntity"], $data);
            $employee->setStatus($employee::STATUS_ACTIVE);

            $employee->addOccupation($occupations[array_rand($occupations)]);

            for ($i =0, $count = mt_rand(1,4); $i < $count; $i++) {
                if(mt_rand(0,2) == 1) continue;
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

    /**
     * @param ObjectManager $manager
     */
    public function createSalaryType(ObjectManager $manager)
    {
        /* @var $salarySpendingsType Entity\SpendingsType */
        $salarySpendingsType = $this->container->get('r.spendings_type')->newEntity();

        $salarySpendingsType->setTitle("Зарплата")
            ->setCanBeDeleted(false)
            ->setDescription("");

        $manager->persist($salarySpendingsType);
        $manager->flush();
    }
}