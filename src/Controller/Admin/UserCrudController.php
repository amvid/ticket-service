<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
            yield TextField::new('id')->hideOnForm()->hideOnIndex();
            yield EmailField::new('email');
            yield TextField::new('firstName');
            yield TextField::new('lastName');
            yield TextField::new('password')->setFormType(PasswordType::class)->hideOnIndex()->hideOnDetail();
            yield DateTimeField::new('createdAt')->hideOnForm()->hideOnIndex();
            yield DateTimeField::new('updatedAt')->hideOnForm()->hideOnIndex();

        if ($this->isGranted(User::ADMIN)) {
            yield ArrayField::new('roles');
            yield BooleanField::new('isActive');
        }
    }
}
