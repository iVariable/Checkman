<?php

namespace Budget\RESTBudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Templating\Helper\Helper;
use FOS\RestBundle\Controller\Annotations\View;

use FOS\RestBundle\Controller\FOSRestController;

/**
 * Class ReportsController
 * @package Budget\RESTBudgetBundle\Controller
 *
 * @Route("/api/v1/reports")
 */
class ReportsController extends FOSRestController
{
    /**
     * @Route("/projects/{year}.{_format}", defaults={"year": null, "_format": "json"}, name="api_v1_reports_projects")
     */
    public function projectsSummaryAction($year = null, $format = 'json')
    {
        if ($year === null) {
            $year = date('Y');
        }
        $data = $this->get('r.spendings')->report_projectsSummary($year);

        $view = $this->view($data, 200)
            ->setFormat($format);

        return $this->handleView($view);
    }

    /**
     * @Route("/project/{projectId}/{year}.{_format}", defaults={"year": null, "_format": "json"}, name="api_v1_reports_project")
     */
    public function projectSummaryAction($projectId, $year = null, $format = 'json')
    {
        if ($year === null) {
            $year = date('Y');
        }
        $data = $this->get('r.spendings')->report_projectSummary($projectId, $year);

        $view = $this->view($data, 200)
            ->setFormat($format);

        return $this->handleView($view);
    }

}
