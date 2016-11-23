<?php

namespace AppBundle\Entity\Manager;

use AppBundle\Entity\Task;
use AppBundle\Event\TaskCreatedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class TaskManager
 * @package AppBundle\Entity\Manager
 */
class TaskManager
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * OfferManager constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Task $task
     *
     * @return Task
     * @throws \Exception
     */
    public function create(Task $task)
    {
        $this->dispatcher->dispatch('task.created', new TaskCreatedEvent($task));

        return $task;
    }
}
