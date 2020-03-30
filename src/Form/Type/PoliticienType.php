<?php 
namespace App\Form\Type; 
use Symfony\Component\Form\AbstractType; 
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\OptionsResolver\OptionsResolver; 
use App\Entity\Politicien;
use App\Entity\Parti;
use App\Entity\Mairie;
use App\Entity\Affaire;

class PoliticienType extends AbstractType {     
    public function buildForm(FormBuilderInterface $builder, array $options) {   
        $builder->add('nom', TextType::class)
                ->add('sexe', TextType::class)
                ->add('age', TextType::class)
                ->add('parti', EntityType::class, [
                    'class' => Parti::class,
                    'choice_label' => 'nom',
                ])
                ->add('mairie', EntityType::class, [
                    'class' => Mairie::class,
                    'choice_label' => 'ville',]
                    //'-----' => null,
                );
    }     
    
    public function configureOptions(OptionsResolver $resolver) {         
        $resolver->setDefaults(array(             
            'data_class' => Politicien::class,         
        ));     
    } 
} 