<?php

namespace App\DataFixtures;

use App\Entity\Dish;
use App\Entity\Ingredient;
use App\Entity\Step;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DishFixture extends Fixture implements DependentFixtureInterface
{
    public const DISH_NAME = "amazing dish";
    public const DISH_REFERENCE = "first-dish";
    public const DISH_DESCRIPTION = "This is the most amazing dish ever";

    public function load(ObjectManager $manager): void
    {
        $ings = [];
        /** @var Ingredient $firstIng */
        $firstIng = $this->getReference(IngredientFixture::FIRST_INGREDIENT_REFERENCE);
        $ings[] = $firstIng;
        /** @var Ingredient $secondIng */
        $secondIng = $this->getReference(IngredientFixture::SECOND_INGREDIENT_REFERENCE);
        $ings[] = $secondIng;

        $steps = [];
        /** @var Step $firstStep */
        $firstStep = $this->getReference(StepFixture::FIRST_STEP_REFERENCE);
        $steps[] = $firstStep;
        /** @var Step $secondStep */
        $secondStep = $this->getReference(StepFixture::SECOND_STEP_REFERENCE);
        $steps[] = $secondStep;

        $dish = new Dish();
        $dish->setName(self::DISH_NAME);
        $dish->setDescription(self::DISH_DESCRIPTION);
        $dish->addIngredients($ings);
        $dish->addSteps($steps);
        $manager->persist($dish);
        $manager->flush();

        $this->addReference(self::DISH_REFERENCE, $dish);
    }

    public function getDependencies(): array
    {
        return [
            IngredientFixture::class,
            StepFixture::class
        ];
    }

}
