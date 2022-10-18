<?php

namespace App\Controller\Admin;

use App\Entity\Membre;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MembreCrudController extends AbstractCrudController
{
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        // je crée un constructeur pour appeler le service UserPasswordHasherInterface
        $this->hasher = $hasher;
    }
    
    public static function getEntityFqcn(): string
    {
        return Membre::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('pseudo'),
            TextField::new('email'),
            TextField::new('prenom'),
            TextField::new('nom'),
            ChoiceField::new('Civilite')->setChoices([
                
                'M' => 'Homme',
                'Mme' => 'Femme',
               
            ]),
            DateTimeField::new('createdAt')->setFormat("d/M/Y à H:m:s"),
            TextField::new('password','Mot de passe')->setFormType(PasswordType::class)->onlyWhenCreating(),
            CollectionField::new('roles')->setTemplatePath('admin/field/roles.html.twig'),

        ];

    }
    public function createEntity(string $entityFqcn)
        {
        
        $membre =new $entityFqcn; 
        $membre->setCreatedAt(new \DateTime);
        return $membre;
        }
   
}
