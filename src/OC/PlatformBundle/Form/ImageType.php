<?php

namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ImageType extends AbstractType
{
    /**
    * {@inheritdoc}
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('imageFile',FileType::class, array(
                'required' => false,
                'label'    => 'oc.advert.form.label.selectimage',
            ))
        ;

    }

    /**
    * {@inheritdoc}
    */
    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(
            'data_class' => 'OC\PlatformBundle\Entity\Image'
        ));

    }

    /**
    * {@inheritdoc}
    */
    public function getBlockPrefix()
    {
        return 'oc_platformbundle_image';
    }

}
