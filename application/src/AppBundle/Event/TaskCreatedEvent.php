<?php

namespace AppBundle\Event;

use AppBundle\Entity\Task;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class TaskCreatedEvent
 * @package AppBundle\Event
 */
class TaskCreatedEvent extends Event
{
    /**
     * @var Task
     */
    private $task;

    /**
     * TaskCreatedEvent constructor.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }
}