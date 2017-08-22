<?php

namespace Macao\JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Doctrine\ORM\EntityRepository;

class JobType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                    'label' => 'Titre'))
            ->add('category', EntityType::class, array(
                    'class'    => 'MacaoJobBundle:Category',
                    'query_builder' => function(EntityRepository $repository) { 
                        return $repository->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                    },
                    'choice_label' => 'name',
                    'label' => 'Catégorie'))
            ->add('authorName', TextType::class, array(
                    'label' => 'Nom'))
            ->add('authorEmail', TextType::class, array(
                    'label' => 'Email'))
            ->add('authorTelephone', TextType::class, array(
                    'label' => 'Téléphone'))
            ->add('content', CKEditorType::class, array(
                    'label' => "Texte de l'annonce",
                    'config' => array(
                        'uiColor' => '#ffffff'
                    )
                )
            )
            ->add('published', CheckboxType::class, array(
                    'label' => 'Visible',
                    'required' => false))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Macao\JobBundle\Entity\Job'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'job';
    }
}