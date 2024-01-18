<?php

namespace App\DataFixtures;

use App\Entity\Quantity;
use App\Entity\Unity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuantityFixture extends Fixture implements DependentFixtureInterface
{

    public const QUANTITY = 9;
    public const QUANTITY_REFERENCE = "first-qtt";

    public function load(ObjectManager $manager): void
    {
        $quantity = new Quantity();
        $quantity->setQuantity(self::QUANTITY);

        // Add unity relationship
        /** @var Unity $unity */
        $unity = $this->getReference(UnityFixture::UNITY_REFERENCE);
        $quantity->addUnity($unity);

        $manager->persist($quantity);
        $manager->flush();

        $this->addReference(self::QUANTITY_REFERENCE, $quantity);
    }

    public function getDependencies(): array
    {
        return [
            UnityFixture::class,
        ];
    }
}