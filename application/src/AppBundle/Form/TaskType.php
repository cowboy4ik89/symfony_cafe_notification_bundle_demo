<?php

namespace AppBundle\Form;

use AppBundle\Entity\Manager\UserManager;
use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Class TaskType
 * @package AppBundle\Form
 */
class TaskType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add(
                'owner',
                ChoiceType::class,
                [
                    'choices'      => UserManager::getUsers(),
                    'choice_label' => function ($user, $key, $index) {
                        /** @var User $user */
                        return strtoupper($user->getName());
                    },
                    'choice_attr'  => function ($user, $key, $index) {
                        /** @var User $user */
                        return ['class' => 'user_' . strtolower($user->getName())];
                    },
                ]
            )
            ->add('save', SubmitType::class, array('label' => 'Create Task'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'AppBundle\Entity\Task',
            'csrf_protection'    => false,
            'allow_extra_fields' => true,
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'task';
    }
}
