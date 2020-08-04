<?php


namespace App\Form;


use App\Entity\Package;
use App\Entity\Product;
use App\Entity\Zone;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PackageType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name', TextType::class)
            ->add('Price', IntegerType::class)
            ->add('Zones', EntityType::class, [
                'class' => Zone::class,
                'choice_label' => 'Name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('Products', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'Name',
                'multiple' => true,
                'expanded' => true,
            ]);

        ;


    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Package::class
        ]);
    }

}