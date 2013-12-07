<?php
namespace Budget\BudgetBundle\Service;

class History
{

    protected $container;

    function __construct($container)
    {
        $this->container = $container;
    }

    private function getPreparedStatement($SQLStatement)
    {
        return $this->container->get('em')->getConnection()->prepare($SQLStatement);
    }

    public function getEmployeeProjectsHistory($employeeId)
    {
        $statement = $this->getPreparedStatement(
            'SELECT
                p.title AS title,
                pi.project_id AS id,
                DATE(r.`timestamp`) AS `timestamp`,
                pi.revtype AS type
            FROM
                ProjectInvolvement_audit pi
                LEFT JOIN Project_audit p ON pi.project_id = p.id
                LEFT JOIN revisions r ON pi.rev = r.id
            WHERE
                pi.employee_id = ' . (int)$employeeId . '
                AND pi.revtype != "UPD"
            ORDER BY
                r.`timestamp` ASC'
        );

        $statement->execute();
        $raw = $statement->fetchAll();
        $data = [];

        $dataTemp = [];

        foreach ($raw as $row) {
            if (!isset($data[$row['id']])) {
                $data[$row['id']] = [
                    'id' => $row['id'],
                    'title' => $row['title'],
                    'dates' => []
                ];
            }
            if (!isset($dataTemp[$row['id']])) {
                $dataTemp[$row['id']] = ['start' => false, 'end' => false];
            }

            if ($row['type'] == 'DEL') {
                $dataTemp[$row['id']]['end'] = ($row['timestamp']);
            } else { //INS
                $dataTemp[$row['id']]['start'] = ($row['timestamp']);
            }

            if ($dataTemp[$row['id']]['start'] && $dataTemp[$row['id']]['end']) {
                $data[$row['id']]['dates'][] = $dataTemp[$row['id']];
                unset($dataTemp[$row['id']]);
            }
        }

        foreach ($dataTemp as $id => $date) {
            $data[$id]['dates'][] = $date;
        }

        return array_values($data);
    }

}