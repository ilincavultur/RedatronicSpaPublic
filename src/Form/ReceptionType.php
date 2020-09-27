<?php


namespace App\Form;


use App\Entity\Membership;
use App\Entity\Package;
use App\Entity\Product;
use App\Entity\Reception;
use App\Entity\Rfid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\ArrayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormEvents;

class ReceptionType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('Adults', IntegerType::class)
            ->add('Children', IntegerType::class)
            ->add('Package', EntityType::class, [
                'class' => Package::class,
                'choice_label' => 'Name',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('Products', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'Name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('Credit', ChoiceType::class, [
                'choices' => [
                    '10' => Reception::TYPE_TEN ,
                    '50' => Reception::TYPE_FIFTY,
                    '100' => Reception::TYPE_HUNDRED ,
                ],

            ])
            ->add('Rfids', CollectionType::class, [
                'entry_type' => RfidType::class,
                'entry_options' => [
                    'label' => false
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
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