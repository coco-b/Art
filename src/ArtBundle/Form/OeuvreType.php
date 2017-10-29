<?php
/**
 * Created by PhpStorm.
 * User: cecileberger
 * Date: 22/10/2017
 * Time: 20:20
 */

namespace ArtBundle\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

class OeuvreType extends AbstractType
    {

        public function buildForm(FormBuilderInterface $builder, array $options)
        {



            $builder
                ->add('title', TextType::class)
                ->add('size', TextType::class)
                ->add('price', IntegerType::class)
                ->add('datetime', DateTimeType::class)
                ->add('link', TextType::class)
                ->add('picture',FileType::class, array('label' => 'Picture'))
                ->add('description', TextareaType::class)
                ->add('submit',SubmitType::class, array('label'=>'valider'));
        }

        /**
         * {@inheritdoc}
         */
        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults(array(
                'data_class' => 'ArtBundle\Entity\Oeuvre'
            ));
        }

        /**
         * {@inheritdoc}
         */

        public function getBlockPrefix()
        {
            return 'artbundle_oeuvre';
        }
}