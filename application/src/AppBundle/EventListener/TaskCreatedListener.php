<?php

namespace AppBundle\EventListener;

use AppBundle\Event\TaskCreatedEvent;
use GrossumUA\NotificationBundle\Event\NotificationCreatedEvent;
use GrossumUA\NotificationBundle\Notification\EmailNotification;
use GrossumUA\NotificationBundle\Notification\EntityDataUpdateNotification;
use GrossumUA\NotificationBundle\Notification\MessageNotification;
use GrossumUA\NotificationBundle\Notification\NotificationInterface;
use GrossumUA\NotificationBundle\Notification\PushNotification;
use GrossumUA\NotificationBundle\Notification\SmsNotification;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class TaskCreatedListener
 * @package AppBundle\EventListener
 */
class TaskCreatedListener
{
    /**
     * @var EventDispatcherInterface
     */
    private $disptacher;

    /**
     * TaskCreatedListener constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->disptacher = $dispatcher;
    }

    /**
     * @param TaskCreatedEvent $event
     */
    public function onTaskCreated(TaskCreatedEvent $event)
    {
        $this->sendEmail($event);
        $this->sendUserNotification($event);
        $this->sendUserChatMessage($event);
        $this->sendSms($event);
        $this->sendPushNotification($event);

        $this->sendEntityUpdatePrivate($event);

//        $this->sendEntityUpdatePublic($event); just example
    }

    /**
     * @param TaskCreatedEvent $event
     */
    private function sendEmail(TaskCreatedEvent $event)
    {
        $user = $event->getTask()->getOwner();

        $emailNotification = new EmailNotification();
        $emailNotification
            ->setFromName('symfony cafe')
            ->setFromEmail('symfony@cafe.com')
            ->setReplyTo('symfony@cafe.com')
            ->setSubject('You have created task to demo NotificationBundle')
            ->setPlainText('You have created task to demo NotificationBundle')
            ->setHtml('<h1>You have created task to demo NotificationBundle</h1>')
            ->setToEmail($user->getEmail())
            ->setToName($user->getName());

        $this->disptacher->dispatch(
            'grossum.notification.event.send_email',
            new NotificationCreatedEvent($emailNotification)
        );
    }

    /**
     * @param TaskCreatedEvent $event
     */
    private function sendUserNotification(TaskCreatedEvent $event)
    {
        $user = $event->getTask()->getOwner();
        $userNotification = new MessageNotification();

//        at least one type of content should be set
//        $userNotification->setRenderedContent('<h1>You have created task to demo NotificationBundle</h1>');

        $userNotification
            ->setType(NotificationInterface::SOCKET_NOTIFICATION_TYPE_WEB_NOTIFICATION)
            ->setContent('You have created task to demo NotificationBundle')
            ->setMediaUrl('https://pbs.twimg.com/profile_images/564783819580903424/2aQazOP3.png')
            ->setTitle('You have created task to demo NotificationBundle')
            ->setCreatedAt(new \DateTime())
            ->setRecipientHashes([$user->getId()]);

        $this->disptacher->dispatch(
            'grossum.notification.event.send_notification',
            new NotificationCreatedEvent($userNotification)
        );
    }

    /**
     * @param TaskCreatedEvent $event
     */
    private function sendUserChatMessage(TaskCreatedEvent $event)
    {
        $user = $event->getTask()->getOwner();

        $userNotification = new MessageNotification();

//        at least one type of content should be set
//        $userNotification->setRenderedContent('<h1>You have created task to demo NotificationBundle</h1>');

        $userNotification
            ->setType(NotificationInterface::SOCKET_NOTIFICATION_TYPE_CHAT_MESSAGE)
            ->setContent('You have created task to demo NotificationBundle')
            ->setMediaUrl('https://pbs.twimg.com/profile_images/564783819580903424/2aQazOP3.png')
            ->setTitle('You have created task to demo NotificationBundle')
            ->setCreatedAt(new \DateTime())
            ->setRecipientHashes([$user->getId()]);

        $this->disptacher->dispatch(
            'grossum.notification.event.send_chat_message',
            new NotificationCreatedEvent($userNotification)
        );
    }

    /**
     * @param TaskCreatedEvent $event
     */
    private function sendEntityUpdatePrivate(TaskCreatedEvent $event)
    {
        $user = $event->getTask()->getOwner();
        $task = $event->getTask();

        /** i would recommend serializer (symfony serializer, jms etc.) */
        $entityData = [
            'id'    => $user->getId(),
            'name'  => $user->getName(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'tasks' => [$task->getId()],
        ];

        $entityUpdateNotification = new EntityDataUpdateNotification();
        $entityUpdateNotification
            ->setEntityName('user')
            ->setEntityData($entityData)
            ->setRecipientHashes([$user->getId()]);

        $this->disptacher->dispatch(
            'grossum.notification.event.send_entity_update',
            new NotificationCreatedEvent($entityUpdateNotification)
        );
    }

    /**
     * @param TaskCreatedEvent $event
     */
    private function sendSms(TaskCreatedEvent $event)
    {
        $user = $event->getTask()->getOwner();

        $smsNotification = new SmsNotification();
        $smsNotification
            ->setMessage('You have created task to demo NotificationBundle')
            ->setPhone($user->getPhone());

        $this->disptacher->dispatch(
            'grossum.notification.event.send_sms_message',
            new NotificationCreatedEvent($smsNotification)
        );
    }

    /**
     * @param TaskCreatedEvent $event
     */
    private function sendPushNotification(TaskCreatedEvent $event)
    {
        $user = $event->getTask()->getOwner();

        $pushNotification = new PushNotification();
        $pushNotification
            ->setOsType(NotificationInterface::PHONE_OS_TYPE_IOS)
            ->setIcon('symfony_cafe.png')
            ->setBody('You have created task to demo NotificationBundle')
            ->setTitle('You have created task to demo NotificationBundle')
            ->setRegistrationTokens([$user->getRegistrationToken()]);

        $this->disptacher->dispatch(
            'grossum.notification.event.send_push',
            new NotificationCreatedEvent($pushNotification)
        );
    }
}

