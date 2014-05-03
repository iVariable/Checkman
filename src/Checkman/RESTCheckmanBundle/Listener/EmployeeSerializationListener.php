<?php
namespace Checkman\RESTCheckmanBundle\Listener;

/**
 * Class EmployeeSerializationListener
 *
 * @package Checkman\RESTCheckmanBundle\Listener
 */
class EmployeeSerializationListener
{

    private $allowedRegionsIds = [];
    private $salaries = [];

    public function __construct(\Symfony\Component\Security\Core\SecurityContext $security)
    {
        $user = $security->getToken()->getUser();
        $this->allowedRegionsIds = $user->getRegionIds();
    }

    public function onPreSerialize(\JMS\Serializer\EventDispatcher\PreSerializeEvent $event)
    {
        if ($event->getObject()->getRegion() && !in_array($event->getObject()->getRegion()->getId(), $this->allowedRegionsIds)) {
            $this->salaries[] = $event->getObject()->getSalary();
            $event->getObject()->setSalary(null);
        }
    }

    public function onPostSerialize(\JMS\Serializer\EventDispatcher\ObjectEvent $event)
    {
        if ($event->getObject()->getRegion() && !in_array($event->getObject()->getRegion()->getId(), $this->allowedRegionsIds)) {
            $event->getObject()->setSalary(array_pop($this->salaries));
        }
    }
}