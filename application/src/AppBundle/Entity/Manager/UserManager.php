<?php

namespace AppBundle\Entity\Manager;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class UserManager
 * @package AppBundle\Entity\Manager
 */
class UserManager
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
     * @return User
     */
    public static function getUsers()
    {
        $userDataList = [
            [
                'name' => 'Jhon',
                'email' => 'Jhon@email.com',
                'phone' => '235682364523',
                'registrationToken' => 'dsf8a87asdfa98sdf'
            ],
            [
                'name' => 'Peter',
                'email' => 'Peter@email.com',
                'phone' => '235682364523',
                'registrationToken' => 'dsf8a87asdfa98sdf'
            ],
            [
                'name' => 'Vincent',
                'email' => 'Vincent@email.com',
                'phone' => '235682364523',
                'registrationToken' => 'dsf8a87asdfa98sdf'
            ],
        ];

        $users = [];
        foreach ($userDataList as $userData) {
            $user = new User();
            $user->setName($userData['name']);
            $user->setPhone($userData['phone']);
            $user->setEmail($userData['email']);
            $user->setRegistrationToken($userData['registrationToken']);

            $users[] = $user;
        }

        return $users;
    }
}