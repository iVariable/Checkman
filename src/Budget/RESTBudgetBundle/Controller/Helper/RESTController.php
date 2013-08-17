<?php

namespace Budget\RESTBudgetBundle\Controller\Helper;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RESTController extends Controller
{
    /**
     * @param mixed $data
     * @param array $groups
     * @param int $code
     * @return \FOS\RestBundle\View
     */
    protected function getView($data, $groups = null, $code = 200)
    {
        $view = \FOS\RestBundle\View::create()
            ->setStatusCode($code)
            ->setData($data)
            ->setObjectsGroups($groups);

        return $view;

    }

}
