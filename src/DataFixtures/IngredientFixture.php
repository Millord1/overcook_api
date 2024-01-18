<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Quantity;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class IngredientFixture extends Fixture implements DependentFixtureInterface
{
    public const FIRST_INGREDIENT_NAME = "first ing";
    public const SECOND_INGREDIENT_NAME = "second ing";
    public const FIRST_INGREDIENT_REFERENCE = "first-ing";
    public const SECOND_INGREDIENT_REFERENCE = "second-ing";

    public function load(ObjectManager $manager): void
    {
        // get same type and qtt for both ingredients
        /** @var Type $type */
        $type = $this->getReference(TypeFixture::TYPE_REFERENCE);
        /** @var Quantity $quantity */
        $quantity = $this->getReference(QuantityFixture::QUANTITY_REFERENCE);

        $ingredient = new Ingredient();
        $ingredient->setName(self::FIRST_INGREDIENT_NAME);
        $ingredient->setType($type);
        $ingredient->addQuantity($quantity);
        $manager->persist($ingredient);

        $secondIngredient = new Ingredient();
        $secondIngredient->setName(self::SECOND_INGREDIENT_NAME);
        $secondIngredient->setType($type);
        $secondIngredient->addQuantity($quantity);
        $manager->persist($secondIngredient);
        $manager->flush();

        $this->addReference(self::FIRST_INGREDIENT_REFERENCE, $ingredient);
        $this->addReference(self::SECOND_INGREDIENT_REFERENCE, $secondIngredient);
    }

    public function getDependencies(): array
    {
        return [
            TypeFixture::class,
            QuantityFixture::class
        ];
    }
}
