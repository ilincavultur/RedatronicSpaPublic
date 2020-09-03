<?php


namespace App\Form;


use App\Entity\Membership;
use App\Entity\Package;
use App\Entity\Product;
use App\Entity\Reception;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReceptionType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'New Client' => Reception::TYPE_NEW_CLIENT ,
                    'Membership' => Reception::TYPE_MEMBERSHIP,
                ],

            ])
            ->get('Type')->addEventListener(
            /**
             * @param FormEvent $event
             */ FormEvents::POST_SUBMIT,
                function (FormEvent $event){
                    $form = $event->getForm();
                    $type = $event->getData();


                    if ($type == Reception::TYPE_MEMBERSHIP) {
                        $form->getParent()->add('Membership', EntityType::class, [
                            'class' => Membership::class,
                            'choice_label' => 'ClientName',
                            'multiple' => false,
                            'expanded' => false,
                        ]);
                        $form->getParent()->add('Products', EntityType::class, [
                            'class' => Product::class,
                            'choice_label' => 'Name',
                            'multiple' => true,
                            'expanded' => true,
                            'mapped' => false
                        ]);
                    }
                    if ($type == Reception::TYPE_NEW_CLIENT){
                        $form->getParent()->add('Rfid', TextType::class);

                        $form->getParent()->add('Age', ChoiceType::class, [
                            'choices' => [
                                'Adult' => Reception::TYPE_ADULT,
                                'Child' => Reception::TYPE_CHILD,
                            ],

                        ]);
                        $form->getParent()->add('Packages', EntityType::class, [
                            'class' => Package::class,
                            'choice_label' => 'Name',
                            'multiple' => true,
                            'expanded' => true,
                            'mapped' => false
                        ]);
                        $form->getParent()->add('Products', EntityType::class, [
                            'class' => Product::class,
                            'choice_label' => 'Name',
                            'multiple' => true,
                            'expanded' => true,
                            'mapped' => false
                        ]);

                    }
                }
            )
        ;


    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reception::class
        ]);
    }

}