<?php

namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
            ->add('image',     ImageType::class, array(
                'required' => false,
                'label'    => false
            ))
            ->add('delete_image', CheckboxType::class, array(
                'required' => false,
                'label' => "oc.advert.form.label.noimage",
                // 'mapped'   => false
            ))
            ->add('date',      DateTimeType::class, array(
                'label' => "oc.advert.form.label.creationdate",
            ))
            ->add('title',     TextType::class, array(
                'label' => "oc.advert.form.label.title",
            ))
            ->add('content', CkeditorType::class, array(
                'label' => "oc.advert.form.label.content",
            ))
            ->add('categories', EntityType::class, array(
                'class'        => 'OCPlatformBundle:Category',
                'choice_label' => 'name',
                'multiple'     => true,
                'label' => "oc.advert.form.label.category",
                'required'     => false
                // 'query_builder' => function(CategoryRepository $repository) use($pattern) {
                //   return $repository->getLikeQueryBuilder($pattern);
                // }
            ))
            ->add('published', CheckboxType::class, array(
                'label' => "oc.advert.form.label.published",
                'required' => false
            ))
            ->add('save', SubmitType::class, array(
                'label' => "oc.advert.form.label.save",
            ))
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                    function(FormEvent $event) { 

                        $advert = $event->getData();

                        if (null === $advert)
                            return;

                        // Si l'annonce est déjà publiée
                        if ($advert->getPublished())
                            $event->getForm()->remove('published');


                        // si il n'y a pas d'image alors on ne propose pas de suppimer l'image
                        if ($advert->getImage() === null)
                            $event->getForm()->remove('delete_image');

                    }
            )
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                    function (FormEvent $event) {

                        $advert = $event->getData();
                        $form = $event->getForm();

                        if (!$advert)
                            return;

                        // on ne traite pas l'upload si il y a demande de suppression
                        if (isset($advert['delete_image']))
                            $form->remove('image');

                    }
            )

            ->addEventListener(
                FormEvents::POST_SUBMIT,
                    function (FormEvent $event) {

                        $advert = $event->getData();

                        if (!$advert)
                        return;

                        // on passe l'image à null si demande de suppression
                        if ($advert->getDeleteImage()) {

                            $advert->oldFile = $advert->getImage();
                            $advert->setImage();
                        }

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
            'allow_extra_fields' => true,
            'data_class'         => 'OC\PlatformBundle\Entity\Advert'
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
