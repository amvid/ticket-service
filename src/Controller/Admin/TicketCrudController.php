<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Ticket;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TicketCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ticket::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        if (!$this->isGranted(User::ADMIN)) {
            $actions->remove(Crud::PAGE_INDEX, Action::DELETE);
            $actions->remove(Crud::PAGE_DETAIL, Action::DELETE);
        }

        $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
        $actions->remove(Crud::PAGE_INDEX, Action::NEW);

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('id')->hideOnForm()->hideOnDetail();
        yield AssociationField::new('category');
        yield AssociationField::new('agent');
        yield ChoiceField::new('status')->setChoices(Ticket::STATUSES);
        yield TextField::new('info')->hideOnIndex()->setDisabled();
        yield TextareaField::new('additionalInfo')->hideOnIndex()->setDisabled();
        yield TextareaField::new('comments')->hideOnIndex();

        yield FormField::addPanel('Client')->setIcon('fa fa-user');
        yield TextField::new('clientName')->hideOnIndex()->setDisabled();
        yield TextField::new('clientEmail')->hideOnIndex()->setDisabled();
        yield TextField::new('clientPhone')->hideOnIndex()->setDisabled();

        yield FormField::addPanel('Timestamp')->setIcon('fa fa-clock')->hideOnForm();
        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->hideOnForm()->hideOnIndex();
        yield DateTimeField::new('completedAt')->hideOnForm();
    }
}