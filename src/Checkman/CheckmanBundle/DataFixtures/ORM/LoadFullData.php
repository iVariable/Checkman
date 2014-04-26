<?php

namespace Checkman\CheckmanBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Checkman\CheckmanBundle\Entity;
use Symfony\Component\DependencyInjection\ContainerAware;

class LoadFullData extends ContainerAware implements FixtureInterface
{
    public static $regionsTitles = [
        'Оренбург',
        'Таганрог',
        'Красноярск',
        'Новосибирск',
    ];

    public static $projectTitles = [
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

    public static $occupationTitles = [
        'Региональный руководитель',
         'Офис-менеджер',
         'PHP разработчик',
         '.NET разработчик',
         'JAVA разработчик',
         'Системный аналитик',
         'Тестировщик',
         'Дизайнер',
         'Менеджер проекта',
         'Верстальщик',
         'Системный администратор',
         'iOS разработчик',
         'Android разработчик',
         'WinPhone разработчик'
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