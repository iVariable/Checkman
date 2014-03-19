<?php
namespace Budget\RESTBudgetBundle\Listener;

/**
 * Class SpendingsSerializationListener
 *
 * @package Budget\RESTBudgetBundle\Listener
 */
class SpendingsSerializationListener
{

    private $allowedRegionsIds = [];

    public function __construct(\Symfony\Component\Security\Core\SecurityContext $security)
    {
        $user = $security->getToken()->getUser();
        $this->allowedRegionsIds = $user->getRegionIds();
    }

    public function onPreSerialize(\JMS\Serializer\EventDispatcher\PreSerializeEvent $event)
    {
        if ($event->getObject()->getEmployee()
            &&
            !in_array($event->getObject()->getEmployee()->getRegion()->getId(), $this->allowedRegionsIds)
        ) {
            $event->getObject()->setValue(null);
        }
    }
}