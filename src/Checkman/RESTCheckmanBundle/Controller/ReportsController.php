<?php

namespace Checkman\RESTCheckmanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Templating\Helper\Helper;
use FOS\RestBundle\Controller\Annotations\View;

use FOS\RestBundle\Controller\FOSRestController;

/**
 * Class ReportsController
 * @package Checkman\RESTCheckmanBundle\Controller
 *
 * @Route("/api/v1/reports")
 */
class ReportsController extends FOSRestController
{
    /**
     * @Route(
     *      "/region/{id}/shared-spendings/{year}/{month}.{_format}",
     *      defaults={"id": null, "year": null, "month": null, "_format": "json"},
     *      name="api_v1_reports_region_shared_spendings"
     * )
     */
    public function getRegionSharedSpendingsAction($id, $year, $month, $format="json")
    {
        $date = \DateTime::createFromFormat('d-m-Y', '1-'.$month.'-'.$year);
        $sharedSpengins = $this->get('checkman.reports')->getSharedSpendingsByRegionAndDate($id, $date);

        $view = $this->view($sharedSpengins, 200)
            ->setFormat($format);

        return $this->handleView($view);
    }

    /**
     * @Route("/projects/{year}.{_format}", defaults={"year": null, "_format": "json"}, name="api_v1_reports_projects")
     */
    public function projectsSummaryAction($year = null, $format = 'json')
    {
        if ($year === null) {
            $year = date('Y');
        }
        $data = $this->get('checkman.reports')->getProjectsSummary($year);

        $view = $this->view($data, 200)
            ->setFormat($format);

        return $this->handleView($view);
    }

    /**
     * @Route("/regional/{id}/{year}.{_format}", defaults={"id": null, "year": null, "_format": "json"}, name="api_v1_reports_regional")
     */
    public function regionalYearReportAction($id, $year = null, $format = 'json'){
        if ($year === null) {
            $year = date('Y');
        }
        $data = $this->get('checkman.reports')->getRegionalYearlyReport($id, $year);

        $view = $this->view($data, 200)
            ->setFormat($format);

        return $this->handleView($view);
    }

    /**
     * @Route("/fot/{year}.{_format}", defaults={"year": null, "_format": "json"}, name="api_v1_reports_fot")
     */
    public function fotAction($year = null, $format = 'json')
    {
        if ($year === null) {
            $year = date('Y');
        }
        $data = $this->get('checkman.reports')->getFOT($year);

        $view = $this->view(array_values($data), 200)
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
        $data = $this->get('checkman.reports')->getProjectSummary($projectId, $year);

        $view = $this->view($data, 200)
            ->setFormat($format);

        return $this->handleView($view);
    }

    /**
     * @Route("/project/{projectId}/{year}/{month}.{_format}", defaults={"year": null, "month": null, "_format": "json"}, name="api_v1_reports_project_month_detail")
     */
    public function projectMonthDetailsAction($projectId, $year = null, $month = null, $format = 'json')
    {
        if ($year === null) {
            $year = date('Y');
        }
        if ($month === null) {
            $month = date('m');
        }
        $data = $this->get('checkman.reports')->getProjectMonthDetails($projectId, $year, $month);

        $view = $this->view($data, 200)
            ->setFormat($format);

        return $this->handleView($view);
    }

}
