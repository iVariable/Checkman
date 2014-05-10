<?php
namespace Checkman\CheckmanBundle\Service;

use Checkman\ApplicationBundle\Entity\User;

class Factory
{

    private $container;

    /**
     * @return User
     */
    private function getCurrentUser()
    {
        return $this->container->get('security.context')->getToken()->getUser();
    }

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getReportsForUser(User $user)
    {
        return new Reports($this->container, $user);
    }

    public function getReportsForCurrentUser()
    {
        return $this->getReportsForUser($this->getCurrentUser());
    }

    public function getProjectReportsForUser($projectId, User $user)
    {
        $project = $this->container->get('r.project')->findOneById($projectId);
        if (!$project) {
            throw new \Exception('Project not found['.$projectId.']!');
        }

        return new ProjectReports($this->container, $project, $user, $this->getReportsForUser($user));
    }

    public function getProjectReportsForCurrentUser($projectId)
    {
        return $this->getProjectReportsForUser($projectId, $this->getCurrentUser());
    }

}