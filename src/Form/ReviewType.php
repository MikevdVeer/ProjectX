<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * ReviewType Form Class
 * 
 * This form handles the creation and editing of Review entities.
 * It provides fields for the review title and description with proper validation.
 */
class ReviewType extends AbstractType
{
    /**
     * Builds the form structure
     * 
     * @param FormBuilderInterface $builder - The form builder instance
     * @param array $options - Form options array
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Title field - Single line text input
            ->add('title', TextType::class, [
                'label' => 'Review Title', // Label displayed above the field
                'attr' => [
                    'class' => 'form-control', // Bootstrap CSS class for styling
                    'placeholder' => 'Enter a title for your review' // Placeholder text
                ]
            ])
            // Description field - Multi-line textarea
            ->add('description', TextareaType::class, [
                'label' => 'Review Description', // Label displayed above the field
                'attr' => [
                    'class' => 'form-control', // Bootstrap CSS class for styling
                    'rows' => 4, // Number of visible rows in the textarea
                    'placeholder' => 'Share your thoughts about this template...' // Placeholder text
                ]
            ]);
    }

    /**
     * Configures form options and validation
     * 
     * @param OptionsResolver $resolver - The options resolver instance
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class, // Links this form to the Review entity
        ]);
    }
} 