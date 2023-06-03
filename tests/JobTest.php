<?php

namespace App\Tests;

use App\Entity\Job\Category;
use App\Factory\Job\CategoryFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;

class JobTest extends KernelTestCase
{
    use Factories;

    public function testValidJobCategoryEntity(): void
    {
        $category = CategoryFactory::createOne()->object();
        $this->assertHasErrors($category, 0);
    }

    public function testInvalidJobCategoryEntity(): void
    {
        $category = CategoryFactory::createOne()->object();
        $this->assertHasErrors($category->setName(''), 1);
    }

    public function testInvalidDuplicatedJobCategoryEntity(): void
    {
        $category = CategoryFactory::createMany(2, ['name' => 'Cat']);
        $this->assertHasErrors($category->setName(''), 1);
    }

    private function assertHasErrors(Category $category, int $number = 0): void {
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($category);
        $this->assertCount($number, $errors);
    }
}
