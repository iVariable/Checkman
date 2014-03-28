<?php
namespace Budget\BudgetBundle\Service;

use Budget\ApplicationBundle\Entity\User;

class Factory {

    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function getReportsForUser(User $user) {
        return new Reports($this->container, $user);
    }

    public function getReportsForCurrentUser() {
        return new Reports($this->container, $this->container->get('security.context')->getToken()->getUser());
    }

}