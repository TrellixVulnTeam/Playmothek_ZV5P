<?php

namespace App\Form;

use App\Entity\Pages;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PagesType extends AbstractType
{
     
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $networks= [
            "Facebook" => "Facebook",
            "Instagram" => "Instagram",
            "Twitter" => "Twitter",
            "Youtube" => "Youtube",
            "A précisier" => "Plus tard"
        ];

        $builder
            ->add('presentation', CKEditorType::class, [])
            ->add('networks', ChoiceType::class, [
                'choices' => $networks,
                'expanded' => true,
            ])
            ->add('user', EntityType::class, [
                'class' => Users::class,
                // choix par id + pseudo
                'choice_label' => 'page_for_user',
                // enregistrement de l'id
                'query_builder' => function (UsersRepository $user_id) {
                    return $user_id->createQueryBuilder('id')
                        ->orderBy('id.firstname', 'ASC');                       
                }
            ])

            // ->add('picture', FileType::class, [
            //     'data_class' => null,
            //     // 'multiple' => true,
            //     'constraints' => [
            //         new File([                        
            //             'maxSize' => '10M',
            //             'mimeTypes' => [
            //                 'image/jpg',
            //                 'image/jpeg',
            //                 'image/png',
            //             ],
            //             'mimeTypesMessage' => 'error image',
            //         ])
            //     ],
            // ])

            #~Field Images not mapped BDD~
            ->add('images', FileType::class,[
                'data_class' => null,
                'required' => false,
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                // 'constraints' => [
                //     new File([
                //         'maxSize' => '10M',
                //         'mimeTypes' => [
                //             'image/jpg',
                //             'image/jpeg',
                //             'image/png'
                //         ],
                //         'mimeTypesMessage' => 'error Image'
                //     ])
                // ]
            ])

            ->add('Valider', SubmitType::class, [
                'attr' =>[
                    'class' => 'btn_play'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pages::class,
        ]);
    }
}
