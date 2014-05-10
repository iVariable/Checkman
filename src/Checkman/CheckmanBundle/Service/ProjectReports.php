<?php
namespace Checkman\CheckmanBundle\Service;

use Checkman\ApplicationBundle\Entity\User;
use Checkman\CheckmanBundle\Entity\Project;
use Doctrine\DBAL\Driver\Statement;

class ProjectReports
{

    protected $container;
    protected $allowedRegionIds = [];
    /** @var \Checkman\CheckmanBundle\Entity\Project  */
    protected $project;
    protected $reports;

    function __construct($container, Project $project, User $user, $reports)
    {
        $this->container = $container;
        $this->project = $project;
        $this->allowedRegionIds = $user->getRegionIds();
        $this->reports = $reports;
    }

    /**
     * @param $SQLStatement
     * @return Statement
     */
    private function getPreparedStatement($SQLStatement)
    {
        return $this->container->get('em')->getConnection()->prepare($SQLStatement);
    }

    public function getOverallSummary()
    {
        $result = [
            'overallSpendings' => $this->getOverallSpendings(),
            'employeesInvolved' => $this->getOverallEmployeesInvolved(),
            'overallManDays' => $this->getOverallManDays(),
            'dateStart' => $this->getStartDate(),
        ];

        return $result;
    }

    public function getOverallManDays()
    {
        $manDays = $this->getPreparedStatement('SELECT
                SUM(s.extra/100) AS total
            FROM
                Spendings s
            WHERE
                s.project_id='.(int)$this->project->getId().'
        ');
        $manDays->execute();
        return $manDays->fetchAll()[0]['total'];
    }

    public function getStartDate()
    {
        $startDate = $this->getPreparedStatement('SELECT
                YEAR(s.date) AS `year`,
                MONTH(s.date) AS `month`,
                DAY(s.date) AS `day`
            FROM
                Spendings s
            WHERE
                s.project_id='.(int)$this->project->getId().'
            ORDER BY
                s.date ASC
            LIMIT 1
        ');
        $startDate->execute();
        $result = $startDate->fetchAll();
        if($result){
            $result = $result[0];
        }else{
            $result = [
                'year' => 1970,
                'month' => 1,
                'day' => 1
            ];
        }
        return $result;
    }

    public function getOverallEmployeesInvolved()
    {
        $employees = $this->getPreparedStatement('SELECT
                e.id,
                e.firstName,
                e.secondName,
                e.region_id,
                e.status,
                e.notes
            FROM
                Spendings s
                LEFT JOIN Employee e ON s.employee_id=e.id
            WHERE
                s.project_id='.(int)$this->project->getId().'
            GROUP BY
                e.id
        ');
        $employees->execute();
        return $employees->fetchAll();
    }

    public function getOverallSpendings()
    {
        $startYear = $this->getStartDate()['year'];
        $result = [];
        for ($year = $startYear, $currentYear = date('Y'); $year <= $currentYear; $year++) {
            $result[$year] = array_reduce($this->getAnnualSpendings($year), function($sum, $element){
                return $sum + $element['total'];
            }, 0);
        }
        return $result;
    }

    /**
     * Project summary for a year
     *
     * @param $projectId
     * @param $year
     * @return mixed
     */
    public function getAnnualSpendings($year)
    {
        $projectId = $this->project->getId();
        $result = $this->getAnnualSpendings_Clear($year);

        for ($i = 1; $i < 13; $i++) {
            $result[] = $this->getMonthSharedSpendings($year, $i);
        }

        return $result;
    }

    public function getMonthSharedSpendings($year, $month)
    {
        $projectId = $this->project->getId();
        $project = $this->container->get('r.project')->findOneById($projectId);
        $totalSum = 0;

        if ($project && !$project->getRegion()) {

            $salaryType = $this->container->get('r.spendings_type')->getSalaryType();

            $reports = $this->getMonthSpendings_Clear($year, $month);

            $sharedSpendings = [];

            $startDate = \DateTime::createFromFormat('d-m-Y', '1-' . $month . '-' . $year);
            /**
             * pzdc
             */
            $endDate = \DateTime::createFromFormat('U', strtotime('+1 month', $startDate->getTimestamp()));
            foreach ($reports as &$report) {
                if ($report['type_id'] != $salaryType->getId()) {
                    continue;
                }
                if (!in_array($report['employee_region_id'], $this->allowedRegionIds)) continue;
                if (!array_key_exists($report['employee_region_id'], $sharedSpendings)) {
                    $sharedSpendings[$report['employee_region_id']] = $this->reports->getSharedSpendingsByRegionAndDate(
                        $report['employee_region_id'],
                        $startDate
                    );
                }
                $sharedSpending = $sharedSpendings[$report['employee_region_id']];

                $spendings = $this->container->get('r.spendings')->getByDates(
                    $startDate,
                    $endDate,
                    [
                        'employee_id' => $report['employee_id'],
                        'type_id' => $salaryType->getId(),
                        'project_id' => $projectId
                    ]
                );
                $totalSum += array_reduce(
                    $spendings,
                    function ($sum, $spending) use ($sharedSpending) {
                        return $sum + ($sharedSpending['perEmployeeDay'] / 100 * $spending->getExtra());
                    },
                    0
                );

            }
        }

        return [
            'type_id' => 0,
            'type' => 'Затраты на содержание офиса',
            'total' => $totalSum,
            'rows' => 1,
            'month' => $month,
            'description' => ['Затраты на содержание офиса. Аггрегация.']
        ];

    }

    /**
     * Detailed monthly report WITH shared cost part (from shared project)
     *
     * @param $projectId
     * @param $year
     * @param $month
     * @return array
     */
    public function getMonthSpendings($year, $month)
    {
        $projectId = $this->project->getId();
        $reports = $this->getMonthSpendings_Clear($year, $month);

        $reports[] = $this->getMonthSharedSpendings($year, $month);

        return $reports;
    }

    public function getAnnualSpendings_Clear($year = false)
    {
        $projectId = $this->project->getId();
        $result = $this->getPreparedStatement(
            'SELECT
                s.type_id,
                st.title AS type,
                MONTH(s.date) AS month,
                SUM(s.value) AS total
            FROM Spendings s
            LEFT JOIN SpendingsType st ON s.type_id=st.id
            LEFT JOIN Employee e ON s.employee_id=e.id
            WHERE
                '.($year?'YEAR(s.date)="' . (int)$year . '" AND':'').'
                s.project_id="' . (int)$projectId . '"
                AND
                ( e.id IS NULL OR e.region_id IN ('.implode(',', $this->allowedRegionIds).'))
            GROUP BY
                s.type_id, MONTH(s.date)'
        );
        $result->execute();

        return $result->fetchAll();
    }

    /**
     * Without shared part of cost (from shared projects)
     *
     * @param $projectId
     * @param $year
     * @param $month
     * @return array
     */
    public function getMonthSpendings_Clear($year, $month)
    {
        $projectId = $this->project->getId();
        $result = $this->getPreparedStatement(
            'SELECT
                s.type_id,
                st.title AS type,
                e.region_id AS employee_region_id,
                s.employee_id AS employee_id,
                SUM(s.value) AS total,
                COUNT(s.id) AS rows,
                GROUP_CONCAT(s.description SEPARATOR " -|- ") AS description
            FROM Spendings s
            LEFT JOIN SpendingsType st ON s.type_id=st.id
            LEFT JOIN Employee e ON s.employee_id=e.id
            WHERE
                YEAR(s.date)="' . (int)$year . '"
                    AND MONTH(s.date)="' . (int)$month . '"
                    AND s.project_id="' . (int)$projectId . '"
                    AND ( e.id IS NULL OR e.region_id IN ('.implode(',', $this->allowedRegionIds).'))
                GROUP BY
                    s.type_id, s.employee_id'
        );
        $result->execute();

        $data = $result->fetchAll();

        $data = array_map(
            function ($element) {
                $element['description'] = explode('-|-', $element['description']);

                return $element;
            },
            $data
        );

        return $data;
    }


}