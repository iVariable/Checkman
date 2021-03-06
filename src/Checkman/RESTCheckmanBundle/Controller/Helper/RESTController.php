<?php

namespace Checkman\RESTCheckmanBundle\Controller\Helper;

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
        $view = \FOS\RestBundle\View\View::create()
            ->setStatusCode($code)
            ->setData($data)
            ->setObjectsGroups($groups);

        return $view;

    }

    protected function regionAllowedToUser($region)
    {
        if( $region instanceof \Checkman\CheckmanBundle\Entity\Region ){
            $region = $region->getId();
        }

        return in_array($region, $this->getUser()->getRegionIds());
    }

}
