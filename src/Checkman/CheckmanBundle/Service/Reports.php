<?php
namespace Checkman\CheckmanBundle\Service;

use Checkman\ApplicationBundle\Entity\User;

/**
 * Created by PhpStorm.
 * User: vladimirsavenkov
 * Date: 11/2/13
 * Time: 12:44 PM
 */

class Reports
{

    protected $container;
    protected $user;
    protected $allowedRegionIds = [];

    function __construct($container, User $user)
    {
        $this->container = $container;
        $this->user = $user;
        $this->allowedRegionIds = $user->getRegionIds();
    }

    private function getPreparedStatement($SQLStatement)
    {
        return $this->container->get('em')->getConnection()->prepare($SQLStatement);
    }

    /**
     * Getting total sum of shared spendings for region
     * @param $regionId
     * @param \DateTime $date
     * @return array
     */
    public function getSharedSpendingsByRegionAndDate($regionId, \DateTime $date)
    {
        //Подсчет количества сотрудников работавших в регионе в выбранный месяц
        $result = $this->getPreparedStatement(
            'SELECT COUNT(*) as cnt FROM (
                SELECT
                    s.id
                FROM Spendings s
                LEFT JOIN
                    Employee e ON s.employee_id=e.id
                WHERE
                    MONTH(s.`date`)="' . $date->format('m') . '"
                        AND YEAR(s.`date`)="' . $date->format('Y') . '"
                        AND s.employee_id IS NOT NULL
                        AND e.region_id="' . (int)$regionId . '"
                    GROUP BY employee_id
                 ) s'
        );
        $result->execute();

        $employeesInRegion = $result->fetchColumn();
        $result->closeCursor();

        $sharedProjects = $this->container->get('r.project')->getSharedProjectsByRegionId($regionId);

        $that = $this;

        $totalSharedSum = array_reduce(
            $sharedProjects,
            function ($sum, $project) use ($that, $date) {
                //@TODO OMG
                $report = $that->container->get('checkman.reports')->getProjectReportsForUser($project->getId(), $that->user);
                $details = $report->getMonthSpendings_Clear(
                    $date->format('Y'),
                    $date->format('m')
                );
                $projectTotal = array_reduce(
                    $details,
                    function ($sum, $detail) {
                        return $sum + $detail['total'];
                    },
                    0
                );

                return $sum + $projectTotal;
            },
            0
        );

        return [
            'employees' => $employeesInRegion,
            'totalSharedSum' => $totalSharedSum,
            'perEmployee' => ($employeesInRegion > 0) ?
                    $totalSharedSum / $employeesInRegion :
                    $totalSharedSum,
            'perEmployeeDay' => ($employeesInRegion > 0) ?
                    ($totalSharedSum / $employeesInRegion) / $date->format('t') :
                    $totalSharedSum / $date->format('t'),
        ];
    }

    public function getProjectsSummary($year)
    {
        $result = $this->getProjectsSummaryClear($year);

        foreach ($result as &$yearResult) {
            //WHAT?
            if (!$yearResult['project_id']) continue;
            //@TODO OMG
            $report = $this->container->get('checkman.reports')->getProjectReportsForUser($yearResult['project_id'], $this->user);
            $sharedSpendings = $report->getMonthSharedSpendings(
                $year,
                $yearResult['month']
            );
            $yearResult['total'] += $sharedSpendings['total'];
        }

        return $result;
    }

    /**
     * Grand summary for all projects
     *
     * @param $year
     * @return array
     */
    public function getProjectsSummaryClear($year)
    {
        $result = $this->getPreparedStatement(
            'SELECT
                s.project_id,
                MONTH(s.date) AS month,
                SUM(s.value) AS total
            FROM
                Spendings s
                LEFT JOIN Employee e ON s.employee_id=e.id
            WHERE
                YEAR(s.date)="' . (int)$year . '"
                AND
                ( e.id IS NULL OR e.region_id IN ('.implode(',', $this->allowedRegionIds).'))
            GROUP BY
                s.project_id,MONTH(s.date)'
        );
        $result->execute();

        return $result->fetchAll();
    }

    public function getRegionalYearlyReport($id, $year)
    {
        $result = $this->getPreparedStatement(
            'SELECT
                s.type_id,
                st.title AS type,
                MONTH(s.date) AS `month`,
                SUM(s.value) AS total,
                COUNT(s.id) AS rows
            FROM Spendings s
            LEFT JOIN SpendingsType st ON s.type_id=st.id
            LEFT JOIN Employee e ON s.employee_id=e.id
            LEFT JOIN Region r ON e.region_id=r.id
            LEFT JOIN Project p ON s.project_id=p.id
            LEFT JOIN Region r2 ON p.region_id=r2.id
            WHERE
                YEAR(s.date)="' . (int)$year . '"
                AND
                (
                    r.id = '.(int)$id.'
                    OR
                    r2.id = '.(int)$id.'
                )
                AND ( r.id IN ('.implode(',', $this->allowedRegionIds).') OR r2.id IN ('.implode(',', $this->allowedRegionIds).'))
            GROUP BY
                s.type_id, MONTH(s.date)'
        );
        $result->execute();

        $data = $result->fetchAll();

        return $data;
    }

    public function getFOT($year, $regionId = null)
    {
        $salaryType = $this->container->get('r.spendings_type')->getSalaryType();
        $raw = $this->getPreparedStatement(
            'SELECT
                MONTH(s.date) as month,
                e.region_id AS employee_region_id,
                s.employee_id AS employee_id,
                SUM(s.value) AS total
            FROM Spendings s
            LEFT JOIN SpendingsType st ON s.type_id=st.id
            LEFT JOIN Employee e ON s.employee_id=e.id
            WHERE
                YEAR(s.date)="' . (int)$year . '"
                AND
                s.type_id="' . (int)$salaryType->getId() . '"
                AND ( e.id IS NULL OR e.region_id IN ('.implode(',', $this->allowedRegionIds).'))
            GROUP BY
                s.employee_id, MONTH(s.date)'
        );
        $raw->execute();

        $data = $raw->fetchAll();

        $result = [];

        foreach ($data as $dataRow) {
            if ($regionId && $regionId != $dataRow['employee_region_id']) {
                continue;
            }
            if (!array_key_exists($dataRow['employee_id'], $result)) {
                $result[$dataRow['employee_id']] = [
                    'employee_id' => $dataRow['employee_id'],
                    'months' => [
                        1 => 0,
                        2 => 0,
                        3 => 0,
                        4 => 0,
                        5 => 0,
                        6 => 0,
                        7 => 0,
                        8 => 0,
                        9 => 0,
                        10 => 0,
                        11 => 0,
                        12 => 0,
                    ]
                ];
            };
            $result[$dataRow['employee_id']]['months'][$dataRow['month']] = $dataRow['total'];
        }

        return $result;
    }


}