<?php

namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use OC\PlatformBundle\Form\ImageType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use OC\PlatformBundle\Repository\CategoryRepository;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;


class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // $pattern = 'D%';

        $builder
          ->add('date',      DateTimeType::class)
          ->add('title',     TextType::class)
          ->add('author',    TextType::class)
          ->add('content',   TextareaType::class)
          ->add('image',     ImageType::class, array(
            'required' => false,
            'label'    => false
            ))
            
          ->add('categories', EntityType::class, array(
            'class'        => 'OCPlatformBundle:Category',
            'choice_label' => 'name',
            'multiple'     => true,
            'required'     => false
            // 'query_builder' => function(CategoryRepository $repository) use($pattern) {
            //   return $repository->getLikeQueryBuilder($pattern);
            // }
           ))

          ->add('save',      SubmitType::class)

          ->addEventListener(
              FormEvents::PRE_SET_DATA,
              function(FormEvent $event) { 

                $advert = $event->getData();

                if (null === $advert) return;

                // Si l'annonce n'est pas publiée, ou si elle n'existe pas encore en base (id est null)
                if (!$advert->getPublished() || null === $advert->getId())
                  // Alors on ajoute le champ published
                  $event->getForm()->add('published', CheckboxType::class, array('required' => false));
                else
                  // Sinon, on le supprime
                  $event->getForm()->remove('published');
              
              }
          )
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\PlatformBundle\Entity\Advert'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'oc_platformbundle_advert';
    }


}
