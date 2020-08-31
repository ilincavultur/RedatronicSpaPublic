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
            ->add('Rfid', TextType::class)

            ->add('Age', ChoiceType::class, [
                'choices' => [
                    'Adult' => Reception::TYPE_ADULT,
                    'Child' => Reception::TYPE_CHILD,
                ],

            ])
            ->add('Packages', EntityType::class, [
                'class' => Package::class,
                'choice_label' => 'Name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('Products', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'Name',
                'multiple' => true,
                'expanded' => true,
            ])

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