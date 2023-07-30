<?php

namespace App\Form;

use App\Entity\Carousel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarouselFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre')
        ->add('image')
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

        $builder
        ->add('titre')
        ->add('image')
        ->add('imageFile1', VichImageType::class, [
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
        $builder
        ->add('titre')
        ->add('image')
        ->add('imageFile2', VichImageType::class, [
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
        $builder
        ->add('titre')
        ->add('image')
        ->add('imageFile3', VichImageType::class, [
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
        $builder
        ->add('titre')
        ->add('image')
        ->add('imageFile4', VichImageType::class, [
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
            'data_class' => Carousel::class,
        ]);
    }
}
