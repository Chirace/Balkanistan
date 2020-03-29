<?php 
namespace App\Form\Type; 
use Symfony\Component\Form\AbstractType; 
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Form\FormBuilderInterface; 
use Symfony\Component\OptionsResolver\OptionsResolver; 
use App\Entity\Parti;

class PartiType extends AbstractType {     
    public function buildForm(FormBuilderInterface $builder, array $options) {   
        $builder->add('nom', TextType::class);
    }     
    
    public function configureOptions(OptionsResolver $resolver) {         
        $resolver->setDefaults(array(             
            'data_class' => Parti::class,         
        ));     
    } 
}