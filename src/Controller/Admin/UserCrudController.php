<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        if (!$this->isGranted(User::ADMIN)) {
            $actions->remove(Crud::PAGE_INDEX, Action::NEW);
        }

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('id')->hideOnForm()->hideOnIndex();
        yield EmailField::new('email')->onlyWhenCreating();
        yield EmailField::new('email')->onlyWhenUpdating()->setDisabled();
        yield TextField::new('firstName');
        yield TextField::new('lastName');

        if ($this->isGranted(User::ADMIN)) {
            yield ArrayField::new('roles');
        }

        if ($this->isGranted(User::MANAGER)) {
            yield BooleanField::new('isActive');
        }

        yield DateTimeField::new('createdAt')->hideOnForm()->hideOnIndex();
        yield DateTimeField::new('updatedAt')->hideOnForm()->hideOnIndex();

        yield FormField::addPanel('Change password')->setIcon('fa fa-key');
        yield TextField::new('password', 'New password')->onlyWhenCreating()->setRequired(true)
            ->setFormType(RepeatedType::class)
            ->setFormTypeOptions([
                'type' => PasswordType::class,
                'first_options' => ['label' => 'New password'],
                'second_options' => ['label' => 'Repeat password'],
                'error_bubbling' => true,
                'invalid_message' => 'The password fields do not match.',
            ]);
        yield TextField::new('password', 'New password')->onlyWhenUpdating()->setRequired(false)
            ->setFormType(RepeatedType::class)
            ->setFormTypeOptions([
                'type' => PasswordType::class,
                'first_options' => ['label' => 'New password'],
                'second_options' => ['label' => 'Repeat password'],
                'error_bubbling' => true,
                'invalid_message' => 'The password fields do not match.',
            ]);
    }

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $plainPassword = $entityDto->getInstance()?->getPassword();
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);

        if (empty($plainPassword)) {
            return $formBuilder;
        }

        $this->addHashPasswordEventListener($formBuilder, $plainPassword);

        return $formBuilder;
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);
        $this->addHashPasswordEventListener($formBuilder);

        return $formBuilder;
    }

    protected function addHashPasswordEventListener(FormBuilderInterface $formBuilder, $plainPassword = null): void
    {
        if (empty($plainPassword)) {
            return;
        }

        $formBuilder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($plainPassword) {
            $user = $event->getData();

            if ($user->getPassword() !== $plainPassword) {
                $user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));
            }
        });
    }
}
