<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Ticket;
use App\Entity\User;
use App\Repository\TicketRepositoryInterface;
use DateTimeImmutable;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TicketCrudController extends AbstractCrudController
{
    public function __construct(private readonly TicketRepositoryInterface $ticketRepository)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Ticket::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $crud->setPageTitle(Crud::PAGE_INDEX, 'Tickets');
        $crud->setSearchFields(['agent.firstName', 'agent.email', 'clientPhone', 'clientName', 'clientEmail']);
        $crud->setDefaultSort(['createdAt' => 'DESC']);

        return $crud->showEntityActionsInlined();
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters
            ->add('clientEmail')
            ->add('clientPhone')
            ->add('clientName')
            ->add('agent')
            ->add('category')
            ->add(ChoiceFilter::new('status')->setChoices(Ticket::STATUSES));

        return $filters;
    }

    public function configureActions(Actions $actions): Actions
    {
        $takeTicket = Action::new('takeTicket', 'Take')
            ->linkToCrudAction('takeTicket')
            ->setIcon('fa fa-hand-grab-o')
            ->setLabel(false)
            ->displayIf(
                static fn(Ticket $ticket) => $ticket->getStatus() !== Ticket::ASSIGNED
                    && $ticket->getStatus() !== Ticket::DONE
            );

        $completeTicket = Action::new('completeTicket', 'Done')
            ->linkToCrudAction('completeTicket')
            ->setIcon('fa fa-check')
            ->addCssClass('text-success')
            ->setLabel(false)
            ->displayIf(static fn(Ticket $ticket) => $ticket->getStatus() === Ticket::ASSIGNED);

        // add
        $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
        $actions->add(Crud::PAGE_INDEX, $takeTicket);
        $actions->add(Crud::PAGE_INDEX, $completeTicket);

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

        // remove
        $actions->remove(Crud::PAGE_INDEX, Action::NEW);

        // permissions
        $actions->setPermission(Action::DELETE, User::ADMIN);

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('id')->onlyOnIndex();
        yield AssociationField::new('category');
        yield AssociationField::new('agent');
        yield ChoiceField::new('status')->setChoices(Ticket::STATUSES);
        yield TextField::new('info')->hideOnIndex()->setDisabled();
        yield TextareaField::new('additionalInfo')->hideOnIndex()->setDisabled();
        yield TextareaField::new('comments')->hideOnIndex();

        yield FormField::addPanel('Client')->setIcon('fa fa-user');
        yield TextField::new('clientName')->setLabel('Name')->hideOnIndex()->setDisabled();
        yield TextField::new('clientEmail')->setLabel('Email')->hideOnIndex()->setDisabled();
        yield TextField::new('clientPhone')->setLabel('Phone')->hideOnIndex()->setDisabled();

        yield FormField::addPanel('Timestamp')->setIcon('fa fa-clock')->hideOnForm();
        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->onlyOnDetail();
        yield DateTimeField::new('completedAt')->hideOnForm();
    }

    public function takeTicket(AdminContext $context): RedirectResponse
    {
        /** @var Ticket $ticket */
        $ticket = $context->getEntity()->getInstance();

        $ticket
            ->setStatus(Ticket::ASSIGNED)
            ->setAgent($context->getUser());

        $this->ticketRepository->save($ticket, true);

        return $this->redirectToRoute('admin', [
            'crudAction' => Action::DETAIL,
            'entityId' => $ticket->getId(),
            'crudControllerFqcn' => self::class,
        ]);
    }

    public function completeTicket(AdminContext $context): RedirectResponse
    {
        /** @var Ticket $ticket */
        $ticket = $context->getEntity()->getInstance();

        $ticket
            ->setStatus(Ticket::DONE)
            ->setCompletedAt(new DateTimeImmutable('now'));

        $this->ticketRepository->save($ticket, true);

        return $this->redirectToRoute('admin', [
            'crudAction' => Action::INDEX,
            'crudControllerFqcn' => self::class,
        ]);
    }
}
