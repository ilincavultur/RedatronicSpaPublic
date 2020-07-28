<?php



use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name', TextType::class)
            ->add('Code', TextType::class)
            ->add('Barcode', TextType::class)
            ->add('Price', IntegerType::class)
            ->add('WeekendPrice', IntegerType::class)
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'Restaurant' => 'Restaurant',
                    'Bar' => 'Bar',
                    'Service' => 'Service',
                ],

            ])
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class
        ]);
    }


}

