<?php


namespace App\Form;


use App\Entity\Membership;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembershipType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ClientName', TextType::class)
            ->add('availability', IntegerType::class)
            ->add('Age', IntegerType::class)
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'Adult' => Membership::TYPE_ADULT ,
                    'Child' => Membership::TYPE_CHILD,
                ],

            ])
            ->add('Products', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'Name',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('NoOfEntries', IntegerType::class)
            ->add('RFID', TextType::class);

        ;


    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Membership::class
        ]);
    }

}