<?php

namespace App\Form;

use App\Entity\Advertising;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertisingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('image')
            ->add('content')
            ->add('imageFile', VichImageType::class, [
                'required'        => false,
                'allow_delete'    => false,
                'delete_label'    => false,
                'download_label'  => false,
                'download_uri'    => false,
                'image_uri'       => false,
                'imagine_pattern' => false,
                'asset_helper'    => false,
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Advertising::class,
        ]);
    }
}
