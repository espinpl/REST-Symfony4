<?php
 
namespace App\Form;
 
use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
 
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
 
class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label' => 'Użytkownik'])
            ->add('password', PasswordType::class, ['label' => 'Hasło'])
            ->add('email', EmailType::class, ['label' => 'E-mail'])        
            ->add('firstname', TextType::class, ['label' => 'Imię', 'required' => false])
            ->add('lastname', TextType::class, ['label' => 'Nazwisko', 'required' => false])            
            ->add('status', CheckboxType::class, ['label' => 'aktywny', 'required' => false])
            //->add('createdAt', DateTimeType::class)            
            ->add('save', SubmitType::class, ['label' => 'ZAREJESTRUJ'])
        ;
    }
 
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}