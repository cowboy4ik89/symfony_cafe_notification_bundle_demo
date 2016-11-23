<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class User
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $registrationToken;

    /**
     * @var Task[]
     */
    private $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->id = random_bytes(5);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return Task[]
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }

    /**
     * @param Task[] $tasks
     */
    public function setTasks(array $tasks)
    {
        $this->tasks = $tasks;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return array
     */
    public function getRegistrationToken()
    {
        return $this->registrationToken;
    }

    /**
     * @param string $registrationToken
     */
    public function setRegistrationToken(string $registrationToken)
    {
        $this->registrationToken = $registrationToken;
    }

}