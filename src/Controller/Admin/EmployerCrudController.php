<?php

namespace App\Controller\Admin;

use App\Entity\Employer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EmployerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Employer::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
