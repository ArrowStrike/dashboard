<?php
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Your email address',
                ]
            )
            ->add(
                'username',
                TextType::class,
                [
                    'label' => 'Your Username',
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'attr' => [
                        'rows' => 10,
                    ],
                    'label' => 'Your Message',
                ]
            )
            ->add(
                'save',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn btn-lg btn-success btn-block',
                    ],
                ]
            );
    }

}