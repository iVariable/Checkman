<?php

namespace Checkman\RESTCheckmanBundle\Controller;

use Checkman\CheckmanBundle\Service\ProjectReports;
use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;
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
class ProjectReportsController extends FOSRestController
{
    /**
     * @param $projectId
     * @return ProjectReports
     */
    private function getProjectReports($projectId)
    {
        return $this->get('checkman.reports')->getProjectReportsForCurrentUser($projectId);
    }

    /**
     * @Route("/project/{projectId}/overall.{_format}", defaults={"_format": "json"}, name="api_v1_reports_project_overall")
     */
    public function projectOverallSummaryAction($projectId, $format = 'json')
    {
        $data = $this->getProjectReports($projectId)->getOverallSummary();

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
        $data = $this->getProjectReports($projectId)->getAnnualSpendings($year);

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
        $data = $this->getProjectReports($projectId)->getMonthSpendings($year, $month);

        $view = $this->view($data, 200)
            ->setFormat($format);

        return $this->handleView($view);
    }

}
