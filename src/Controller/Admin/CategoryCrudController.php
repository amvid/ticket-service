<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Categories');

        return $crud->showEntityActionsInlined();
    }

    public function configureActions(Actions $actions): Actions
    {
        // add
        $actions->add(Crud::PAGE_INDEX, Action::DETAIL);

        // update
        $actions->update(
            Crud::PAGE_INDEX,
            Action::EDIT,
            fn(Action $action) => $action->setIcon('fa fa-pencil')->setLabel(false)
        );

        $actions->update(
            Crud::PAGE_INDEX,
            Action::DETAIL,
            fn(Action $action) => $action->setIcon('fa fa-eye')->setLabel(false)
        );

        $actions->update(
            Crud::PAGE_INDEX,
            Action::DELETE,
            fn(Action $action) => $action->setIcon('fa fa-trash-o')->addCssClass('text-danger')->setLabel(false),
        );

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('id')->hideOnForm()->hideOnIndex();
        yield TextField::new('name');
        yield TextField::new('code');
    }
}