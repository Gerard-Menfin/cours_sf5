<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('resume')
            ->add('couverture', FileType::class, [
                /* L'option 'mapped' avec la valeur false signifie que ce champ de formulaire
                    ne sera pas lié à une propriété de l'objet Livre utilisé pour générer ce
                    formulaire. Donc la modifiaction de ce champ du formulaire ne modifiera
                    pas automatiquement les valeurs de l'objet Livre  */
                "mapped"        => false,
                "required"      => false,
                "label"         => "Couverture du livre",
                "constraints"   => [
                    new Image([
                        "mimeTypes" => [ "image/gif", "image/png", "image/jpeg" ],
                        "mimeTypesMessage" => "Les formats autorisés sont gif, png, jpg",
                        "maxSize" => "2048k",
                        "maxSizeMessage" => "Le fichier ne doit pas peser plus de 2Mo"
                    ])
                ]
            ])
            ->add('auteur', EntityType::class, [
                "class" => Auteur::class,
                "choice_label" => "nom",
                "placeholder" => "choisissez un auteur..."
            ])
            ->add('categories', EntityType::class, [
                "class"         => Categorie::class,
                "choice_label"  => "libelle",
                "multiple"      => true,
                "expanded"      => true,
                "label"         => "Catégories"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
