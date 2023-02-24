<?php

namespace App\Controller\Admin\Job;

use App\Entity\Job\Job;
use App\Entity\Job\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class JobCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Job::class;
    }


    public function configureFields(string $pageName): iterable
    {
        // $fields = parent::configureFields($pageName);
        $fields = [
            TextField::new('title'),
            SlugField::new('slug')->setTargetFieldName('title')->hideOnIndex(),
            TextEditorField::new('description')->onlyOnForms(),
            TextField::new('location')->onlyOnForms(),
            IntegerField::new('experience'),
            IntegerField::new('salaryMin'),
            IntegerField::new('salaryMax'),
            DateTimeField::new('deadline'),
            CountryField::new('country'),
            TextField::new('city'),
            TextField::new('fullAddress')->onlyOnForms(),
            AssociationField::new('categories')
                ->setFormType(EntityType::class)
                ->setFormTypeOptions([
                    'class' => Category::class,
                    'multiple' => true,
                    'expanded' => true,
                ]),

        ];

        return array_merge($fields, [
            AssociationField::new('requiredSkills')->onlyOnForms(),
        ]);
    }
/*
    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addWebpackEncoreEntry('admin-form-editor')
            ->addCssFile('bundles/kmsfroalaeditor')
            ;
    }*/
}
