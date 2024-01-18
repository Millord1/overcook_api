<?php

namespace App\DataFixtures;

use App\Entity\Dish;
use App\Entity\Recipe;
use App\Entity\Tags;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RecipeFixture extends Fixture implements DependentFixtureInterface
{
    public const RECIPE_NAME = "Recipe for kitchen's noobs";
    public const RECIPE_REFERENCE = "first-recipe";

    public function load(ObjectManager $manager): void
    {
        /** @var Dish $dish */
        $dish = $this->getReference(DishFixture::DISH_REFERENCE);

        $tags = [];
        /** @var Tags $firstTag */
        $firstTag = $this->getReference(TagFixture::FIRST_TAG_REFERENCE);
        $tags[] = $firstTag;
        /** @var Tags $secondTag */
        $secondTag = $this->getReference(TagFixture::SECOND_TAG_REFERENCE);
        $tags[] = $secondTag;

        $recipe = new Recipe();
        $recipe->setName(self::RECIPE_NAME);
        $recipe->setDish($dish);
        $recipe->addTags($tags);
        $manager->persist($recipe);
        $manager->flush();

        $this->addReference(self::RECIPE_REFERENCE, $recipe);
    }

    public function getDependencies(): array
    {
        return [
            DishFixture::class,
            TagFixture::class
        ];
    }
}
